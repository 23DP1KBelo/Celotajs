<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDestination extends Model
{
    protected $fillable = [
        'recommendations',
        'trip_id',
        'destination_id',
    ];

    public function Trip() {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }

    public function destination() {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
}
