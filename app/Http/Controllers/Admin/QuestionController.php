<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\User;
use App\Models\Answer;
use App\Models\Notification;
use App\Models\CategoryQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questions = Question::with(['user', 'categories', 'answers']);

        if ($user->role === 'admin') {
            $questions = $questions->latest();
        } else if ($user->role === 'ustadz') {
            $questions = $questions->where(function($query) use ($user) {
                $query->whereHas('answers', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orWhere(function($q) use ($user) {
                    $q->whereDoesntHave('answers')
                      ->whereHas('categories', function($q) use ($user) {
                          $q->whereIn('categories.id', $user->categories->pluck('id'));
                      });
                });
            })->latest();
        }

        $questions = $questions->paginate(10);
        return view('admin.pages.question.index', compact('questions'));
    }

    public function create()
    {
        $categories = Category::all();
        $ustadzList = User::where('role', 'ustadz')->get();
        return view('admin.pages.question.create', compact('categories', 'ustadzList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'answer_content' => 'nullable|string',
            'ustadz_id' => 'nullable|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $question = Question::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . time(),
                'content' => $request->content,
                'is_answered' => false,
                'views' => 0
            ]);

            foreach ($request->category_ids as $categoryId) {
                CategoryQuestion::create([
                    'question_id' => $question->id,
                    'category_id' => $categoryId
                ]);
            }

            if ($request->filled('answer_content')) {
                $answerUserId = $request->ustadz_id ?? $user->id;
                Answer::create([
                    'question_id' => $question->id,
                    'user_id' => $answerUserId,
                    'content' => $request->answer_content,
                ]);

                $question->is_answered = true;
                $question->save();

                Notification::create([
                    'user_id' => $question->user_id,
                    'title' => 'Pertanyaan Anda Dijawab',
                    'body' => "Pertanyaan Anda '{$question->title}' telah dijawab",
                    'is_read' => false
                ]);
            }

            DB::commit();
            return redirect()->route('dashboard.questions.index')->with('success', 'Question created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create question: ' . $e->getMessage());
        }
    }

    public function edit(Question $question)
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            $isUstadzAnswerer = $question->answers->where('user_id', $user->id)->count() > 0;
            $isUnansweredAndInCategory = $question->answers->count() === 0 && 
                $question->categories->whereIn('id', $user->categories->pluck('id'))->count() > 0;

            if (!$isUstadzAnswerer && !$isUnansweredAndInCategory) {
                abort(403, 'Unauthorized action.');
            }
        }

        $categories = Category::all();
        $ustadzList = User::where('role', 'ustadz')->get();
        $question->load(['categories', 'answers.user']);
        $currentAnswer = $question->answers->first();
        
        return view('admin.pages.question.edit', compact('question', 'categories', 'ustadzList', 'currentAnswer'));
    }

    public function update(Request $request, Question $question)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            $isUstadzAnswerer = $question->answers->where('user_id', $user->id)->count() > 0;
            $isUnansweredAndInCategory = $question->answers->count() === 0 && 
                $question->categories->whereIn('id', $user->categories->pluck('id'))->count() > 0;

            if (!$isUstadzAnswerer && !$isUnansweredAndInCategory) {
                abort(403, 'Unauthorized action.');
            }
        }

        try {
            // Debug request data before validation
            // dump('Request Data:', $request->all());

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_ids' => 'required|array',
                'answer_content' => 'nullable|string',
                'ustadz_id' => 'nullable|exists:users,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            // Update Question details (only if admin or if not answered by this ustadz)
            if ($user->role === 'admin' || ($user->role === 'ustadz' && $question->answers()->where('user_id', $user->id)->count() === 0)) {
                $question->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . time(),
                    'content' => $request->content,
                ]);

                
                
                $existingCategories = CategoryQuestion::where('question_id', $question->id)->pluck('category_id')->toArray();
                
                // Add new categories that don't exist yet
                foreach ($request->category_ids as $categoryId) {
                    if ($categoryId && !in_array($categoryId, $existingCategories)) {
                        CategoryQuestion::create([
                            'question_id' => $question->id,
                            'category_id' => $categoryId
                        ]);
                    }
                }
                
                // Remove categories that are no longer in the request
                CategoryQuestion::where('question_id', $question->id)
                    ->whereNotIn('category_id', $request->category_ids)
                    ->delete();

                Notification::create([
                    'user_id' => $question->user_id,
                    'title' => 'Pertanyaan Anda Diperbarui',
                    'body' => "Pertanyaan Anda '{$question->title}' telah diperbarui oleh " . ($user->role === 'admin' ? 'Admin' : 'Ustadz'),
                    'is_read' => false
                ]);
            }

            // Handle Answer
            if ($request->filled('answer_content')) {
                $answer = $question->answers()->where('user_id', $user->id)->first();

                if ($answer) {
                    $answer->update([
                        'content' => $request->answer_content,
                    ]);

                    Notification::create([
                        'user_id' => $question->user_id,
                        'title' => 'Jawaban Diperbarui',
                        'body' => "Jawaban untuk pertanyaan Anda '{$question->title}' telah diperbarui",
                        'is_read' => false
                    ]);
                } else if ($user->role === 'ustadz') {
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $user->id,
                        'content' => $request->answer_content,
                    ]);

                    Notification::create([
                        'user_id' => $question->user_id,
                        'title' => 'Pertanyaan Anda Dijawab',
                        'body' => "Pertanyaan Anda '{$question->title}' telah dijawab oleh Ustadz",
                        'is_read' => false
                    ]);
                } else if ($user->role === 'admin') {
                    $assignedUstadzId = $request->ustadz_id ?? Auth::id();
                    $adminAnswer = $question->answers()->where('user_id', $assignedUstadzId)->first();

                    if($adminAnswer) {
                        $adminAnswer->update([
                            'content' => $request->answer_content,
                        ]);

                        Notification::create([
                            'user_id' => $question->user_id,
                            'title' => 'Jawaban Admin Diperbarui',
                            'body' => "Jawaban Admin untuk pertanyaan Anda '{$question->title}' telah diperbarui",
                            'is_read' => false
                        ]);
                    } else {
                        Answer::create([
                            'question_id' => $question->id,
                            'user_id' => $assignedUstadzId,
                            'content' => $request->answer_content,
                        ]);

                        Notification::create([
                            'user_id' => $question->user_id,
                            'title' => 'Pertanyaan Anda Dijawab Admin',
                            'body' => "Pertanyaan Anda '{$question->title}' telah dijawab oleh Admin",
                            'is_read' => false
                        ]);
                    }
                }

                $question->is_answered = true;
                $question->save();
            }

            DB::commit();
            return redirect()->route('dashboard.questions.index')->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update question: ' . $e->getMessage());
        }
    }

    public function destroy(Question $question)
    {
        // Only admin can delete questions
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $question->delete();

        return redirect()->route('dashboard.questions.index')->with('success', 'Question deleted successfully.');
    }
}