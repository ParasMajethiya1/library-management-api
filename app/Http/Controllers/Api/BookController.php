<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Services\BookCacheService;

/**
 * @OA\Info(
 *      title="Book API",
 *      version="1.0.0",
 *      description="API documentation for managing books"
 * )
 * 
 * @OA\Tag(
 *     name="Books",
 *     description="API Endpoints for Books"
 * )
 */
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

    /**
     * Get Paginated List of Books
     *
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Retrieve paginated list of books",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=200, description="Books retrieved successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $books = Cache::remember('books_page_' . $page, 60, function () {
            return Book::paginate(10);
        });

        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => $books,
        ], 200);
    }

    /**
     * Store a New Book
     *
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author"},
     *             @OA\Property(property="title", type="string", example="The Great Gatsby"),
     *             @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *             @OA\Property(property="description", type="string", example="A novel set in the 1920s")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Book created successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */
    public function store(Request $request)
    {
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

        $book = Book::create($request->only(['title', 'author', 'description']));
        $this->bookCacheService->clearBooksCache();

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    /**
     * Get Details of a Specific Book
     *
     * @OA\Get(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Retrieve a specific book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=200, description="Book retrieved successfully"),
     *     @OA\Response(response=404, description="Book not found"),
     * )
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'message' => 'Book retrieved successfully',
            'data' => $book,
        ], 200);
    }

    /**
     * Update a Book
     *
     * @OA\Put(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Update a book's details",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="author", type="string", example="Updated Author"),
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Book updated successfully"),
     *     @OA\Response(response=404, description="Book not found"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

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

        $book->update($request->only(['title', 'author', 'description']));
        $this->bookCacheService->clearBooksCache();

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book,
        ], 200);
    }

    /**
     * Delete a Book
     *
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=200, description="Book deleted successfully"),
     *     @OA\Response(response=404, description="Book not found"),
     * )
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        $this->bookCacheService->clearBooksCache();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}