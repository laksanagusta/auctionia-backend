<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use DB;

class bidController extends Controller
{
    //
    public function store(Request $request)
    {
        $bid = new Bid;
        $bid->storeBid($request->users_id, $request->items_id, $request->bid_amount);
        return $bid;
    }

    public function index(Request $request)
    {
        $bid = new Bid;
        $result = $bid->indexBid($request->users_id);
        return $result;
    }

    public function indexIn(Request $request)
    {
        $bid = DB::TABLE('bids')
        ->join('items', 'items.id', '=', 'bids.items_id')
        ->join('users', 'users.id', '=', 'bids.users_id')
        ->where('items.users_id', '=', $request->user_id)
        ->select(['bids.id', 'users.name AS username', 'bids.bid_amount', 'items.name', 'bids.created_at'])
        ->get();

        return $bid;
    }

    public function indexOut(Request $request)
    {
        $bid = DB::TABLE('bids')
        ->join('items', 'items.id', '=', 'bids.items_id')
        ->join('users', 'users.id', '=', 'bids.users_id')
        ->where('bids.users_id', '=', $request->user_id)
        ->get();
        
        return $bid;
    }

    public function indexBidPerItem($itemId)
    {
        $bid = new Bid;
        $result = $bid->bidPerItem($itemId);
        return $result;
    }
}
