<?php

namespace App\Services\Frontend;

use App\Mail\ContactMessageMail;
use App\Mail\FranchiseEnquiryMail;
use App\Models\ContactMessage;
use App\Models\FranchiseEnquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Business logic for the public forms: save to the database, then email the admin.
 */
class FormSubmissionService
{
    public function storeFranchiseEnquiry(array $data): FranchiseEnquiry
    {
        $enquiry = FranchiseEnquiry::create($data);

        $this->sendToAdmin(new FranchiseEnquiryMail($enquiry));

        return $enquiry;
    }

    public function storeContactMessage(array $data): ContactMessage
    {
        $message = ContactMessage::create($data);

        $this->sendToAdmin(new ContactMessageMail($message));

        return $message;
    }

    /**
     * The submission is already saved at this point, so if the mail server is down
     * we only log the error. The visitor still sees success and the entry is in the admin panel.
     */
    private function sendToAdmin($mailable): void
    {
        try {
            Mail::to(config('mail.enquiry_to'))->send($mailable);
        } catch (\Throwable $e) {
            Log::error('Form email could not be sent: ' . $e->getMessage());
        }
    }
}