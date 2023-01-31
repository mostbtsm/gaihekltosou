<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mailsending.notice.send_from'), mb_encode_mimeheader(config('mailsending.notice.sender')))
                    ->subject($this->data['subject'])
                    ->text('emails.notice')
                    ->with([
                        'contents' => $this->data['contents'],
                    ]);
    }
}
