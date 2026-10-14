@extends('backend.layouts.layout')
@section('title', 'Outlets - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Manage Outlets</h4><h6>Every outlet is a separate branch and belongs to one city.</h6></div>
            <div class="page-btn"><a href="{{ route('outlet.create') }}" class="btn btn-added"><img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt=""> Add Outlet</a></div>
        </div>

        <div class="card"><div class="card-body">
            @if($cities->isEmpty())
                <div class="alert alert-warning">Create a city first. <a href="{{ route('city.create') }}" class="alert-link">Add a city / area</a>.</div>
            @endif
            <form method="GET" action="{{ route('outlet.index') }}" class="row align-items-end mb-4">
                <div class="col-md-5 col-lg-4 form-group mb-2">
                    <label for="q">Search outlet, branch code, area or address</label>
                    <input id="q" type="search" name="q" value="{{ $search }}" class="form-control" placeholder="e.g. Main Market">
                </div>
                <div class="col-md-4 col-lg-3 form-group mb-2">
                    <label for="city_id">Filter by city</label>
                    <select id="city_id" name="city_id" class="form-control">
                        <option value="">All cities</option>
                        @foreach($cities as $city)<option value="{{ $city->id }}" {{ (string)$cityId === (string)$city->id ? 'selected' : '' }}>{{ $city->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-auto mb-2"><button class="btn btn-submit" type="submit">Filter</button></div>
                @if($search !== '' || $cityId)<div class="col-auto mb-2"><a class="btn btn-cancel" href="{{ route('outlet.index') }}">Clear</a></div>@endif
            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Image</th><th>Outlet</th><th>City / Area</th><th>Type</th><th>Phone</th><th>Featured</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse($outlets as $outlet)
                        <tr>
                            <td>
                                @if($outlet->image_url)
                                    <img src="{{ $outlet->image_url }}" alt="{{ $outlet->name }}" style="width:58px;height:58px;object-fit:cover;border-radius:8px">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light" style="width:58px;height:58px;border-radius:8px"><i class="fas fa-store text-muted"></i></div>
                                @endif
                            </td>
                            <td><strong>{{ $outlet->name }}</strong><br><small class="text-muted">{{ $outlet->branch_code ?: $outlet->slug }}</small></td>
                            <td>{{ $outlet->city->name ?? 'City missing' }}<br><small class="text-muted">{{ $outlet->area ?: 'Area not specified' }}</small></td>
                            <td>{{ ['retail_store' => 'Retail Store', 'warehouse' => 'Warehouse', 'head_office' => 'Head Office'][$outlet->outlet_type] ?? ucfirst(str_replace('_', ' ', $outlet->outlet_type)) }}</td>
                            <td>{{ $outlet->phone ?: '—' }}</td>
                            <td>@if($outlet->is_featured)<span class="badge rounded-pill bg-success">Yes</span>@else<span class="badge rounded-pill bg-secondary">No</span>@endif</td>
                            <td>@if($outlet->status)<span class="badge rounded-pill bg-success">Active</span>@else<span class="badge rounded-pill bg-danger">Inactive</span>@endif</td>
                            <td class="text-nowrap">
                                <a href="{{ route('outlet.edit', $outlet) }}" class="me-3" title="Edit outlet"><img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="Edit"></a>
                                <form action="{{ route('outlet.destroy', $outlet) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" title="Delete outlet" onclick="return confirm('Permanently delete this outlet and its uploaded image?');"><img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete"></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4">No outlets found. Add a city and create your first outlet to populate the website.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $outlets->links('pagination::bootstrap-4') }}</div>
        </div></div>
    </div>
</div>
@endsection
