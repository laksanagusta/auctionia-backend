<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'price',
        'category_id',
        'users_id',
        'desc'
    ];

    public function itemsEtalase($users_id)
    {
        $select = DB::TABLE('items')
        ->where('users_id', '=', $users_id)
        ->select('items.id', 'items.name', 'items.price', 'items.picture')
        ->get();

        return $select;
    }

    public function bid()
    {
        return $this->hasMany(Bid::class,'id','items_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
