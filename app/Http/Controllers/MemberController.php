<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        return Member::orderBy('memid')->simplePaginate(5);
    }

    public function show($member_id)
    {$member = Member::findOrFail($member_id);

        return response()->json($member, 200);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'surname' => 'required|string|min:3|max:255',
            'firstname' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
            'zipcode' => 'required|integer|min:3',
            'telephone' => 'required|min:3',
            'recommendedby' => 'integer|exists:members,memid'
        ]);

        if ($validated->fails()) {
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }

        $member = Member::create($request->all());

        return response()->json($member, 201);
    }

    public function update(Request $request, $member_id)
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
            return response()->json(array(
                'errors' => $validated->messages()
            ), 400);
        }

        $member = Member::findOrFail($member_id);
        $member->update($request->all());

        return response()->json($member, 200);
    }

    public function destroy($member_id)
    {
        Member::findOrFail($member_id)->delete();

        return response()->json(array('message' => 'resource deleted'), 200);
    }
}
