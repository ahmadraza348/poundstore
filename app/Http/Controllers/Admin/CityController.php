<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCityRequest;
use App\Http\Requests\Admin\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $cities = City::query()
            ->withCount('outlets')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('district', 'like', '%' . $search . '%')
                        ->orWhere('province', 'like', '%' . $search . '%');
                });
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('backend.city.index', compact('cities', 'search'));
    }

    public function create()
    {
        return view('backend.city.create');
    }

    public function store(StoreCityRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->makeUniqueSlug($data['slug'] ?? null, $data['name']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        City::create($data);

        toastr()->success('City created successfully. You can now add outlets to it.');
        return redirect()->route('city.index');
    }

    public function edit(City $city)
    {
        return view('backend.city.edit', compact('city'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']); // A blank slug on edit keeps the existing URL.
        } else {
            $data['slug'] = $this->makeUniqueSlug($data['slug'], $data['name'], $city->id);
        }

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $city->update($data);

        toastr()->success('City updated successfully.');
        return redirect()->route('city.index');
    }

    public function destroy(City $city)
    {
        if ($city->outlets()->exists()) {
            toastr()->error('This city cannot be deleted while outlets are assigned to it. Move or delete its outlets first.');
            return back();
        }

        $city->delete();
        toastr()->success('City deleted successfully.');
        return redirect()->route('city.index');
    }

    private function makeUniqueSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $name) ?: 'city';
        $candidate = $base;
        $number = 2;

        while (City::query()->where('slug', $candidate)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base . '-' . $number++;
        }

        return $candidate;
    }
}
