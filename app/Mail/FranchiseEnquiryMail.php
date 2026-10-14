<?php

namespace App\Mail;

use App\Models\FranchiseEnquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FranchiseEnquiryMail extends Mailable
{
    // Public properties are automatically available in the email view as $enquiry.
    public function __construct(public FranchiseEnquiry $enquiry)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New franchise enquiry from ' . $this->enquiry->name,
            // Hitting "Reply" in your inbox goes to the visitor (only if they gave an email).
            replyTo: $this->enquiry->email
                ? [new Address($this->enquiry->email, $this->enquiry->name)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.franchise-enquiry');
    }
}
