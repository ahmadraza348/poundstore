@php
    $outlet = $outlet ?? null;
    $days = ['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday'];
    $hoursValues = old('opening_hours', $outlet->opening_hours ?? []);
@endphp
<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @if($cities->isEmpty())
            <div class="alert alert-warning">You need to create a city before creating an outlet. <a href="{{ route('city.create') }}" class="alert-link">Create a city now</a>.</div>
        @endif

        <h5 class="mb-3">Branch Information</h5>
        <div class="row g-4">
            <div class="col-lg-6 form-group">
                <label for="name">Outlet / Branch Name <span class="text-danger">*</span></label>
                <input type="text" required maxlength="180" class="form-control" name="name" id="name" value="{{ old('name', $outlet->name ?? '') }}" placeholder="e.g. Pound Store Main Market">
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="slug">Slug <small class="text-muted">(auto-generated if left blank)</small></label>
                <input type="text" maxlength="180" class="form-control" name="slug" id="slug" value="{{ old('slug', $outlet->slug ?? '') }}" placeholder="main-market-gujranwala">
                @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="city_id">City / Area <span class="text-danger">*</span></label>
                <select required class="form-control" name="city_id" id="city_id">
                    <option value="">Select city</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ (string)old('city_id', $outlet->city_id ?? '') === (string)$city->id ? 'selected' : '' }}>{{ $city->name }}{{ $city->status ? '' : ' (Inactive)' }}</option>
                    @endforeach
                </select>
                @error('city_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="outlet_type">Outlet Type <span class="text-danger">*</span></label>
                <select required class="form-control" name="outlet_type" id="outlet_type">
                    <option value="retail_store" {{ old('outlet_type', $outlet->outlet_type ?? 'retail_store') === 'retail_store' ? 'selected' : '' }}>Retail Store</option>
                    <option value="warehouse" {{ old('outlet_type', $outlet->outlet_type ?? '') === 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                    <option value="head_office" {{ old('outlet_type', $outlet->outlet_type ?? '') === 'head_office' ? 'selected' : '' }}>Head Office</option>
                </select>
                @error('outlet_type')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="branch_code">Branch Code <small class="text-muted">(optional, must be unique)</small></label>
                <input class="form-control" maxlength="60" name="branch_code" id="branch_code" value="{{ old('branch_code', $outlet->branch_code ?? '') }}" placeholder="e.g. PS-GRW-001">
                @error('branch_code')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="area">Area / Neighbourhood</label>
                <input class="form-control" maxlength="180" name="area" id="area" value="{{ old('area', $outlet->area ?? '') }}" placeholder="e.g. Satellite Town">
                @error('area')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-12 form-group">
                <label for="address">Full Street Address <span class="text-danger">*</span></label>
                <textarea required class="form-control" rows="3" maxlength="2000" name="address" id="address" placeholder="Shop / plaza, street, road, city">{{ old('address', $outlet->address ?? '') }}</textarea>
                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="landmark">Nearby Landmark</label>
                <input class="form-control" maxlength="255" name="landmark" id="landmark" value="{{ old('landmark', $outlet->landmark ?? '') }}" placeholder="Near a well-known landmark">
                @error('landmark')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="sort_order">Display Order</label>
                <input type="number" min="0" class="form-control" name="sort_order" id="sort_order" value="{{ old('sort_order', $outlet->sort_order ?? 0) }}">
                @error('sort_order')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>

        <hr class="my-4"><h5 class="mb-3">Contact Details</h5>
        <div class="row g-4">
            <div class="col-lg-4 form-group"><label for="phone">Phone</label><input class="form-control" name="phone" id="phone" maxlength="50" value="{{ old('phone', $outlet->phone ?? '') }}" placeholder="Branch phone"><small class="text-muted">Shown as a call link on the website.</small>@error('phone')<br><small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-lg-4 form-group"><label for="whatsapp">WhatsApp</label><input class="form-control" name="whatsapp" id="whatsapp" maxlength="50" value="{{ old('whatsapp', $outlet->whatsapp ?? '') }}" placeholder="e.g. +923001234567">@error('whatsapp')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-lg-4 form-group"><label for="email">Email</label><input type="email" class="form-control" name="email" id="email" maxlength="255" value="{{ old('email', $outlet->email ?? '') }}" placeholder="branch@example.com">@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
        </div>

        <hr class="my-4"><h5 class="mb-3">Map & Directions</h5>
        <div class="row g-4">
            <div class="col-lg-6 form-group"><label for="latitude">Outlet Latitude</label><input type="number" step="any" min="-90" max="90" class="form-control" name="latitude" id="latitude" value="{{ old('latitude', $outlet->latitude ?? '') }}" placeholder="Enter the branch's own coordinates">@error('latitude')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-lg-6 form-group"><label for="longitude">Outlet Longitude</label><input type="number" step="any" min="-180" max="180" class="form-control" name="longitude" id="longitude" value="{{ old('longitude', $outlet->longitude ?? '') }}" placeholder="Enter the branch's own coordinates">@error('longitude')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-12 form-group"><label for="maps_url">Google Maps URL <small class="text-muted">(optional, preferred when you have the approved branch pin)</small></label><input type="url" class="form-control" maxlength="2048" name="maps_url" id="maps_url" value="{{ old('maps_url', $outlet->maps_url ?? '') }}" placeholder="https://maps.app.goo.gl/...">@error('maps_url')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-12">
                <div class="form-check mb-2">
                    <input type="hidden" name="location_verified" value="0">
                    <input type="checkbox" value="1" name="location_verified" class="form-check-input" id="location_verified" {{ old('location_verified', $outlet->location_verified ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="location_verified">I have verified these coordinates as the exact branch location</label>
                </div>
                @error('location_verified')<small class="text-danger">{{ $message }}</small>@enderror
                <small class="text-muted">When a URL is provided it is used for directions. Otherwise, verified coordinates create a directions link; if neither is provided, the website searches the entered address on Google Maps.</small>
            </div>
        </div>

        <hr class="my-4"><h5 class="mb-3">Weekly Opening Hours</h5>
        <p class="text-muted">Leave times blank when you do not yet have confirmed hours. Mark a day as closed if the branch is known to be closed that day.</p>
        <div class="table-responsive"><table class="table table-bordered align-middle">
            <thead><tr><th style="min-width:115px">Day</th><th style="min-width:150px">Opening Time</th><th style="min-width:150px">Closing Time</th><th style="min-width:100px">Closed</th></tr></thead>
            <tbody>
            @foreach($days as $day => $label)
                @php($dayHours = $hoursValues[$day] ?? [])
                <tr>
                    <td>{{ $label }}</td>
                    <td><input type="time" class="form-control" name="opening_hours[{{ $day }}][open]" value="{{ $dayHours['open'] ?? '' }}" aria-label="{{ $label }} opening time"></td>
                    <td><input type="time" class="form-control" name="opening_hours[{{ $day }}][close]" value="{{ $dayHours['close'] ?? '' }}" aria-label="{{ $label }} closing time"></td>
                    <td><input type="hidden" name="opening_hours[{{ $day }}][closed]" value="0"><div class="form-check"><input type="checkbox" class="form-check-input" name="opening_hours[{{ $day }}][closed]" value="1" id="closed_{{ $day }}" {{ !empty($dayHours['closed']) ? 'checked' : '' }}><label class="form-check-label" for="closed_{{ $day }}">Closed</label></div></td>
                </tr>
            @endforeach
            </tbody>
        </table></div>
        @error('opening_hours')<small class="text-danger">{{ $message }}</small>@enderror

        <hr class="my-4"><h5 class="mb-3">Website Content & Image</h5>
        <div class="row g-4">
            <div class="col-lg-6 form-group"><label for="description">Short Description</label><textarea class="form-control" rows="4" maxlength="5000" name="description" id="description" placeholder="Optional information shown on the branch card">{{ old('description', $outlet->description ?? '') }}</textarea>@error('description')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-lg-6 form-group">
                <label for="image">Outlet Image <small class="text-muted">(JPG, PNG, WEBP; max 3 MB)</small></label>
                <input type="file" class="form-control" name="image" id="image" accept="image/jpeg,image/png,image/webp" onchange="outletPreviewImage(event)">
                @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                <div class="mt-3">
                    @if($outlet?->image_url)
                        <img id="outletImagePreview" src="{{ $outlet->image_url }}" alt="Outlet image preview" style="max-width:220px;max-height:150px;object-fit:cover;border-radius:8px">
                    @else
                        <img id="outletImagePreview" src="#" alt="Outlet image preview" style="display:none;max-width:220px;max-height:150px;object-fit:cover;border-radius:8px">
                    @endif
                </div>
                <small class="text-muted d-block mt-2">Uploading a replacement image will replace the old file. Leave this blank to keep the current image.</small>
            </div>
            <div class="col-lg-6 form-group">
                <label for="status">Publication Status <span class="text-danger">*</span></label>
                <select class="form-control" required name="status" id="status">
                    <option value="1" {{ (string)old('status', isset($outlet) ? (int)$outlet->status : 1) === '1' ? 'selected' : '' }}>Active — show on website</option>
                    <option value="0" {{ (string)old('status', isset($outlet) ? (int)$outlet->status : 1) === '0' ? 'selected' : '' }}>Inactive — hide on website</option>
                </select>
                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label class="d-block">Frontend Display</label>
                <input type="hidden" name="is_featured" value="0">
                <div class="form-check"><input type="checkbox" value="1" name="is_featured" class="form-check-input" id="is_featured" {{ old('is_featured', $outlet->is_featured ?? false) ? 'checked' : '' }}><label class="form-check-label" for="is_featured">Feature this branch near the top of the directory</label></div>
                @error('is_featured')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-submit me-2" type="submit" {{ $cities->isEmpty() ? 'disabled' : '' }}>{{ $outlet ? 'Update Outlet' : 'Save Outlet' }}</button>
            <a href="{{ route('outlet.index') }}" class="btn btn-cancel">Cancel</a>
        </div>
    </div>
</div>
<script>
function outletPreviewImage(event) {
    var file = event.target.files && event.target.files[0];
    var image = document.getElementById('outletImagePreview');
    if (!file || !image) return;
    image.src = URL.createObjectURL(file);
    image.style.display = 'block';
}
(function () {
    var nameInput = document.getElementById('name');
    var slugInput = document.getElementById('slug');
    if (!nameInput || !slugInput || {{ $outlet ? 'false' : 'true' }} === false) return;
    var manuallyEdited = slugInput.value !== '';
    slugInput.addEventListener('input', function () { manuallyEdited = slugInput.value !== ''; });
    nameInput.addEventListener('input', function () {
        if (manuallyEdited) return;
        slugInput.value = nameInput.value.toLowerCase().trim().replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    });
})();
</script>
