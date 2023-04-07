<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    //Asunto del envio del email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registro usuario',
        );
    }

    /**
     * Get the message content definition.
     * 
     */
    // Contendio del mensaje del email de resources/views/example.blade
    public function content()
    {
        return new Content(
            view: 'example',
            with: []
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
