<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function mmm(Request $request)
    {
        $request->my_date;
        return response()->json(['from' => $request->my_date , 'to'=>$request->to_date]);
    }


    public function submitDate(Request $request)
    {
        if ($request->from_date || $request->to_date) {
            $data['fromDate'] = $request->from_date;
            $data['toDate'] = $request->to_date;

            $data['all'] = DB::SELECT("SELECT * FROM rooms WHERE id NOT IN (SELECT room_id FROM bookings WHERE '$request->from_date' BETWEEN from_date AND to_date OR  '$request->to_date' BETWEEN from_date AND to_date)");


            return view('calendar2' , compact('data'));


        }

    }


    public function reserveRoomNow($fromDate , $toDate , Request $request)
    {
        $booking = Booking::create([
            'booking_date' => $fromDate ,
                    'from_date' => $fromDate ,
            'to_date' => $toDate ,
            'room_id' => $request->room_id,


        ]);
        if($booking){
            return redirect('/choose-date')->with('msg' , 'Congratulations , Reservation is done successfully');
        }else{
            return redirect('/choose-date')->with('msg' , 'sorry ,  Reservation is not done');

        }

    }
}
