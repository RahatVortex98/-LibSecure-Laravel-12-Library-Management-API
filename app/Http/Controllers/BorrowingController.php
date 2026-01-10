<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Http\Requests\UpdateBorrowingRequest;
use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BorrowingController extends Controller
{
    
    public function index(Request $request)
    {
       $query=Borrowing::with(['book','member']);

       //filter by status
       if($request->has('status')){
            $query->where('status',$request->status);
       }
       //filter by member
       if($request->has('member_id')){
            $query->where('member_id',$request->member_id);
       }
       $borrowings=$query->latest()->paginate(10);
       return BorrowingResource::collection($borrowings);
    }

   
 

public function store(StoreBorrowingRequest $request)
{   
    $book = Book::findOrFail($request->book_id);

    if(!$book->isAvailable()){
        return response()->json(['message' => 'Book is not available'], 422);
    }

    // Wrap in a transaction for safety
    $borrowing = DB::transaction(function () use ($request, $book) {
        $borrowing = Borrowing::create($request->validated());
        $book->borrow();
        return $borrowing;
    });

    return new BorrowingResource($borrowing->load(['member', 'book']));
}

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
       $borrowing->load(['book','member']);
       return new BorrowingResource($borrowing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function returnBook(UpdateBorrowingRequest $request, Borrowing $borrowing)
    {
        if($borrowing->status !=='borrowed'){
            return response()->json([
                'message'=>'Book has already been returned'
            ]);
        }
        //update borrowing record
        $borrowing->update([
            'returned_date'=>now(),
            'status'=>'returned'
        ]);
        //update book availablity
        $borrowing->book->returnBook();
        $borrowing->load(['book','member']);
        return new BorrowingResource($borrowing);
    }

    public function overdue()
{
    // Mark overdue items in bulk
    Borrowing::overdueItems()->update(['status' => 'overdue']);

    // Retrieve them
    $overdueBorrowings = Borrowing::with(['book', 'member'])
        ->where('status', 'overdue')
        ->latest()
        ->get();

    return BorrowingResource::collection($overdueBorrowings);
}
}
