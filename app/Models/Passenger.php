<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'passport_expiry_date',
    ];

    protected $hidden = ['password'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function flights()
    {
        return $this->belongsToMany(Flight::class);
    }

    public function scopeWhereHasFlight($query, $flightId)
    {
        return $query->whereHas('flights', function ($q) use ($flightId) {
            $q->where('flights.id', $flightId);
        });
    }
}