<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
   
    public function index(Request $request)
    {
       $query=Member::with('activeBorrowings');

       if($request->has('name')){
        $query->where('name','like','%'.$request->name .'%');
       }
       //filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
       $members=$query->paginate(10);
       return MemberResource::collection($members);
    }

    
    public function store(StoreMemberRequest $request)
    {

        $member=Member::create($request->validated());

        return new MemberResource($member);
    }

 
    public function show(Member $member)
    {   
        $member->load('activeBorrowings');
        return new MemberResource($member);
    }

   
    public function update(StoreMemberRequest $request,Member $member )
    {
        $member->update($request->validated());

        return new MemberResource($member);
    }

    public function destroy(Member $member)
    {

        //check if member has any browwings

        if($member->activeBorrowings()->count()){
            return response()->json([
                'message'=>'Cannot delete member with active borrowings'
            ]);
        }
        $member->delete();
        return response()->json([
            'message'=>'Member has been removed'
        ]);
    }
}
