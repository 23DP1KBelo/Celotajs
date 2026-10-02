<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function TripDestinantion() {
        return $this->hasMany(TripDestination::class);
    }
}