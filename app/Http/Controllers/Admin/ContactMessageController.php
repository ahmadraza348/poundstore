<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $messages = ContactMessage::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('contact', 'like', '%' . $search . '%')
                        ->orWhere('subject', 'like', '%' . $search . '%')
                        ->orWhere('message', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.contact.index', compact('messages', 'search'));
    }

    public function show(ContactMessage $message)
    {
        // Opening a message marks it as read.
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('backend.contact.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        toastr()->success('Message deleted successfully.');
        return redirect()->route('contact-message.index');
    }
}
