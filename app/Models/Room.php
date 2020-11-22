<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'Rooms';
    protected $primaryKey = 'id';
    public $timestamp = true;


    public function scopeByType($query, $roomTypeId=null){
        if($roomTypeId != null){
            $query->where('room_type_id', $roomTypeId);
        }
        return $query;
    }

    public function roomType(){
        return $this->belongsTo('App\Models\RoomType','room_type_id','id');
    }
}
