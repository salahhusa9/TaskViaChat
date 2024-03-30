<?php

namespace App\Jobs\Webhooks\Whatsapp;

use App\Enums\WhatsappSessionStatus;
use App\Models\WhatsappSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SessionStatusEventHandler implements ShouldQueue
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
            $whatsapp_session = WhatsappSession::where('id', str_replace('session-', '', $session_name))->first();
        }

        if ($whatsapp_session) {
            $status = $this->content['payload']['status'];

            if (WhatsappSessionStatus::tryFrom($status)) {
                $whatsapp_session->status = WhatsappSessionStatus::from($status);
                $whatsapp_session->save();
            } else {
                info('Status not found: ' . $status, [
                    'content' => $this->content
                ]);
            }

            if (WhatsappSessionStatus::tryFrom($status) == WhatsappSessionStatus::WORKING) { // this becouse some person won in put phone number in creating
                $phone_number = explode('@', $this->content['me']['id'])[0];
                $whatsapp_session->phone_number = $phone_number;
                $whatsapp_session->session_push_name = $this->content['me']['pushName'];
                $whatsapp_session->session_id = $this->content['me']['id'];
                $whatsapp_session->session_name = $this->content['session'];
                $whatsapp_session->save();
            }
        }
    }
}
