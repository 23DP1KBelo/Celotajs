<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'budget',
        'date_from',
        'date_till',
        'status',
        'description',
        'category',
        'image',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tripDestinations(): HasMany
    {
        return $this->hasMany(TripDestination::class, 'trip_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (Trip $trip) {
            $trip->tripDestinations()->delete();
        });
    }
}