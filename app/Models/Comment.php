<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'users_id',
        'items_id',
        'comment'
    ];

    public function commentPerItem($items_id)
    {
        $comment = DB::table('comments')
        ->leftJoin('users', 'users.id', '=', 'comments.users_id')
        ->leftJoin('items', 'items.id', '=', 'comments.items_id')
        ->where('items.id', '=', $items_id)
        ->orderBy('comments.created_at', 'ASC')
        ->select('comments.comment', 'users.name', 'comments.id', 'users.picture')
        ->get();
        return $comment;
    }

    public function storeComment($items_id, $users_id, $comment)
    {
        $comments = new Comment;
        $comments->comment = $comment;
        $comments->users_id = $users_id;
        $comments->items_id = $items_id;
        $comments->save();
        return $comments;
    }

    public function item()
    {
        return $this->hasOne(Item::class,'id','item_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','users_id');
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)
            ->getPreciseTimestamp(3);
    }
    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)
            ->getPreciseTimestamp(3);
    }
}
