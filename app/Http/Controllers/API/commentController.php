<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\CommentCreated;
use App\Helpers\ResponseFormatter;
use DB;

class commentController extends Controller
{
    //
    public function indexCommentPerItem($id)
    {
        $comment = DB::table('comments')
        ->leftJoin('users', 'users.id', '=', 'comments.users_id')
        ->leftJoin('items', 'items.id', '=', 'comments.items_id')
        ->where('items.id', '=', $id)
        ->orderBy('comments.created_at', 'ASC')
        ->select('comments.comment', 'users.name', 'comments.id', 'users.profile_photo_path')
        ->get();

        return ResponseFormatter::success([
            'comment' => $comment
        ],'Comment retrieved');
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
