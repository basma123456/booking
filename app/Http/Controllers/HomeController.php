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


    public function mmm2(Request $request)
    {

        if ($request->from_date || $request->to_date) {
//            $start_date = Carbon::parse($request->from_date)->toDateTimeString();
//            $end_date = Carbon::parse($request->to_date)->toDateTimeString();
            $start = $request->from_date;
            $end = $request->to_date;
//            $data['all'] = Booking::whereNotBetween('booking_date', [$start, $end])->whereNotBetween('to_date' , [$start , $end] )->with(['rooms' => function($query)  {
//
//                $query
//                    ->get();
//
//            }])->get();


            $data['all'] = Room::whereNotBetween('from_date', [$start, $end])->whereNotBetween('to_date' , [$start , $end] )->get();



            $data['fromDate'] = $request->from_date;
            $data['toDate'] = $request->to_date;
            return view('calendar2' , compact('data'));

        }else{
            return redirect()->back();

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
            return redirect('/m2')->with('msg' , 'bravo');
        }else{
            return redirect('/m2')->with('msg' , 'noooooooo');

        }

    }
}
