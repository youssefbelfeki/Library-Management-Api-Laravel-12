<?php

use App\Http\Controllers\BorrowingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('authors', App\Http\Controllers\AuthorController::class);
Route::apiResource('books', App\Http\Controllers\BookController::class);
Route::apiResource('members', App\Http\Controllers\MemberController::class);
Route::apiResource('borrowings', App\Http\Controllers\BorrowingController::class)->only(['index', 'store', 'show']);

//return & overdue borrowings
Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);
Route::get('borrowings/overdue/list', [BorrowingController::class, 'overdue']);

Route::get('statistics',  function () {
    return response()->json([
        'total_books' => \App\Models\Book::count(),
        'total_authors' => \App\Models\Author::count(),
        'total_members' => \App\Models\Member::count(),
        'books_borrowed' => \App\Models\Borrowing::where('status', 'borrowed')->count(),
        'overdue_borrowings' => \App\Models\Borrowing::where('status', 'overdue')->count(),
    ]);
});
