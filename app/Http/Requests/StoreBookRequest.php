<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {  
        
        // Get the current book ID if exists (null if store)
        $bookId = $this->route('book')?->id;
        return [
            
            'title'=>'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                // Unique in books table, ignore current book ID if updating
                Rule::unique('books', 'isbn')->ignore($bookId),
            ],
            'description'=>'nullable|string',
            'author_id'=>'required|exists:authors,id',
            'genre'=>'nullable|string',
            'published_at'=>'nullable|date',
            
            'total_copies'=>'required|integer|min:1',
            'price'=>'nullable|numeric|min:0',
            'cover_image'=>'nullable|string',

            //unique → “This value must not already exist”
            //exists → “This value must already exist”



        ];
    }
}
