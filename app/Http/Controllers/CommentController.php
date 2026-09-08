<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_process_id' => 'required|exists:task_processes,id',
            'text' => 'required|string'
        ]);

        $validated['user_id'] = Auth::id();

        Comment::create($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);
        
        if ($comment->user_id === Auth::id()) {
            $comment->delete();
        }
        
        return back();
    }
}
