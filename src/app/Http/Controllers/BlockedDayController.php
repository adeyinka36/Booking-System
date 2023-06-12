<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlockedDayResource;
use App\Models\BlockedDay;
use App\Models\Booking;
use Illuminate\Http\Request;

class BlockedDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => BlockedDayResource::collection(BlockedDay::all())]);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $date)
    {
        $blockedDays = BlockedDay::where('date', $date)->get();
        return response()->json(['data' => BlockedDayResource::collection($blockedDays)]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required|string'
        ]);

        $blockedDay = BlockedDay::create($data);

        return response()->json(['data' => new BlockedDayResource($blockedDay)], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required|string'
        ]);

        $blockedDay = BlockedDay::where('date', $data['date'])->where('time', $data['time'])->firstOrFail();

        $blockedDay->delete();

        return response()->json([], 204);
    }

    public function destroyAllSlots(string $date)
    {
//        check if date is valid date
        if(!strtotime($date)) {
            return response()->json(['Message' => 'Invalid date'], 400);
        }

        $times =  config('utils.timeSlots');

//        creat block day for all the time date
        foreach($times as $time) {
            BlockedDay::create([
                'date' => $date,
                'time' => $time
            ]);
        }

//        delete all the booking for the date
        $blockedDays = Booking::where('booking_date', $date)->get();

        foreach($blockedDays as $blockedDay) {
            $blockedDay->delete();
        }

        return response()->json([], 204);
    }
}
