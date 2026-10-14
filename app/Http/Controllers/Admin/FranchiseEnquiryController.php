<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FranchiseEnquiry;
use Illuminate\Http\Request;

class FranchiseEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $enquiries = FranchiseEnquiry::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.franchise.index', compact('enquiries', 'search'));
    }

    public function show(FranchiseEnquiry $enquiry)
    {
        // Opening an enquiry marks it as read.
        if (! $enquiry->is_read) {
            $enquiry->update(['is_read' => true]);
        }

        return view('backend.franchise.show', compact('enquiry'));
    }

    public function destroy(FranchiseEnquiry $enquiry)
    {
        $enquiry->delete();

        toastr()->success('Enquiry deleted successfully.');
        return redirect()->route('franchise-enquiry.index');
    }
}
