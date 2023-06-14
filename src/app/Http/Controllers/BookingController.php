<?php

namespace App\Http\Controllers;

use App\Events\BookingMade;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => BookingResource::collection(Booking::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {

        $booking = Booking::create($request->validated());

//       dispatching event which will trigger email sending
        BookingMade::dispatch($booking);

        return response()->json(['data' => new BookingResource($booking)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return response()->json(['data' => new BookingResource($booking)]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BookingUpdateRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return response()->json(['data' => new BookingResource($booking)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['data' => new BookingResource($booking)]);
    }
}
