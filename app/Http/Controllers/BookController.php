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
    public function index()
    {
       $books =Book::with('author')->paginate(10);

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
