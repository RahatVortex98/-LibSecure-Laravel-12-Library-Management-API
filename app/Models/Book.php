<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'description',
        'author_id',
        'genre',
        'published_date',
        'total_copies',
        'available_copies',
        'price',
        'cover_image',
        'status'
    ];




     public function author(){

        return $this->belongsTo(Author::class);
    }

     public function borrowings(){

        return $this->hasMany(Borrowing::class);
    }



    //decrease availble_copies

    public function borrow()
{
    if ($this->available_copies > 0 && $this->status === 'available') {
        $this->decrement('available_copies');

        if ($this->available_copies - 1 === 0) {
            $this->update(['status' => 'not_available']);
        }
    }
}


    //increment availble_copies when

    public function returnBook()
        {
            if ($this->available_copies < $this->total_copies) {
                $this->increment('available_copies');
                $this->update(['status' => 'available']);
            }
        }

        public function isAvailable(): bool
            {
                return $this->available_copies > 0 && $this->status === 'available';
            }


}
