<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'name',
        'country_id'
    ];

    public function Country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function Destinations() {
        return $this->hasMany(Destination::class);
    }
}
