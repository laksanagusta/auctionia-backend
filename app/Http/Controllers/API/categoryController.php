<?php

namespace App\Http\Controllers\API;
use App\Models\Category;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class categoryController extends Controller
{
    //
    public function index()
    {
        return Category::All();
    }

}
