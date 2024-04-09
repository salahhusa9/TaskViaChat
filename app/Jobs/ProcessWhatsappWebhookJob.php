<?php

namespace App\Jobs;

use App\Jobs\Webhooks\Whatsapp\MessageEventHandler;
use App\Jobs\Webhooks\Whatsapp\MessageReactionEventHandler;
use App\Jobs\Webhooks\Whatsapp\SessionStatusEventHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWhatsappWebhookJob extends SpatieProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $content = $this->webhookCall->payload;

        switch ($content['event']) {
            case 'session.status':
                SessionStatusEventHandler::dispatch($content);
                break;

            case 'message':
                MessageEventHandler::dispatch($content);
                break;

            case 'message.reaction':
                MessageReactionEventHandler::dispatch($content);
                break;

            default:
                info('Event not found: ' . $content['event'], [
                    'payload' => $content
                ]);
                break;
        }
    }
}
