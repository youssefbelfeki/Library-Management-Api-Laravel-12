<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeBorrowingRequest;
use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'member']);

        // Apply filters by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        // Apply filters by member_id
        if ($request->has('member_id')) {
            $query->where('member_id', $request->member_id);
        }
        $borrowing = $query->latest()->paginate(10);
        return BorrowingResource::collection($borrowing);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeBorrowingRequest $request)
    {
        $book = Book::find($request->book_id);
        if (!$book->isAvailable()) {
            return response()->json(['status' => false, 'message' => 'Book is not available for borrowing'], 400);
        } else {
            $borrowing = Borrowing::create($request->validated());
            // Update book availability
            $book->borrow();
            $borrowing->load(['book', 'member']);
            return new BorrowingResource($borrowing);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing  $borrowing)
    {
        $borrowing->load(['book', 'member']);
        return new BorrowingResource($borrowing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return response()->json(data: [
                'message' => 'Book has already been returned'
            ], status: 422);
        }

        // Update borrowing record  
        $borrowing->update([
            'returned_date' => now(),
            'status' => 'returned'
        ]);

        // Update book availability  
        $borrowing->book->returnBook();
        $borrowing->load(['book', 'member']);
        return new BorrowingResource($borrowing);
    }

    public function overdue()
    {
        $overdueBorrowings = Borrowing::with(relations: ['book', 'member'])
            ->where('status', 'borrowed')
            ->where('due_date', '<', value: now())
            ->get();

        // Update status to overdue  
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', value: now())
            ->update(['status' => 'overdue']);

        return BorrowingResource::collection($overdueBorrowings);
    }
}
