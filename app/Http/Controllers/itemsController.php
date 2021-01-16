<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Helpers\ResponseFormatter;
use DB;

class itemsController extends Controller
{
    //
    public function index() {
        return Item::all();
    }

    public function getItems($category_id, $user_id) {
        $item = DB::SELECT("SELECT b.name, b.id, b.picture, b.price, b.desc, u.name as username, p.name as profession,    
                CASE WHEN f.id > 0 THEN true
                    ELSE false
            END as favourited 
        FROM items b 
        LEFT JOIN favourites f ON b.id = f.items_id AND f.users_id = '$user_id'
        LEFT JOIN users u on u.id = b.users_id
        LEFT JOIN professions p on p.id = u.professions_id WHERE b.category_id = '$category_id' AND b.users_id NOT IN('$user_id')");

        return ResponseFormatter::success([
            'item' => $item
        ],'Item Loaded');
    }

    public function getItemsEtalase($users_id) {
        $items = Item::with(['category'])->where('users_id', $users_id)->get();
        return ResponseFormatter::success([
            'item' => $items
        ],'Item Loaded');
    }

    public function addBarang(Request $request) {
        try 
        {
            Item::create([
                'name' => $request->name,
                'price' => $request->price,
                'desc' => $request->desc,
                'category_id' => $request->category_id,
                'users_id' => $request->users_id
            ]);
            $items = Item::where('name', $request->name)->first();
            return ResponseFormatter::success([
                'item' => $items
            ],'Item Loaded');    
            return $item;
        } catch (Exception $error) {
            //throw $th;
            return ResponseFormatter::error([
                'message' => 'error'
            ],'Error', 500);
        }
    }

    public function updateItem(Request $request, $id){
        try 
        {
            $item = Item::find($id);

            $item->name = $request->name;
            $item->price = $request->price;
            // $item->unit = $request->unit;
            $item->category_id = $request->category_id;
            $item->desc = $request->desc;
    
            $item->save();

            return ResponseFormatter::success([
                'message' => 'Success update item'
            ],'Item Updated'); 

        } catch (Exception $error) {
            //throw $th;
            return ResponseFormatter::error([
                'message' => $error
            ],'Error', 500);            
        }
    }
}
