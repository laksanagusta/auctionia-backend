<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Favourite extends Model
{
    use HasFactory;

    public function storeFav($users_id, $items_id)
    {
        $favourite = new Favourite;
        $select = DB::SELECT("SELECT * FROM favourites WHERE users_id = '$users_id' AND items_id = '$items_id'");
        if(count($select) > 0)
        {
            $favourites = $favourite->WHERE('users_id', '=', $users_id)
            ->WHERE('items_id', '=', $items_id);
            $favourites->delete();
        }
        else
        {
            $favourite->users_id = $users_id;
            $favourite->items_id = $items_id;
            $favourite->desc = 'completed';
            $favourite->save();
        }
        return $favourite;
    }

    public function item()
    {
        return $this->hasOne(Item::class,'id','item_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','users_id');
    }
}
