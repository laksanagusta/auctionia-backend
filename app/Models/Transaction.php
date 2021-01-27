<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['desc', 'debit', 'credit'];
    
    public function item()
    {
        return $this->hasOne(Item::class,'id','item_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
