<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Approve extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mailsending.approve.send_from'), mb_encode_mimeheader(config('mailsending.approve.sender')))
                    ->subject(config('mailsending.approve.subject'))
                    ->text('emails.approve_painter')
                    ->with([
                        'app_name' => config('const.app_name'),
                        'url'  => route('painter.login'),
                    ]);
    }
}
