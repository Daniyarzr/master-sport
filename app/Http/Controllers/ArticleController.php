<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('user')->orderByDesc('created_at')->get();

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        $article->load('user');

        return view('articles.show', compact('article'));
    }

    public function create(): View
    {
        return view('articles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'in:хайкинг,велопутешествия,бег,путешествия,спорт'],
        ]);

        Article::query()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'user_id' => $request->user()->id,
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index')->with('status', 'Статья опубликована.');
    }

    public function destroy(Request $request, Article $article): RedirectResponse
    {
        if ($article->user_id !== $request->user()->id) {
            abort(403);
        }

        $article->delete();

        return back()->with('status', 'Статья удалена.');
    }
}
