<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Borrowing extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowingFactory> */
    use HasFactory;


    protected $fillable = [
        'book_id',
        'member_id',
        'borrowed_date',
        'due_date',
        'return_date',
        'status'
    ];
    protected $casts = [
        'borrowed_date'=>'date',
        'due_date'=>'date',
        'returned_date'=>'date',
    ];


     public function member(){

        return $this->belongsTo(Member::class);
    }

     public function book(){

        return $this->belongsTo(Book::class);
    }
    //if borrowed book overdue
protected function isOverdue(): Attribute
{
    return Attribute::make(
        get: fn () => $this->due_date < now() && $this->status === 'borrowed',
    );
}
public function checkOverdue(): bool
{
    return $this->due_date < now()
        && $this->status === 'borrowed';
}
// Inside Borrowing Model
public function scopeOverdueItems($query)
{
    return $query->where('status', 'borrowed')
                 ->where('due_date', '<', now());
}


}
