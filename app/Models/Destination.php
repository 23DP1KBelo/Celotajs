<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'title',
        'description',
        'places_id'
    ];

    public function places() {
        return $this->belongsTo(Place::class, 'places_id', 'id');
    }

    public function tripDestinations() {
        return $this->hasMany(TripDestination::class);
    }
}
