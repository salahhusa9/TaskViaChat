<?php

namespace App\Jobs\WhatsappApi;

use App\Enums\WhatsappSessionStatus;
use App\Models\WhatsappSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class StartSessionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $whatsapp_session_id
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get whatsapp_session
        $whatsapp_session = WhatsappSession::with('whatsappSessionServer')->findOrFail($this->whatsapp_session_id);

        // check if whatsapp_session exists
        if ($whatsapp_session) {
            // check if whatsapp_session is not working
            if (
                $whatsapp_session->status != WhatsappSessionStatus::WORKING
                or
                $whatsapp_session->status != WhatsappSessionStatus::SCAN_QR_CODE
                or
                $whatsapp_session->status != WhatsappSessionStatus::STARTING
            ) {

                $session_name = env('WHATSAPP_TEST_MODE') ? 'default' : 'session-' . $whatsapp_session->id;

                $response = Http::withHeaders([
                    'X-Api-Key' => $whatsapp_session->whatsappSessionServer->secret,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post(
                    'https://' . $whatsapp_session->whatsappSessionServer->host . ':' . $whatsapp_session->whatsappSessionServer->port . '/api/sessions/start',
                    [
                        'name' => $session_name,
                        'config' => [
                            'webhooks' => [
                                [
                                    'url' => env('WHATSAPP_API_WEBHOOK_URL'),
                                    'events' => [
                                        'session.status',
                                        'message',
                                        // 'message.any',
                                        'message.reaction',
                                    ]
                                ]
                            ]
                        ]
                    ]
                );

                if ($response->created()) {
                    // update status to starting
                    $whatsapp_session->update([
                        'session_name' => $session_name,       // name of session in server   ex: defualt
                        'status' => WhatsappSessionStatus::STARTING,
                    ]);
                } else {
                    // update status to not working
                    $whatsapp_session->update([
                        'status' => WhatsappSessionStatus::FAILED,
                    ]);

                    // todo retry job

                    info('Failed to start session', [
                        'whatsapp_session_id' => $whatsapp_session->id,
                        'response' => $response->json(),
                    ]);
                }
            }
        }
    }
}
