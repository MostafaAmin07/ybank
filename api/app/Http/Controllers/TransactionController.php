<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, $id) {
        $transactions = Transaction::where('from', '=', $id)->orWhere('to', '=', $id)->get();
        return TransactionResource::collection($transactions);
    }

    public function store(TransactionStoreRequest $request, $id) {
        $validated = $request->validated();
        $transaction = Transaction::create($validated);
        return new TransactionResource($transaction);
    }
}
