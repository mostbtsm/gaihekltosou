<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    private $template;

    private $userType;

    private $title;

    private $name;

    private $email;

    private $contents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $userType, $title, $email, $name, $contents)
    {
        $this->template = $template;
        $this->userType = $userType;
        $this->title = $title;
        $this->email = $email;
        $this->name = $name;
        $this->contents = $contents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mailsending.contact.send_from'), mb_encode_mimeheader(config('mailsending.contact.sender')))
                    ->subject($this->title)
                    ->text('emails.' . $this->template)
                    ->with([
                        'user_type' => $this->userType,
                        'email'     => $this->email,
                        'name'      => $this->name,
                        'contents'  => $this->contents,
                    ]);
    }
}
