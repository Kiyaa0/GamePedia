<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumReplyController extends Controller
{
    public function store(Request $request, ForumPost $forumPost): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $reply = $forumPost->replies()->create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('forum.show', $forumPost)
            ->with('success', 'Reply added!');
    }

    public function edit(ForumReply $forumReply): View
    {
        $this->authorize('update', $forumReply);

        return view('forum.replies.edit', compact('forumReply'));
    }

    public function update(Request $request, ForumReply $forumReply): RedirectResponse
    {
        $this->authorize('update', $forumReply);

        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $forumReply->update($validated);

        return redirect()->route('forum.show', $forumReply->forumPost)
            ->with('success', 'Reply updated!');
    }

    public function destroy(ForumReply $forumReply): RedirectResponse
    {
        $this->authorize('delete', $forumReply);

        $post = $forumReply->forumPost;

        $forumReply->delete();

        return redirect()->route('forum.show', $post)
            ->with('success', 'Reply deleted.');
    }
}
