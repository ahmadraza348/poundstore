<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'slug',
        'branch_code',
        'outlet_type',
        'area',
        'address',
        'landmark',
        'phone',
        'whatsapp',
        'email',
        'latitude',
        'longitude',
        'maps_url',
        'location_verified',
        'opening_hours',
        'image',
        'description',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'location_verified' => 'boolean',
        'opening_hours' => 'array',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Return a real branch directions URL when supplied. Otherwise use verified
     * coordinates, or a Google Maps search for the address (not a claimed pin).
     */
    public function getDirectionsUrlAttribute(): string
    {
        if ($this->maps_url) {
            return $this->maps_url;
        }

        if ($this->location_verified && $this->latitude !== null && $this->longitude !== null) {
            return 'https://www.google.com/maps/dir/?api=1&destination=' . $this->latitude . ',' . $this->longitude;
        }

        $query = trim(implode(', ', array_filter([
            $this->address,
            $this->area,
            $this->city?->name,
            'Pakistan',
        ])));

        return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($query);
    }

    public function getOpeningHoursTodayAttribute(): string
    {
        $day = strtolower(now('Asia/Karachi')->format('l'));
        $hours = $this->opening_hours[$day] ?? null;

        if (!$hours) {
            return 'Hours not provided';
        }

        if (!empty($hours['closed'])) {
            return 'Closed today';
        }

        if (!empty($hours['open']) && !empty($hours['close'])) {
            return 'Today: ' . $hours['open'] . '–' . $hours['close'];
        }

        return 'Hours not provided';
    }
}
