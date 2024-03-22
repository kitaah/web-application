<?php

// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\{Http\RedirectResponse, Http\Request};

class CommentController extends Controller
{
    /**
     * Post a comment.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'resource_id' => 'required|exists:resources,id'
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->resource_id = $request->input('resource_id');
        $comment->content = htmlspecialchars(trim($request->input('content')), ENT_COMPAT);
        $comment->save();

        auth()->user()->incrementPoints();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }
}


