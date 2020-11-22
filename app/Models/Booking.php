<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'room_id',
        'start',
        'end',
        'is_reservation',
        'is_paid',
        'notes'
    ];

    public function users(){
        return $this->belongsToMany('App\Models\User',  'bookings_users', 'booking_id', 'user_id')->withTimestamps();
    }

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

}
