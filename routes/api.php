<?php

use App\Http\Controllers\Api\V2\BookController as BookControllerV2;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MemberController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//authenticated routes 
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    //Version 1
    Route::prefix('V1')->group(function () {

        Route::get('/user', [AuthController::class, 'user']);

        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('books', BookController::class);
        Route::apiResource('members', MemberController::class);
        Route::apiResource('borrowings', BorrowingController::class)->only(['index', 'store', 'show']);

        //return & overdue borrowings
        Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);
        Route::get('borrowings/overdue/list', [BorrowingController::class, 'overdue']);

        Route::get('statistics',  function () {
            return response()->json([
                'total_books' => Book::count(),
                'total_authors' => Author::count(),
                'total_members' => Member::count(),
                'books_borrowed' => Borrowing::where('status', 'borrowed')->count(),
                'overdue_borrowings' => Borrowing::where('status', 'overdue')->count(),
            ]);
        });
        Route::post('logout', [AuthController::class, 'logout']);
    });

    //Version 2
    Route::prefix('V2')->group(function () {

        Route::get('/user', [AuthController::class, 'user']);

        Route::get('/firstfiveBooks', BookControllerV2::class,'firstfiveBooks');
        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('books', BookController::class);
        Route::apiResource('members', MemberController::class);
        Route::apiResource('borrowings', BorrowingController::class)->only(['index', 'store', 'show']);

        //return & overdue borrowings
        Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);
        Route::get('borrowings/overdue/list', [BorrowingController::class, 'overdue']);

        Route::get('statistics',  function () {
            return response()->json([
                'total_books' => Book::count(),
                'total_authors' => Author::count(),
                'total_members' => Member::count(),
                'books_borrowed' => Borrowing::where('status', 'borrowed')->count(),
                'overdue_borrowings' => Borrowing::where('status', 'overdue')->count(),
            ]);
        });
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
