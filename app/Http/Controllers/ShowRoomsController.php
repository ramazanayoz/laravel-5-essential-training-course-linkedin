<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
class ShowRoomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($roomType=null){

        //using scope
        $rooms= Room::byType($roomType)->get();
        return view('rooms.index', ['rooms' =>$rooms]);

        /*
        if(isset($roomType)){
            $rooms = Room::where('room_type_id',$roomType)->get();
        }else{
            $rooms= Room::get();
        }
        return view('rooms.index', ['rooms' =>$rooms]);

        */

        /*
        dump(Request()->query('id'));
        if(Request()->query('id') !==null ){
            //return $rooms->where('room_type_id', Request()->query('id'));
            $rooms = $rooms->where('room_type_id', Request()->query('id'));
            return view('rooms.index', ['rooms'=>$rooms]);
        }else{
            return view('rooms.index', ['rooms' =>$rooms]);
        }
        */
    }
}
