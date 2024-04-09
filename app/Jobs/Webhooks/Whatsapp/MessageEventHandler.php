<?php

namespace App\Jobs\Webhooks\Whatsapp;

use App\Models\WhatsappSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class MessageEventHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $content
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $session_name = $this->content['session'];
        $whatsapp_session = null;

        if (env('WHATSAPP_TEST_MODE')) {
            $whatsapp_session = WhatsappSession::first();
        } else {
            $whatsapp_session = WhatsappSession::where('session_name', $session_name)->first();
        }

        if ($whatsapp_session) {
            $payload = $this->content['payload'];

            if (!empty($payload['body'])) {
                $description = $payload['body'];
            } else {
                if ($payload['hasMedia']) {
                    // check type of media
                    $media_type = explode('/', $payload['_data']['mimetype'])[0];
                    $description = 'Media type: ' . $media_type;
                    $duration = $payload['_data']['duration'] ?? 0;
                    if ($media_type === 'audio') {
                        $description .= ', duration: ' . Carbon::createFromTimestamp($duration)->format('i:s');
                    } elseif ($media_type === 'image') {
                        $description .= ', size: ' . Number::fileSize($payload['_data']['size']);
                    } elseif ($media_type === 'video') {
                        $description .= ', duration: ' . Carbon::createFromTimestamp($duration)->format('i:s') . ', size: ' . Number::fileSize($payload['_data']['size']);
                    }
                } else {
                    $description = 'Empty message';
                }
            }

            $whatsapp_session->messages()->create([
                'message_id' => $payload['id'],
                'timestamp' => $payload['timestamp'],
                'from' => $payload['from'],
                'to' => $payload['to'],
                'body' => $payload['body'] ?? $description,
                'description' => $description,
                'hasMedia' => $payload['hasMedia'],
            ]);
        }
    }
}
