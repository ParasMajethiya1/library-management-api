<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Services\BookCacheService;

class BookController extends Controller
{
    protected $bookCacheService;

    /**
     * Constructor to inject the BookCacheService.
     */
    public function __construct(BookCacheService $bookCacheService)
    {
        $this->bookCacheService = $bookCacheService;
    }

    public function index(Request $request)
    {
        $page = $request->query('page', 1); // Get the current page number

        // Cache the paginated results for the current page
        $books = Cache::remember('books_page_' . $page, 60, function () {
            return Book::paginate(10); // Paginate the books
        });
    
        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => $books,
        ], 200);
    }

    /**
     * Store a newly created book in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create the book
        $book = Book::create($request->only(['title', 'author', 'description']));

        // Clear cache for all pages using the BookCacheService
        $this->bookCacheService->clearBooksCache();

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    /**
     * Display the specified book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Book retrieved successfully',
            'data' => $book,
        ], 200);
    }

    /**
     * Update the specified book in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the book
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update the book
        $book->update($request->only(['title', 'author', 'description']));
        
        // Clear cache for all pages using the BookCacheService
        $this->bookCacheService->clearBooksCache();

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book,
        ], 200);
    }

    /**
     * Remove the specified book from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the book
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        // Delete the book
        $book->delete();

        // Clear cache for all pages using the BookCacheService
        $this->bookCacheService->clearBooksCache();

        return response()->json([
            'message' => 'Book deleted successfully',
        ], 200);
    }
}