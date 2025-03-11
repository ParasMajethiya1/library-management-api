<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Book;

class BookCacheService
{
    /**
     * Clear the cache for all pages of books.
     */
    public function clearBooksCache()
    {
        $totalBooks = Book::count(); // Get the total number of books
        $perPage = 10; // Number of items per page
        $totalPages = ceil($totalBooks / $perPage); // Calculate total pages

        // Loop through each page and clear its cache
        for ($page = 1; $page <= $totalPages; $page++) {
            Cache::forget('books_page_' . $page); // Clear cache for each page
        }
    }
}