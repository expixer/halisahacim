<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplyForPanelNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $surname;
    public $phone;
    public $facility_name;


    /**
     * Create a new message instance.
     */
    public function __construct($name, $surname, $phone, $facility_name)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->facility_name = $facility_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Halısaha Panel Başvurusu',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_notification',
            with: [
                'name' => $this->name,
                'surname' => $this->surname,
                'phone' => $this->phone,
                'facility_name' => $this->facility_name,
            ],
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
