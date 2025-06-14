<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function all(){
        $hotels = Hotel::with(['rooms'])->where('owner_id', auth()->id())->get();
        return response()->json([
            'status' => 'success',
            'data' => $hotels,
        ], Response::HTTP_OK);
    }

    public function index()
    {
        $hotels = Hotel::with(['rooms'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $hotels,
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $hotel = Hotel::create([
            'name' => $request->name,
            'location' => $request->location,
            'owner_id' => $request->owner_id,
        ]);
        return response()->json([
            'status' => 'success',
            'data' => $hotel,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hotel = Hotel::with(['rooms', 'owner'])->find($id);
        if (!$hotel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hotel not found',
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => 'success',
            'data' => $hotel,
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
    public function update(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'owner_id' => 'sometimes|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hotel not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $hotel->update($request->only(['name', 'location', 'owner_id']));
        return response()->json([
            'status' => 'success',
            'data' => $hotel,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hotel not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $hotel->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Hotel deleted successfully',
        ], Response::HTTP_OK);
    }
}
