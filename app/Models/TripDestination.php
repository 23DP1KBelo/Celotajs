<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripDestination extends Model
{
    protected $fillable = [
        'recommendations',
        'trip_id',
        'destination_id',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}
