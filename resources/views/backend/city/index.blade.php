@extends('backend.layouts.layout')
@section('title', 'Cities & Areas - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Cities / Areas</h4>
                <h6>Create cities first, then assign one or more outlets to each city.</h6>
            </div>
            <div class="page-btn"><a href="{{ route('city.create') }}" class="btn btn-added"><img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt=""> Add City</a></div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('city.index') }}" class="row align-items-end mb-4">
                    <div class="col-md-6 col-lg-4 form-group mb-2">
                        <label for="q">Search city, district or province</label>
                        <input id="q" type="search" name="q" value="{{ $search }}" class="form-control" placeholder="e.g. Gujranwala">
                    </div>
                    <div class="col-auto mb-2"><button class="btn btn-submit" type="submit">Search</button></div>
                    @if ($search !== '')<div class="col-auto mb-2"><a class="btn btn-cancel" href="{{ route('city.index') }}">Clear</a></div>@endif
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>City / Area</th><th>Slug</th><th>District</th><th>Province</th><th>Outlets</th><th>Map Coordinates</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                        @forelse ($cities as $city)
                            <tr>
                                <td><strong>{{ $city->name }}</strong><br><small class="text-muted">Sort: {{ $city->sort_order }}</small></td>
                                <td>{{ $city->slug }}</td>
                                <td>{{ $city->district ?: '—' }}</td>
                                <td>{{ $city->province ?: '—' }}</td>
                                <td><span class="badge bg-info">{{ $city->outlets_count }}</span></td>
                                <td>
                                    @if($city->latitude !== null && $city->longitude !== null)
                                        {{ number_format($city->latitude, 5) }}, {{ number_format($city->longitude, 5) }}
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td>@if($city->status)<span class="badge rounded-pill bg-success">Active</span>@else<span class="badge rounded-pill bg-danger">Inactive</span>@endif</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('city.edit', $city) }}" class="me-3" title="Edit city"><img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="Edit"></a>
                                    <form id="deleteCity-{{ $city->id }}" action="{{ route('city.destroy', $city) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete city" onclick="return confirm('Delete this city? Cities with assigned outlets cannot be deleted.');"><img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete"></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4">No cities found. Create a city before adding an outlet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $cities->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
