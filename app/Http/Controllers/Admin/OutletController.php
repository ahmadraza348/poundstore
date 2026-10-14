<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOutletRequest;
use App\Http\Requests\Admin\UpdateOutletRequest;
use App\Models\City;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OutletController extends Controller
{
    private const DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $cityId = $request->query('city_id');

        $outlets = Outlet::query()
            ->with('city')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('branch_code', 'like', '%' . $search . '%')
                        ->orWhere('area', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhereHas('city', fn ($cityQuery) => $cityQuery->where('name', 'like', '%' . $search . '%'));
                });
            })
            ->when($cityId, fn ($query) => $query->where('city_id', $cityId))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        $cities = City::ordered()->get();
        return view('backend.outlet.index', compact('outlets', 'cities', 'search', 'cityId'));
    }

    public function create()
    {
        $cities = City::ordered()->get();
        return view('backend.outlet.create', compact('cities'));
    }

    public function store(StoreOutletRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->makeUniqueSlug($data['slug'] ?? null, $data['name']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['location_verified'] = $request->boolean('location_verified');
        $data['opening_hours'] = $this->normaliseOpeningHours($data['opening_hours'] ?? []);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/outlets', 'public');
        } else {
            unset($data['image']);
        }

        Outlet::create($data);

        toastr()->success('Outlet created successfully. It will appear on the website when its status and city are active.');
        return redirect()->route('outlet.index');
    }

    public function edit(Outlet $outlet)
    {
        $cities = City::ordered()->get();
        return view('backend.outlet.edit', compact('outlet', 'cities'));
    }

    public function update(UpdateOutletRequest $request, Outlet $outlet)
    {
        $data = $request->validated();

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        } else {
            $data['slug'] = $this->makeUniqueSlug($data['slug'], $data['name'], $outlet->id);
        }

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['location_verified'] = $request->boolean('location_verified');
        $data['opening_hours'] = $this->normaliseOpeningHours($data['opening_hours'] ?? []);

        $oldImage = $outlet->image;
        $newImageUploaded = $request->hasFile('image');
        if ($newImageUploaded) {
            $data['image'] = $request->file('image')->store('images/outlets', 'public');
        } else {
            unset($data['image']); // Preserve the current image unless a replacement is uploaded.
        }

        $outlet->update($data);

        if ($newImageUploaded && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        toastr()->success('Outlet updated successfully.');
        return redirect()->route('outlet.index');
    }

    public function destroy(Outlet $outlet)
    {
        $image = $outlet->image;
        $outlet->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        toastr()->success('Outlet deleted successfully.');
        return redirect()->route('outlet.index');
    }

    private function normaliseOpeningHours(array $input): array
    {
        $result = [];
        foreach (self::DAYS as $day) {
            $row = $input[$day] ?? [];
            $closed = filter_var($row['closed'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $result[$day] = [
                'closed' => $closed,
                'open' => $closed ? null : (filled($row['open'] ?? null) ? $row['open'] : null),
                'close' => $closed ? null : (filled($row['close'] ?? null) ? $row['close'] : null),
            ];
        }

        return $result;
    }

    private function makeUniqueSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $name) ?: 'outlet';
        $candidate = $base;
        $number = 2;

        while (Outlet::query()->where('slug', $candidate)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base . '-' . $number++;
        }

        return $candidate;
    }
}
