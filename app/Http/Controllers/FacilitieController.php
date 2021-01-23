<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Facilitie;
use Illuminate\Support\Facades\Validator;

class FacilitieController extends Controller
{
    public function index()
    {
        return Facilitie::orderBy('facid')->get();
    }

    public function reservations($id)
    {
        return Booking::getReservationsByFacId($id)->get();
    }

    public function show(Facilitie $facilitie)
    {
        return $facilitie;
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'membercost' => 'required|numeric',
            'guestcost' => 'required|numeric',
            'initialoutlay' => 'required|numeric',
            'monthlymaintenance' => 'required|numeric',
            'createdby' => 'required|integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        }


        $facilitie = Facilitie::create($request->all());

        return response()->json($facilitie, 201);
    }

    public function update(Request $request, Facilitie $facilitie)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'string|min:3|max:255',
            'membercost' => 'numeric',
            'guestcost' => 'numeric',
            'initialoutlay' => 'numeric',
            'monthlymaintenance' => 'numeric',
            'createdby' => 'integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        }


        $facilitie->update($request->all());

        return response()->json($facilitie, 200);
    }

    public function destroy(Facilitie $facilitie)
    {
        $facilitie->delete();

        return response()->json(null, 204);
    }
}
