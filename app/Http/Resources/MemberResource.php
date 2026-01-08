<?php

namespace App\Http\Resources;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'name'=>$this->name,
            'email'=>$this->email,
            'phone_no'=>$this->phone_no,
            'address'=>$this->address,
            'membership_date'=>$this->membership_date,
            'status'=>$this->status,

            //Business logic:
            'active_borrowings_count' => $this->activeBorrowings()->count(),


        ];
    }
}
