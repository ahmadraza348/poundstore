@extends('backend.layouts.layout')
@section('title', 'Franchise Enquiries - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Franchise Enquiries</h4>
                <h6>Enquiries submitted from the website franchise form.</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('franchise-enquiry.index') }}" class="row align-items-end mb-4">
                    <div class="col-md-6 col-lg-4 form-group mb-2">
                        <label for="q">Search name, phone, email or city</label>
                        <input id="q" type="search" name="q" value="{{ $search }}" class="form-control" placeholder="e.g. Lahore">
                    </div>
                    <div class="col-auto mb-2"><button class="btn btn-submit" type="submit">Search</button></div>
                    @if ($search !== '')<div class="col-auto mb-2"><a class="btn btn-cancel" href="{{ route('franchise-enquiry.index') }}">Clear</a></div>@endif
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Date</th><th>Name</th><th>Phone</th><th>Email</th><th>City / Location</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @forelse ($enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                                <td><strong>{{ $enquiry->name }}</strong></td>
                                <td>{{ $enquiry->phone }}</td>
                                <td>{{ $enquiry->email ?: '—' }}</td>
                                <td>{{ $enquiry->city }}</td>
                                <td>
                                    @if($enquiry->is_read)
                                        <span class="badge rounded-pill bg-secondary">Read</span>
                                    @else
                                        <span class="badge rounded-pill bg-success">New</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('franchise-enquiry.show', $enquiry) }}" class="me-3" title="View"><img src="{{ asset('backend/assets/img/icons/eye.svg') }}" alt="View"></a>
                                    <form action="{{ route('franchise-enquiry.destroy', $enquiry) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete" onclick="return confirm('Delete this enquiry?');"><img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete"></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">No franchise enquiries yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $enquiries->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
