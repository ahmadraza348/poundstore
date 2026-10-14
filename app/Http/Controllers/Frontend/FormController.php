<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactMessageRequest;
use App\Http\Requests\Frontend\FranchiseEnquiryRequest;
use App\Services\Frontend\FormSubmissionService;

/**
 * Handles the public Franchise and Contact forms.
 * Validation lives in the Form Requests, saving/emailing lives in FormSubmissionService.
 */
class FormController extends Controller
{
    public function __construct(private FormSubmissionService $forms) {}

    public function franchise(FranchiseEnquiryRequest $request)
    {
        $message = 'Thank you! Your franchise enquiry has been received. The team will contact you soon.';

        // Hidden "hp_check" field is a honeypot: real visitors never fill it, bots do.
        if (! $request->filled('hp_check')) {
            $this->forms->storeFranchiseEnquiry($request->validated());
        }

        toastr()->success($message);


        return redirect(route('frontend.franchise') . '#enquiry');
    }

    public function contact(ContactMessageRequest $request)
    {
        $message = 'Thank you! Your message has been sent. The team will get back to you soon.';

        if (! $request->filled('hp_check')) {
            $this->forms->storeContactMessage($request->validated());
        }
        toastr()->success($message);
        return redirect(route('frontend.contact') . '#contact-form');
    }
}
