@extends('backend.layouts.layout')
@section('title', 'Franchise Enquiry - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Franchise Enquiry</h4>
                <h6>Submitted on {{ $enquiry->created_at->format('d M Y, h:i A') }}</h6>
            </div>
            <div class="page-btn"><a href="{{ route('franchise-enquiry.index') }}" class="btn btn-cancel">Back to list</a></div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr><th style="width: 220px;">Name</th><td>{{ $enquiry->name }}</td></tr>
                        <tr><th>Phone</th><td><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></td></tr>
                        <tr><th>Email</th><td>@if($enquiry->email)<a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>@else — @endif</td></tr>
                        <tr><th>City / proposed location</th><td>{{ $enquiry->city }}</td></tr>
                        <tr><th>Investment preference</th><td>{{ $enquiry->budget ?: '—' }}</td></tr>
                        <tr><th>Property status</th><td>{{ $enquiry->property_status ?: '—' }}</td></tr>
                        <tr><th>Notes</th><td>{!! nl2br(e($enquiry->notes ?: '—')) !!}</td></tr>
                    </tbody>
                </table>

                <form action="{{ route('franchise-enquiry.destroy', $enquiry) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this enquiry?');">Delete enquiry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
