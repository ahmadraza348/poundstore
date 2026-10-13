{{-- Shared by create.blade.php and edit.blade.php. $product is null on create. --}}
@php
    $product = $product ?? null;
    $statusValue = (string) (int) old('status', $product->status ?? 1);
@endphp

<div class="card">
    <div class="card-body">
        <div class="row g-4">

            <!-- Name -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="name">Product Name*</label>
                    <input type="text" required name="name" id="name" class="form-control"
                        value="{{ old('name', $product->name ?? '') }}">
                    <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Slug -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="slug">Slug <small class="text-muted">(auto-generated if left empty)</small></label>
                    <input type="text" name="slug" id="slug" class="form-control"
                        value="{{ old('slug', $product->slug ?? '') }}">
                    <div class="text-danger">@error('slug') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Category -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="category_id">Category*</label>
                    <select name="category_id" id="category_id" required class="form-control">
                        <option value="">Select category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->parent ? $cat->parent->name . ' › ' : '' }}{{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="text-danger">@error('category_id') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Price -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="price">Price (PKR)*</label>
                    <input type="number" required min="0" step="1" name="price" id="price" class="form-control"
                        value="{{ old('price', isset($product) ? (float) $product->price : '') }}">
                    <div class="text-danger">@error('price') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Tag -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="tag">Tag / Label <small class="text-muted">(optional, e.g. Gift idea)</small></label>
                    <input type="text" name="tag" id="tag" maxlength="100" class="form-control"
                        value="{{ old('tag', $product->tag ?? '') }}">
                    <div class="text-danger">@error('tag') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="status">Status*</label>
                    <select name="status" required class="form-select" id="status">
                        <option value="1" {{ $statusValue === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $statusValue === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="text-danger">@error('status') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Description -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="6">{{ old('description', $product->description ?? '') }}</textarea>
                    <div class="text-danger">@error('description') {{ $message }} @enderror</div>
                </div>
            </div>

            <!-- Image -->
            <div class="col-lg-6 col-sm-12">
                <div class="form-group mb-0">
                    <label class="form-label" for="image">Product Image <small class="text-muted">(jpg, png, webp · max 2MB)</small></label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*"
                        onchange="productPreviewImage(event)">
                    <div class="text-danger">@error('image') {{ $message }} @enderror</div>

                    <div class="mt-2">
                        @if (!empty($product?->image))
                            <img id="productImagePreview" src="{{ $product->image_url }}" alt="Image Preview"
                                style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                        @else
                            <img id="productImagePreview" src="#" alt="Image Preview"
                                style="display: none; max-width: 200px; max-height: 200px; border-radius: 8px;">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Featured -->
            <div class="col-lg-12">
                <div class="form-group mb-0">
                    <div class="form-check mb-3">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" value="1" name="is_featured" class="form-check-input" id="is_featured"
                            {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Is Featured (shown first under "Recommended")</label>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="col-lg-12">
                <button type="submit" class="btn btn-submit me-2">{{ $product ? 'Update' : 'Submit' }}</button>
                <a href="{{ route('product.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>
    </div>
</div>

<script>
    function productPreviewImage(event) {
        var file = event.target.files && event.target.files[0];
        var img = document.getElementById('productImagePreview');
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    }

    // Create page only: fill the slug from the name until the admin edits the slug by hand.
    (function () {
        var name = document.getElementById('name');
        var slug = document.getElementById('slug');
        var isCreate = {{ $product ? 'false' : 'true' }};
        if (!isCreate || !name || !slug) return;
        var touched = slug.value !== '';
        slug.addEventListener('input', function () { touched = slug.value !== ''; });
        name.addEventListener('input', function () {
            if (touched) return;
            slug.value = name.value.toLowerCase().trim()
                .replace(/&/g, ' and ')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        });
    })();
</script>
