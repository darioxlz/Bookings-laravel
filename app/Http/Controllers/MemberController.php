<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'joinAfter' => 'date',
            'joinBefore' => 'date|after:joinAfter'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 400);
        }


        $members = Member::query();

        if ($request->has('joinAfter')) {
            $members = $members->whereDate('joindate', '>=', $request->joinAfter);
        }

        if ($request->has('joinBefore')) {
            $members = $members->whereDate('joindate', '<=', $request->joinBefore);
        }

        return $members->orderBy('memid')->get();
    }

//    public function reservations($id)
//    {
//        return Booking::getReservationsByMemId($id)->get();
//    }

    public function show(Member $member)
    {
        return $member;
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'surname' => 'required|string|min:3|max:255',
            'firstname' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
            'zipcode' => 'required|integer|min:3',
            'telephone' => 'required|min:3',
            'recommendedby' => 'integer|exists:members,memid',
            'createdby' => 'required|integer|exists:users,userid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 422);
        }


        $member = Member::create($request->all());

        return response()->json($member, 201);
    }

    public function update(Request $request, Member $member)
    {
        $validated = Validator::make($request->all(), [
            'surname' => 'string|min:3|max:255',
            'firstname' => 'string|min:3|max:255',
            'address' => 'string|min:3|max:255',
            'zipcode' => 'min:3',
            'telephone' => 'min:3',
            'recommendedby' => 'integer|exists:members,memid'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->first(), 422);
        }


        $member->update($request->all());

        return response()->json($member, 200);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json($member, 204);
    }
}
