<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilitie;
use Illuminate\Support\Facades\Validator;

class FacilitieController extends Controller
{
    public function index()
    {
        return Facilitie::orderBy('facid')->simplePaginate(5);
    }

    public function show($facility_id)
    {
        $facility = Facilitie::findOrFail($facility_id);

        return response()->json($facility, 200);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'membercost' => 'required|numeric',
            'guestcost' => 'required|numeric',
            'initialoutlay' => 'required|numeric',
            'monthlymaintenance' => 'required|numeric'
        ]);

        if ($validated->fails()) {
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }


        $facilitie = Facilitie::create($request->all());

        return response()->json($facilitie, 201);
    }

    public function update(Request $request, $facility_id)
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
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }


        $facility = Facilitie::findOrFail($facility_id);
        $facility->update($request->all());

        return response()->json($facility, 200);
    }

    public function destroy($facility_id)
    {
        Facilitie::findOrFail($facility_id)->delete();

        return response()->json(array('message' => 'resource deleted'), 200);
    }
}
