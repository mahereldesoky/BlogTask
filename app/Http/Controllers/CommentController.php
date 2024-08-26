<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Notifications\CommentAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
   
        public function store(Request $request)
        {
            $request->validate([
                'content' => 'required|string',
                'post_id' => 'required|exists:posts,id',
            ]);
        
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->user_id = Auth::id();
            $comment->post_id = $request->post_id;
            $comment->save();
        
            // Notify the post author
            $post = $comment->post;
            Notification::send($post->user, new CommentAdded($comment));
        
            return redirect()->back()->with('success', 'Comment added successfully');
        }
    
        public function destroy(Comment $comment)
        {
            // Ensure the user is authorized to delete the comment
            if (Auth::id() !== $comment->user_id) {
                return redirect()->back()->with('error', 'Unauthorized action');
            }
    
            $comment->delete();
    
            return redirect()->back()->with('success', 'Comment deleted successfully');
        }
    }
    
