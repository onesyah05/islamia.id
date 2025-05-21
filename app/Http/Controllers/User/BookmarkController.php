<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return view('front.pages.needLogin')->with('error', 'Silakan login terlebih dahulu untuk mengajukan pertanyaan');
        }
        $query = auth()->user()->bookmarks()
            ->with(['question' => function($query) {
                $query->with('categories');
            }]);

        // Filter by category if requested
        if ($request->has('category')) {
            $query->whereHas('question.categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $bookmarks = $query->latest()->paginate(10);

        // Get unique categories from bookmarked questions
        $categories = auth()->user()->bookmarks()
            ->with('question.categories')
            ->get()
            ->pluck('question.categories')
            ->flatten()
            ->unique('id')
            ->values();

        return view('front.pages.collaction', compact('bookmarks', 'categories'));
    }

    public function store($id)
    {
        
        $question = Question::findOrFail($id);
        // Check if already bookmarked
        if (auth()->user()->bookmarks()->where('question_id', $question->id)->exists()) {
            return back()->with('warning', 'Pertanyaan sudah ada di bookmark');
        }

        auth()->user()->bookmarks()->create([
            'question_id' => $question->id
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan ke bookmark');
    }

    public function destroy($id)
    {
        $bookmark = auth()->user()->bookmarks()->findOrFail($id);
        $bookmark->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus dari bookmark');
    }
}