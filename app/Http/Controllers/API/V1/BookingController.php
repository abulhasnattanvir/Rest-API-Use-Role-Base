<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Booking::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::all();
        return BookingResource::collection($booking);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'date'  => ['required', 'date'],
            'status' => ['required']
        ]);
       $booking = Booking::create([
            'title' => $request->title,
            'date'  => $request->date,
            'status' => $request->status
        ]);
        // return response()->json([
        //     'message' => 'Booking Saved!'
        // ],201);

        return new BookingResource($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = booking::find($id);
        // return response()->json([
        //     'booking' => $booking
        // ],201);
        return new BookingResource($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required'],
            'date'  => ['required', 'date'],
            'status' => ['required'],
        ]);

        $booking = Booking::find($id);
        // dd($booking);
        $booking->update([
            'title' => $request->title,
            'date'  => $request->date,
            'status' => $request->status
        ]);

        // return response()->json([
        //     'message' => 'Booking Updated!'
        // ], 201);
        return new BookingResource($booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Booking::find($id)->delete();
        return response()->json(
        [
            'message' => 'Booking Delete!'
        ],201);
    }
}