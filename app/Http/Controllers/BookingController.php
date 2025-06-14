<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['room.hotel', 'user'])
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Bookings retrieved successfully',
            'data' => $bookings,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $room_id)
    {
        $validator = Validator::make($request->all(), [
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $room = Room::findOrFail($room_id);

        $isBooked = $room->bookings()
            ->where(function ($q) use ($request) {
                $q->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date]);
            })->exists();

        if($isBooked) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room is already booked for the selected dates',
            ], Response::HTTP_CONFLICT);
        }

        $booking = $room->bookings()->create([
            'user_id' => auth()->id(),
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'room_id' => $room_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::with(['room.hotel'])->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Booking retrieved successfully',
            'data' => $booking,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
