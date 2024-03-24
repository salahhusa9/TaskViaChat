<?php

namespace App\Jobs\WhatsappApi;

use App\Enums\NumberStatus;
use App\Models\Number;
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
        public $number_id
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get number
        $number = Number::findOrFail($this->number_id);

        // check if number exists
        if ($number) {
            // check if number is not working
            if (
                $number->status != NumberStatus::WORKING
                or
                $number->status != NumberStatus::SCAN_QR_CODE
                or
                $number->status != NumberStatus::STARTING
            ) {
                $response = Http::withHeaders([
                    'X-Api-Key' => config('whatsapp_api.api_key'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post(config('services.whatsapp_api.base_url') . '/sessions/start', [
                    // 'name' => 'session-' . $number->phone_number,
                    'name' => 'default',
                    'config' => [
                        'webhooks' => [
                            [
                                'url' => url(route('webhook-client-default')),
                                'events' => [
                                    'session.status',
                                    'message.any',
                                    'message.reaction',
                                ]
                            ]
                        ]
                    ]
                ]);

                if ($response->created()) {
                    // update status to starting
                    $number->update([
                        'status' => NumberStatus::STARTING,
                    ]);
                } else {
                    // update status to not working
                    $number->update([
                        'status' => NumberStatus::FAILED,
                    ]);

                    info('Failed to start session', [
                        'number_id' => $number->id,
                        'response' => $response->json(),
                    ]);
                }
            }
        }
    }
}
