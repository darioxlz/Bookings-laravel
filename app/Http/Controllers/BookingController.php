<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request) {
        $validated = Validator::make($request->all(), [
            'dateAfter' => 'date',
            'dateBefore' => 'date|after:dateAfter'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        } else {
            $bookings = Booking::with('member')->with('facility');

            if ($request->has('dateAfter')) {
                $bookings = $bookings->whereDate('starttime', '>=', $request->dateAfter);
            }

            if ($request->has('dateBefore')) {
                $bookings = $bookings->whereDate('starttime', '<=', $request->dateBefore);
            }

            return $bookings->orderBy('bookid')->get();
        }
    }

    public function show($id) {
        return Booking::with('member')->with('facility')->findOrFail($id);
    }

    public function store(Request $request) {
        $validated = Validator::make($request->all(), [
            'facid' => 'required|integer|exists:facilities,facid',
            'memid' => 'required|integer|exists:members,memid',
            'starttime' => 'required|date',
            'slots' => 'required|integer',
            'createdby' => 'required|integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        } else {
            $booking = Booking::create($request->all());

            return response()->json($booking, 201);
        }
    }

    public function update(Request $request, $id) {
        $validated = Validator::make($request->all(), [
            'facid' => 'integer|exists:facilities,facid',
            'memid' => 'integer|exists:members,memid',
            'starttime' => 'date',
            'slots' => 'integer',
            'createdby' => 'integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        } else {
            Booking::findOrFail($id)->update($request->all());

            return response()->json(Booking::findOrFail($id), 200);
        }
    }

    public function delete($id) {
        Booking::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
