<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment; // this is the comment variable

    public function __construct(Comment $comment) // this is the constructor
    {
        $this->comment = $comment; // this is the comment variable
    }

    public function store(Request $request, $post_id) // this is the store method
    {
        $request->validate([
            'comment' => 'required|min:1|max:150'
        ]); // this is the validation for the body field

        $this->comment->user_id = Auth::user()->id; // this is the user id of the user
        $this->comment->post_id = $post_id; // this is the post id of the post
        $this->comment->body = $request->comment; // this is the comment of the comment
        $this->comment->save(); // this will save the comment

        return redirect()->back(); // this will redirect the user back to the previous page
    }

    public function destroy($id)
    {
        $this->comment->destroy($id); // this will destroy the comment
        return redirect()->back(); // this will redirect the user back to the previous page
    }
}
