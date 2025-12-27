<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;
class AuthorController extends Controller
{
    
    public function index()
    {
        $authors = Author::withCount('books')->paginate(10);
        // return response()->json([
        //     'authors'=>$authors,
        //     'message'=>'Successfully fetched'
        // ],status:200);
        return AuthorResource::collection($authors);
    }

    
    public function store(Request $request)
    {
        $validate = request()->validate([
            'name'=>'required|string|max:255',
            'bio'=>'nullable|string',
            'nationality'=>'nullable|string'
        ]);

        $author =Author::create($validate);
        return new AuthorResource($author);

    }

   
    public function show(Author $author)
    {
      return new AuthorResource($author);
    }

    public function update(Request $request, Author $author)
    {
        $validate = request()->validate([
            'name'=>'required|string|max:255',
            'bio'=>'nullable|string',
            'nationality'=>'nullable|string'
        ]);
        $author->update($validate);
        return new AuthorResource($author);
      
    }

   
    public function destroy(Author $author)
    {
       $author->delete();

       return response()->json([

        'message'=>'Data was Deleted'

       ]);
    }
}
