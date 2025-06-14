<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hotel_id)
    {
        $rooms = Room::where('hotel_id', $hotel_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $rooms,
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
    public function store(Request $request, $hotel_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $room = Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'hotel_id' => $hotel_id,
            'price' => $request->price ?? 0, // Default price to 0 if not provided
            'description' => $request->description ?? '',
        ]);
        return response()->json([
            'status' => 'success',
            'data' => $room,
        ], Response::HTTP_CREATED);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found',
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => 'success',
            'data' => $room,
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $room->update($request->only(['name', 'capacity', 'price', 'description']));
        return response()->json([
            'status' => 'success',
            'data' => $room,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $room->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Room deleted successfully',
        ], Response::HTTP_OK);
    }
}
