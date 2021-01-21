<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Facilitie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacilitieController extends Controller
{
    public function index() {
        return Facilitie::orderBy('facid')->get();
    }

    public function reservations($id) {
        return Booking::whereHas('facility', function ($query) use ($id) {
            $query->where('facid', '=', $id);
        })->orderBy('bookid')->get();
    }

    public function show($id) {
        return Facilitie::where('facid', '=', $id)->get();
    }

    public function store(Request $request) {
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
        } else {
            $facilitie = Facilitie::create($request->all());

            return response()->json($facilitie, 201);
        }
    }

    public function update(Request $request, $id) {
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
        } else {
            Facilitie::findOrFail($id)->update($request->all());

            return response()->json(Facilitie::findOrFail($id), 200);
        }
    }

    public function delete($id) {
        Facilitie::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
