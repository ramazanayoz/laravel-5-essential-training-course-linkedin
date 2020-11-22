<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Booking::withTrashed()->get()->dd();
        //eager lading
        //$bookings = Booking::with(['room.roomType','users::name'])
        $bookings=  Booking::paginate(2);
        return view('bookings.index')->with('bookings', $bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get()->pluck('name','id');
        $rooms = DB::table('rooms')->get()->pluck('number','id');
        return view('bookings.create')->with('rooms',$rooms)->with('users',$users)->with('booking',$rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       /* $id = DB::table('bookings')->insertGetId([
            'room_id' => $request->input('room_id'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'is_reservation' => $request->input('is_reservation', false),
            'is_paid'=> $request->input('room_id', false),
            'notes' => $request->input('notes'),
        ]);

        DB::table('bookings_users')->insert([
            'booking_id'=> $id,
            'user_id'=>$request->input('user_id'),
        ]);
        */

        $booking = Booking::create($request->input());
       /* DB::table('bookings_users')->insert([
            'booking_id'=> $booking->id,
            'user_id'=>$request->input('user_id'),
        ]);
        */
        //yukardaki ile aynı şeye denk gelir
        $booking()->users()->attach($request->input('user_id'));
        return redirect()->action([BookingController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', ['booking' => $booking]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $users = DB::table('users')->get()->pluck('name', 'id');
        $rooms = DB::table('rooms')->get()->pluck('number','id');
        $bookingsUser = DB::table('booking_users')->where('booking_id',$booking->id);
        return view('bookings.edit')
            ->with('users', $users)
            ->with('rooms', $rooms)
            ->with('bookingsUser', $bookingsUser)
            ->with('booking', $booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $booking->fill($request->input);
        $booking->save();
       // DB::table('booking_users')->where('booking_id',$booking->id)->update(['user_id'=>$request->input('user_id')]);
        //yukardaki ile aynı şeye denk gelir
        $booking->users()->sync([$request->input('user_id')]);
       return redirect()->action([BookingController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //DB::table('bookings_users')->where('booking_id', $booking->id)->delete();
        //yukardaki ile aynı şey
        $booking->users()->detach();
        $booking->delete();
        return redirect()->action([BookingController::class, 'index']);
    }
}
