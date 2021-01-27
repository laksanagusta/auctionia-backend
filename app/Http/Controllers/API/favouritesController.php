<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favourite;

class favouritesController extends Controller
{
    //

    public function store(Request $request){
        $favourite = Favourite::where('users_id', $request->users_id)
            ->where('items_id', $request->items_id)->get();
        if(count($favourite) > 0)
        {
            Favourite::where('users_id', $request->users_id)
            ->where('items_id', $request->items_id)->delete();
        }
        else
        {
            Favourite::create([
                'users_id' => $request->users_id,
                'items_id' => $request->items_id,
                'desc' => $request->desc
            ]);
        }
    }
}
