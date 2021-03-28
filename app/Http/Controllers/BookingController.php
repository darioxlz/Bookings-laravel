<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'dateAfter' => 'date',
            'dateBefore' => 'date|after:dateAfter'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        }


        $bookings = Booking::with('member')->with('facility');

        if ($request->has('dateAfter')) {
            $bookings = $bookings->whereDate('starttime', '>=', $request->dateAfter);
        }

        if ($request->has('dateBefore')) {
            $bookings = $bookings->whereDate('starttime', '<=', $request->dateBefore);
        }

        return $bookings->orderBy('bookid')->get();
    }

    public function show(Booking $booking)
    {
        return $booking;
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'facid' => 'required|integer|exists:facilities,facid',
            'memid' => 'required|integer|exists:members,memid',
            'starttime' => 'required|date',
            'slots' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 422);
        }


        $booking = Booking::create($request->all());

        return response()->json($booking, 201);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = Validator::make($request->all(), [
            'facid' => 'integer|exists:facilities,facid',
            'memid' => 'integer|exists:members,memid',
            'starttime' => 'date',
            'slots' => 'integer',
            'createdby' => 'integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        }


        $booking->update($request->all());

        return response()->json($booking, 200);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json(null, 204);
    }
}
