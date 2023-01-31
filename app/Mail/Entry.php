<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Entry extends Mailable
{
    use Queueable, SerializesModels;

    private $template;

    private $title;

    private $id;

    private $name;

    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $title, $id, $email, $name)
    {
        $this->template = $template;
        $this->title = $title;
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mailsending.entry.send_from'), mb_encode_mimeheader(config('mailsending.entry.sender')))
                    ->subject($this->title)
                    ->text('emails.' . $this->template)
                    ->with([
                        'id'    => $this->id,
                        'email' => $this->email,
                        'name'  => $this->name,
                    ]);
    }
}
