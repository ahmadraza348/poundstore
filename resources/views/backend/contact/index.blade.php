@extends('backend.layouts.layout')
@section('title', 'Contact Messages - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Contact Messages</h4>
                <h6>Messages submitted from the website contact form.</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                         <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr><th>Date</th><th>Name</th><th>Phone / Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @forelse ($messages as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->contact }}</td>
                                <td>{{ $item->subject ?: '—' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($item->message, 60) }}</td>
                                <td>
                                    @if($item->is_read)
                                        <span class="badge rounded-pill bg-secondary">Read</span>
                                    @else
                                        <span class="badge rounded-pill bg-success">New</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('contact-message.show', $item) }}" class="me-3" title="View"><img src="{{ asset('backend/assets/img/icons/eye.svg') }}" alt="View"></a>
                                    <form action="{{ route('contact-message.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete" onclick="return confirm('Delete this message?');"><img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete"></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">No contact messages yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $messages->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
