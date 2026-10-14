<?php

namespace App\Services\Frontend;

use App\Models\City;
use App\Models\Outlet;

/**
 * Gets cities and outlets for the public website.
 * An outlet is shown only when the outlet AND its city are active.
 */
class StoreLocatorService
{
    /**
     * Cities that have at least one active outlet (used for the maps and city list).
     */
    public function getCities(): array
    {
        $cities = City::active()
            ->whereHas('outlets', fn ($q) => $q->where('status', true))
            ->withCount(['outlets as active_outlets_count' => fn ($q) => $q->where('status', true)])
            ->ordered()
            ->get();

        return $cities->map(function ($city) {
            $lat = $city->latitude;
            $lon = $city->longitude;

            // City has no coordinates? Use the average of its outlets that have a pin.
            if ($lat === null || $lon === null) {
                $pinned = $city->outlets()
                    ->where('status', true)
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude');

                if ($pinned->exists()) {
                    $lat = round($pinned->avg('latitude'), 6);
                    $lon = round($pinned->avg('longitude'), 6);
                }
            }

            return [
                'city'  => $city->name,
                'slug'  => $city->slug,
                'count' => (int) $city->active_outlets_count,
                'lat'   => $lat,
                'lon'   => $lon,
            ];
        })->all();
    }

    /**
     * Number of active central warehouses, read live from the outlets table
     * (outlet_type = warehouse). Same visibility rule as the public outlets:
     * the outlet AND its city must both be active.
     */
    public function getWarehouseCount(): int
    {
        return Outlet::query()
            ->active()
            ->where('outlet_type', 'warehouse')
            ->whereHas('city', fn ($q) => $q->where('status', true))
            ->count();
    }

    /**
     * Active outlets for the outlet cards.
     */
    public function getOutlets(): array
    {
        $outlets = Outlet::with('city')
            ->active()
            ->whereHas('city', fn ($q) => $q->where('status', true))
            ->ordered()
            ->get();

        return $outlets->map(fn ($outlet) => [
            'name'           => $outlet->name,
            'branch_code'    => $outlet->branch_code,
            'outlet_type'    => $outlet->outlet_type,
            'area'           => $outlet->area,
            'city'           => $outlet->city->name,
            'address'        => $outlet->address,
            'landmark'       => $outlet->landmark,
            'phone'          => $outlet->phone,
            'directions_url' => $this->safeUrl($outlet->directions_url),
            'image'          => $outlet->image_url ?? asset('frontend/assets/images/hero-store.jpg'),
            'lat'            => $outlet->latitude,
            'lon'            => $outlet->longitude,
            'location_verified' => (bool) $outlet->location_verified,
            'hours_today'    => $outlet->opening_hours_today,
            'is_featured'    => (bool) $outlet->is_featured,
        ])->all();
    }

    /**
     * Only allow normal web links (blocks things like javascript:).
     */
    private function safeUrl(?string $url): string
    {
        return ($url && preg_match('~^https?://~i', $url)) ? $url : '#';
    }
}
