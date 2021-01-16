<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Bid extends Model
{
    use HasFactory;
    public function storeBid($users_id, $items_id, $bid_amount)
    {
        $bid = new Bid;
        $bid->users_id = $users_id;
        $bid->items_id = $items_id;
        $bid->bid_amount = $bid_amount;
        $bid->desc= 'Proccess';
        $bid->save();
        return $bid;
    }

    public function indexBid($users_id)
    {
        $bid = DB::SELECT("SELECT i.name, i.price, b.bid_amount, u.picture, u.name as user_name, b.created_at
                    FROM bids b INNER JOIN users u ON u.id = b.users_id 
                    LEFT JOIN items i ON i.id = b.items_id
                    WHERE u.id = '$users_id'");
        return $bid;
    }

    public function bidPerItem($items_id)
    {
        $bid = DB::SELECT("SELECT b.id, u.name as username, i.name, b.bid_amount, b.desc
                    FROM users u 
                    RIGHT JOIN bids b ON b.users_id = u.id
                    LEFT JOIN items i ON i.id = b.items_id 
                    WHERE i.id = '$items_id'");

        $highest_bid = DB::SELECT("SELECT bid_amount FROM bids WHERE items_id = '$items_id' ORDER BY bid_amount DESC LIMIT 1");
        $response['bid'] = $bid;
        $response['highest_bid'] = $highest_bid;

        return response()->json($response);
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','users_id');
    }

    public function item()
    {
        return $this->hasOne(Item::class,'id','items_id');
    }
}
