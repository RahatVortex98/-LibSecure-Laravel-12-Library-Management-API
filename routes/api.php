<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('authors',AuthorController::class);

Route::apiResource('books',BookController::class);
Route::apiResource('members',MemberController::class);

Route::apiResource('borrowings',BorrowingController::class)->only(['index','store','show']);

//return & overdue
Route::post('borrowings/{borrowing}/return',[BorrowingController::class,'returnBook']);
Route::get('borrowings/overdue/list',[BorrowingController::class,'overdue']);



Route::middleware('auth:sanctum')->group( function(){

    Route::apiResource('authors',AuthorController::class);
    Route::get('/logout',[AuthController::class,'logout']);
});




//statistic

Route::get('statistics',function(){
    return response()->json([
        'total_books'=>\App\Models\Book::count(),
        'total_authors'=>\App\Models\Author::count(),
        'total_members'=>\App\Models\Member::count(),
        'book_borrowed'=>\App\Models\Borrowing::where('status','borrowed')->count(),
        'overdue_borrowings'=>\App\Models\Borrowing::where('status','overdue')->count(),
    ]);
});

//auth
Route::post('/registration',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);