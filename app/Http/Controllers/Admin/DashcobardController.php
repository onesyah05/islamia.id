<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Bookmark;
use App\Models\Answer;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashcobardController extends Controller
{
    function index() {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        $isUstadz = $user->role === 'ustadz';

        // Get total counts for dashboard cards
        $totalUsers = User::where('role', 'user')->count();
        $totalUstadz = User::where('role', 'ustadz')->count();
        $totalQuestions = Question::count();
        $totalBookmarks = Bookmark::count();
        $totalAnswers = Answer::count();
        $totalCategories = Category::count();

        // Get recent questions with user and category relationships
        $recentQuestions = Question::with(['user', 'categories'])
            ->when($isUstadz, function($query) use ($user) {
                return $query->whereHas('answers', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        // Get recent users with their questions count
        $recentUsers = User::withCount(['questions', 'answers'])
            ->when($isUstadz, function($query) use ($user) {
                return $query->where('id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // Get questions by category with category name
        $questionsByCategory = Category::withCount('questions')
            ->when($isUstadz, function($query) use ($user) {
                return $query->whereHas('questions', function($q) use ($user) {
                    $q->whereHas('answers', function($ans) use ($user) {
                        $ans->where('user_id', $user->id);
                    });
                });
            })
            ->get();

        // Get monthly questions for the chart
        $monthlyQuestions = Question::selectRaw('MONTH(created_at) as month, count(*) as total')
            ->when($isUstadz, function($query) use ($user) {
                return $query->whereHas('answers', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get unanswered questions count
        $unansweredQuestions = Question::whereDoesntHave('answers')
            ->when($isUstadz, function($query) use ($user) {
                return $query->whereHas('category', function($q) use ($user) {
                    $q->where('ustadz_id', $user->id);
                });
            })
            ->count();

        // Additional statistics for both roles
        $topCategories = Category::withCount('questions')
            ->orderBy('questions_count', 'desc')
            ->take(5)
            ->get();

        $topUstadz = User::where('role', 'ustadz')
            ->withCount(['answers', 'questions'])
            ->orderBy('answers_count', 'desc')
            ->take(5)
            ->get();

        // Ustadz specific statistics
        $ustadzStats = null;
        if ($isUstadz) {
            $ustadzStats = [
                'total_answers' => Answer::where('user_id', $user->id)->count(),
                'total_questions_answered' => Question::whereHas('answers', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->count(),
                'recent_answers' => Answer::where('user_id', $user->id)
                    ->with(['question', 'user'])
                    ->latest()
                    ->take(5)
                    ->get()
            ];
        }

        return view('admin.pages.dashboard.index', compact(
            'totalUsers',
            'totalUstadz', 
            'totalQuestions',
            'totalBookmarks',
            'totalAnswers',
            'totalCategories',
            'recentQuestions',
            'recentUsers',
            'questionsByCategory',
            'monthlyQuestions',
            'unansweredQuestions',
            'topCategories',
            'topUstadz',
            'ustadzStats',
            'isAdmin',
            'isUstadz'
        ));
    }
}
