<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\BookBorrowed;
use App\Events\BookReturned;

class BorrowController extends Controller
{
    /**
     * Borrow a book.
     *
     * @param Request $request
     * @param int $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrow(Request $request, $bookId)
    {
        // Find the book
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        // Check if the book is available
        if ($book->status !== 'available') {
            return response()->json([
                'message' => 'Book is not available for borrowing',
            ], 400);
        }

        // Get the authenticated user
        $user = $request->user();

        // Update the book status
        $book->status = 'borrowed';
        $book->borrower_id = $user->id; // Track the borrower
        $book->save();

        // Dispatch the BookBorrowed event
        event(new BookBorrowed($user, $book));

        return response()->json([
            'message' => 'Book borrowed successfully',
            'book' => $book,
        ], 200);
    }

    /**
     * Return a borrowed book.
     *
     * @param Request $request
     * @param int $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function return(Request $request, $bookId)
    {
        // Find the book
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        // Check if the book is borrowed
        if ($book->status !== 'borrowed') {
            return response()->json([
                'message' => 'Book is not currently borrowed',
            ], 400);
        }

        // Get the authenticated user
        $user = $request->user();

        // Check if the user is the borrower
        if ($book->borrower_id !== $user->id) {
            return response()->json([
                'message' => 'You are not the borrower of this book',
            ], 403);
        }

        // Update the book status
        $book->status = 'available';
        $book->borrower_id = null; // Clear the borrower
        $book->save();

        // Dispatch the BookReturned event
        event(new BookReturned($user, $book));

        return response()->json([
            'message' => 'Book returned successfully',
            'book' => $book,
        ], 200);
    }
}
