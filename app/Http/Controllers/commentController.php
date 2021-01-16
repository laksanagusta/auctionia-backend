<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\CommentCreated;

class commentController extends Controller
{
    //
    public function indexCommentPerItem(Request $request)
    {
        $comment = new Comment;
        $result = $comment->commentPerItem($request->items_id);
        return $result;
    }

    public function store(Request $request)
    {
        try {
            Comment::create([
                'items_id' => $request->items_id,
                'comment' => $request->comment,
                'users_id' => $request->users_id
            ]);
            $events = event(new CommentCreated('comment-post'));
            return ResponseFormatter::success([
            ],'Comment posted');
        } catch (exception $error) {
            return ResponseFormatter::error([
                'message' => $error
            ],'Error');
        }
    }
}
