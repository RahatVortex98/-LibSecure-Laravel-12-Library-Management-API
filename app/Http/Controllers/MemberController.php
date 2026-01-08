<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
   
    public function index()
    {
       $members=Member::paginate(10);
       return MemberResource::collection($members);
    }

    
    public function store(StoreMemberRequest $request)
    {

        $member=Member::create($request->validated());

        return new MemberResource($member);
    }

 
    public function show(Member $member)
    {
        return new MemberResource($member);
    }

   
    public function update(StoreMemberRequest $request,Member $member )
    {
        $member->update($request->validated());

        return new MemberResource($member);
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json([
            'message'=>'Member has been removed'
        ]);
    }
}
