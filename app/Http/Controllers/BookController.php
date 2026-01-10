<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use App\Models\Book;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Start query
    $query = Book::with('author');

    // Filter by title if provided
    if ($request->has('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    // Filter by genre if provided
    if ($request->has('genre')) {
        $query->where('genre', 'like', '%' . $request->genre . '%');
    }

    // Paginate results
    $books = $query->paginate(10);

    // Return as resource collection
    return BookResource::collection($books);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        $book->load('author');

        return new BookResource($book);

    }

   
    public function show(Book $book)
    {
       try {
        
         $book->load('author');
        return new BookResource($book); 
       } catch (\Exception $th) {
         return response()->json([
            'message'=>'Book Not Found!'
         ],404);
       }       
    }

    
    public function update(StoreBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        $book->load('author');
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'message'=>'book has been deleted',
        ]);
    }
}
