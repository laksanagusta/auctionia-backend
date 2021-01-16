<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;

class favouritesController extends Controller
{
    //

    public function store(Request $request){
        $favourite = new Favourite;
        $favourite->storeFav($request->users_id, $request->items_id);
        return $favourite;
    }
}
