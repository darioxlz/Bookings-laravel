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
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }

        $bookings = Booking::with('member')->with('facility');

        if ($request->has('dateAfter')) {
            $bookings = $bookings->whereDate('starttime', '>=', $request->dateAfter);
        }

        if ($request->has('dateBefore')) {
            $bookings = $bookings->whereDate('starttime', '<=', $request->dateBefore);
        }

        return $bookings->orderBy('bookid')->simplePaginate(15);
    }

    public function show($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        return response()->json($booking, 200);
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
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }


        $booking = Booking::create($request->all());

        return response()->json($booking, 201);
    }

    public function update(Request $request, $booking_id)
    {
        $validated = Validator::make($request->all(), [
            'facid' => 'integer|exists:facilities,facid',
            'memid' => 'integer|exists:members,memid',
            'starttime' => 'date',
            'slots' => 'integer',
            'createdby' => 'integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }

        $booking = Booking::findOrFail($booking_id);
        $booking->update($request->all());

        return response()->json($booking, 200);
    }

    public function destroy($booking_id)
    {
        Booking::findOrFail($booking_id)->delete();

        return response()->json(array('message' => 'resource deleted'), 200);
    }
}
