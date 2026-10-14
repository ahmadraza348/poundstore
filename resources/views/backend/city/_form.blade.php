@php($city = $city ?? null)
<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <div class="row g-4">
            <div class="col-lg-6 form-group">
                <label for="name">City / Area Name <span class="text-danger">*</span></label>
                <input class="form-control" required maxlength="150" name="name" id="name" value="{{ old('name', $city->name ?? '') }}" placeholder="e.g. Gujranwala">
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="slug">Slug <small class="text-muted">(auto-generated if blank)</small></label>
                <input class="form-control" maxlength="180" name="slug" id="slug" value="{{ old('slug', $city->slug ?? '') }}" placeholder="gujranwala">
                @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="district">District</label>
                <input class="form-control" maxlength="150" name="district" id="district" value="{{ old('district', $city->district ?? '') }}" placeholder="District name">
                @error('district')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="province">Province / Territory</label>
                <input class="form-control" maxlength="100" name="province" id="province" value="{{ old('province', $city->province ?? '') }}" placeholder="e.g. Punjab">
                @error('province')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="latitude">City-centre Latitude <small class="text-muted">(optional map point)</small></label>
                <input type="number" step="any" min="-90" max="90" class="form-control" name="latitude" id="latitude" value="{{ old('latitude', $city->latitude ?? '') }}" placeholder="e.g. 32.1877">
                @error('latitude')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="longitude">City-centre Longitude <small class="text-muted">(optional map point)</small></label>
                <input type="number" step="any" min="-180" max="180" class="form-control" name="longitude" id="longitude" value="{{ old('longitude', $city->longitude ?? '') }}" placeholder="e.g. 74.1945">
                @error('longitude')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="sort_order">Display Order</label>
                <input type="number" min="0" class="form-control" name="sort_order" id="sort_order" value="{{ old('sort_order', $city->sort_order ?? 0) }}">
                @error('sort_order')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1" {{ (string)old('status', isset($city) ? (int)$city->status : 1) === '1' ? 'selected' : '' }}>Active — visible on website when it has active branches</option>
                    <option value="0" {{ (string)old('status', isset($city) ? (int)$city->status : 1) === '0' ? 'selected' : '' }}>Inactive — hide its branches from public pages</option>
                </select>
                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-12">
                <div class="alert alert-info mb-0"><strong>Map tip:</strong> City coordinates represent an approximate city-centre marker. For exact branch directions, set the individual branch's own verified coordinates or Google Maps URL.</div>
            </div>
            <div class="col-12">
                <button class="btn btn-submit me-2" type="submit">{{ $city ? 'Update City' : 'Save City' }}</button>
                <a href="{{ route('city.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    var nameInput = document.getElementById('name');
    var slugInput = document.getElementById('slug');
    if (!nameInput || !slugInput || {{ $city ? 'false' : 'true' }} === false) return;
    var manuallyEdited = slugInput.value !== '';
    slugInput.addEventListener('input', function () { manuallyEdited = slugInput.value !== ''; });
    nameInput.addEventListener('input', function () {
        if (manuallyEdited) return;
        slugInput.value = nameInput.value.toLowerCase().trim().replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    });
})();
</script>
