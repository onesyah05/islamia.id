<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return view('front.pages.needLogin')->with('error', 'Silakan login terlebih dahulu untuk mengajukan pertanyaan');
        }

        $questions = Question::with(['categories', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('front.pages.question', compact('questions'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengajukan pertanyaan');
        }
        
        $categories = Category::all();
        return view('front.pages.question', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:20',
        ], [
            'content.required' => 'Pertanyaan harus diisi',
            'content.min' => 'Pertanyaan minimal 20 karakter'
        ]);

        // Check for unanswered questions
        $unansweredQuestions = Question::where('user_id', auth()->id())
            ->where('is_answered', false)
            ->count();

        if ($unansweredQuestions > 0) {
            return back()
                ->withInput()
                ->with('info', 'Anda masih memiliki ' . $unansweredQuestions . ' pertanyaan yang belum dijawab. Harap tunggu hingga pertanyaan tersebut dijawab terlebih dahulu.');
        }

        $question = Question::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_answered' => false,
            'views' => 0
        ]);

        return back()
            ->with('status', 'Pertanyaan berhasil dibuat');
    }

    public function show($id)
    {
        $question = Question::with(['categories', 'user', 'answers.user'])
            ->where('slug', $id)
            ->firstOrFail();
        
        $question->increment('views');
        
        return view('front.pages.detail', compact('question'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::all();
        
        return view('user.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:10',
            'content' => 'required|min:20',
            'categories' => 'required|array'
        ], [
            'title.required' => 'Judul harus diisi',
            'title.min' => 'Judul minimal 10 karakter',
            'content.required' => 'Pertanyaan harus diisi',
            'content.min' => 'Pertanyaan minimal 20 karakter',
            'categories.required' => 'Kategori harus dipilih'
        ]);

        $question = Question::findOrFail($id);
        
        $question->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content
        ]);

        $question->categories()->sync($request->categories);

        return redirect()->route('user.questions.show', $question->id)
            ->with('status', 'Pertanyaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('user.questions.index')
            ->with('status', 'Pertanyaan berhasil dihapus');
    }
}