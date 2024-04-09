<?php

namespace App\Jobs\Webhooks\Whatsapp;

use App\Models\WhatsappSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessageReactionEventHandler implements ShouldQueue
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

            if ($payload['fromMe'] == true) {
                $whatsapp_message = $whatsapp_session->messages()->where('message_id', $payload['reaction']['messageId'])->first();

                if ($whatsapp_message) {
                    if (empty($payload['reaction']['text'])) {
                        $whatsapp_message->task()->delete();
                        $whatsapp_message->reaction()->delete();
                    } else {
                        $whatsapp_message->reaction()->create([
                            'message_id' => $payload['id'],
                            'reaction' => $payload['reaction']['text']
                        ]);

                        $task_status = $whatsapp_session->taskStatuses()->where('emoji', $payload['reaction']['text'])->first();

                        if ($task_status) {
                            // create task
                            $whatsapp_message->task()->create([
                                'title' => $whatsapp_message->body ?? 'Task - ' . explode('@', $payload['to'])[0] . ' - ' . now(),
                                'description' => $whatsapp_message->description,
                                'task_status_id' => $task_status->id,
                                'whatsapp_session_id' => $whatsapp_session->id,
                                'whatsapp_chat_id' => $payload['to'],
                            ]);
                        }
                    }
                } else {
                    info('Message not found in reaction', [
                        'payload' => $payload
                    ]);
                }
            }
        }
    }
}
