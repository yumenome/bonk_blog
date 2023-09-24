<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function create(Request $request){

        $request->validate(['content' => 'required']);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back();
    }

    public function delete($id){
        $cmt = Comment::find($id);
        if(Gate::allows('delete-cmt', $cmt)){
            $cmt->delete();
            return back()->with('info', 'delected a comment');
        }
            return back()->with('info', 'unauthorized to delete this cmt');
    }
}
