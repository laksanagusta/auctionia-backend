<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class transactionController extends Controller
{
    //
    public function index(Request $request)
    {
        $transaction = new Transaction;
        $transaction->indexTransaction($request->users_id);
        return $transaction;
    }
}
