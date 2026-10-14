<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Outlet;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share only public, active outlet data with the front-end layout. This
        // replaces the previous hard-coded sample city array without putting
        // admin-only/inactive branch records into public JavaScript.
        View::composer(['frontend.layouts.app', 'frontend.index', 'frontend.outlets'], function ($view): void {
            $cities = City::query()
                ->active()
                ->whereHas('outlets', fn ($query) => $query->where('status', true))
                ->withCount(['outlets as active_outlets_count' => fn ($query) => $query->where('status', true)])
                ->ordered()
                ->get();

            $outlets = Outlet::query()
                ->active()
                ->whereHas('city', fn ($query) => $query->where('status', true))
                ->with('city')
                ->ordered()
                ->get();

            $view->with('frontendCityListings', $cities->map(fn (City $city) => [
                'city' => $city->name,
                'slug' => $city->slug,
                'count' => (int) $city->active_outlets_count,
                'lat' => $city->latitude,
                'lon' => $city->longitude,
            ])->values()->all());

            $view->with('frontendOutlets', $outlets->map(fn (Outlet $outlet) => [
                'id' => $outlet->id,
                'name' => $outlet->name,
                'slug' => $outlet->slug,
                'branch_code' => $outlet->branch_code,
                'outlet_type' => $outlet->outlet_type,
                'area' => $outlet->area,
                'city' => $outlet->city?->name,
                'city_slug' => $outlet->city?->slug,
                'address' => $outlet->address,
                'landmark' => $outlet->landmark,
                'phone' => $outlet->phone,
                'whatsapp' => $outlet->whatsapp,
                'email' => $outlet->email,
                'latitude' => $outlet->latitude,
                'longitude' => $outlet->longitude,
                'location_verified' => $outlet->location_verified,
                'directions_url' => $outlet->directions_url,
                'image' => $outlet->image_url,
                'description' => $outlet->description,
                'opening_hours' => $outlet->opening_hours ?? [],
                'is_featured' => $outlet->is_featured,
                'sort_order' => $outlet->sort_order,
            ])->values()->all());
        });
    }
}
