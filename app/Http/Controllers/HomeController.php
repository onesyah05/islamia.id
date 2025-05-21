<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Answer;

class HomeController extends Controller
{
    function index() {
        $popularQuestions = Question::orderBy('views', 'desc')
            ->where('is_answered', true)
            ->with(['answers', 'categories'])
            ->limit(5)
            ->get();

        $latestQuestions = Question::orderBy('created_at', 'desc')
            ->where('is_answered', true)
            ->with(['answers', 'categories'])
            ->limit(5)
            ->get();

        return view('front.pages.home', compact('popularQuestions', 'latestQuestions'));
    }

    /**
     * Handle question search.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $sortBy = $request->input('sort_by', 'relevance'); // Default sort by relevance

        $questionsQuery = Question::with(['user', 'categories', 'answers.user'])
            ->where('is_answered', true); // Only include answered questions

        // Apply search filter
        if ($query) {
            $questionsQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
                // Note: Relevance sorting typically requires full-text search features or more complex logic.
                // For a basic implementation, we'll just apply keyword matching here.
            });
        }

        // Apply sorting
        if ($sortBy === 'date') {
            $questionsQuery->orderBy('created_at', 'desc');
        } elseif ($sortBy === 'views') {
            $questionsQuery->orderBy('views', 'desc');
        } else {
            // Default or 'relevance' sorting (basic keyword match ordering)
            // More advanced relevance would require a different approach.
             $questionsQuery->latest(); // Sort by latest if no specific sort or relevance is requested
        }

        // Paginate results
        $questions = $questionsQuery->paginate(10)->withQueryString(); // Preserve query string for pagination links

        return view('front.pages.search', compact('questions'));
    }
}
