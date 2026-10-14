<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactMessageMail extends Mailable
{
    // Public properties are automatically available in the email view as $contactMessage.
    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        // The visitor types "phone or email" in one field, so only use it as reply-to if it is an email.
        $replyTo = filter_var($this->contactMessage->contact, FILTER_VALIDATE_EMAIL)
            ? [new Address($this->contactMessage->contact, $this->contactMessage->name)]
            : [];

        return new Envelope(
            subject: 'New contact message: ' . ($this->contactMessage->subject ?: 'General question'),
            replyTo: $replyTo,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contact-message');
    }
}
