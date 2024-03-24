<?php

namespace App\Jobs\Webhooks\Whatsapp;

use App\Enums\NumberStatus;
use App\Models\Number;
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
        $number = null;

        if (config('services.whatsapp_api.test_mode')) {
            $number = Number::where('phone_number', config('services.whatsapp_api.default_number'))->first();
        } else {
            $number = Number::where('id', str_replace('session-', '', $session_name))->first();
        }

        if ($number) {
            $status = $this->content['payload']['status'];

            if (NumberStatus::tryFrom($status)) {
                $number->status = NumberStatus::from($status);
                $number->save();
            } else {
                info('Status not found: ' . $status, [
                    'content' => $this->content
                ]);
            }

            if (NumberStatus::tryFrom($status) == NumberStatus::WORKING) { // this becouse some person won in put phone number in creating
                $phone_number = explode('@', $this->content['me']['id'])[0];
                $number->phone_number = $phone_number;
                $number->save();
            }
        }
    }
}
