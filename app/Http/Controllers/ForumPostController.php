<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ForumPostController extends Controller
{
    public function index(Request $request): View
    {
        $query = ForumPost::with('user')->withCount('replies')->latest();

        if ($request->filled('game_id')) {
            $query->where('rawg_game_id', $request->input('game_id'));
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->input('search').'%')
                    ->orWhere('body', 'like', '%'.$request->input('search').'%');
            });
        }

        $posts = $query->paginate(15);

        return view('forum.index', compact('posts'));
    }

    public function create(Request $request): View
    {
        $game = null;
        if ($request->filled('game_id')) {
            $response = Http::get(config('services.rawg.base_url').'/games/'.$request->input('game_id'), [
                'key' => config('services.rawg.key'),
            ]);
            $game = $response->successful() ? $response->json() : null;
        }

        return view('forum.create', compact('game'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rawg_game_id' => ['required', 'string'],
            'game_title' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post = ForumPost::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('forum.show', $post)
            ->with('success', 'Forum post created!');
    }

    public function show(ForumPost $forumPost): View
    {
        $forumPost->load(['user', 'replies.user']);

        return view('forum.show', compact('forumPost'));
    }

    public function edit(ForumPost $forumPost): View
    {
        $this->authorize('update', $forumPost);

        return view('forum.edit', compact('forumPost'));
    }

    public function update(Request $request, ForumPost $forumPost): RedirectResponse
    {
        $this->authorize('update', $forumPost);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $forumPost->update($validated);

        return redirect()->route('forum.show', $forumPost)
            ->with('success', 'Forum post updated!');
    }

    public function destroy(ForumPost $forumPost): RedirectResponse
    {
        $this->authorize('delete', $forumPost);

        $forumPost->delete();

        return redirect()->route('forum.index')->with('success', 'Forum post deleted.');
    }
}
