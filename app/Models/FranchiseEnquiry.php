<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseEnquiry extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'city',
        'budget',
        'property_status',
        'notes',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
