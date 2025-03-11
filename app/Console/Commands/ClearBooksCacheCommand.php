<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BookCacheService;

class ClearBooksCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the cache for all books pages';

    /**
     * The BookCacheService instance.
     *
     * @var BookCacheService
     */
    protected $bookCacheService;

    /**
     * Create a new command instance.
     *
     * @param BookCacheService $bookCacheService
     */
    public function __construct(BookCacheService $bookCacheService)
    {
        parent::__construct();
        $this->bookCacheService = $bookCacheService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear the books cache using the BookCacheService
        $this->bookCacheService->clearBooksCache();

        $this->info('Books cache cleared successfully.');
    }
}