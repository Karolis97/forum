<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        Comment::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
        ]);

        return to_route('posts.show', $post)
            ->banner('Comment added.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment): RedirectResponse
    {
        $comment->update($request->validated());

        return to_route('posts.show', ['post' => $comment->post_id, 'page' => $request->query('page')])
            ->banner('Comment updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment): RedirectResponse
    {
        $comment->delete();

        return to_route('posts.show', ['post' => $comment->post_id, 'page' => $request->query('page')])
            ->banner('Comment deleted.');
    }
}
