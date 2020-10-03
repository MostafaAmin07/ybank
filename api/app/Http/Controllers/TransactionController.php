<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * GET Transactions for an account.
     *
     * This endpoint allows you to retrieve the transactions related
     * to the current account data either this account is the sender or the reciever
     *
     * @response status=404 scenario="Unknown account id"
     *
     * @response status=200 scenario="Known account id"
     * { "data": [
     *      {
     *          "from": 1,
     *          "to": 2,
     *          "details": "sample transaction",
     *          "amount": 14
     *      },
     *      {
     *          "from": 1,
     *          "to": 2,
     *          "details": "sample transaction 2",
     *          "amount": 24
     *      },
     * ] }
     *
     */
    public function index(Request $request, $id) {
        $transactions = Transaction::where('from', '=', $id)->orWhere('to', '=', $id)->get();
        return TransactionResource::collection($transactions);
    }

    /**
     * POST a transaction from an account to an other.
     *
     * This endpoint allows you to store a transaction
     *
     * @bodyParam {
     *  "from": int,
     *  "to": int,
     *  "amount": float,
     *  "details": string
     *  }
     *
     * @response status=422 scenario="Invalid form data"
     *
     * @response status=201 scenario="Created transaction"
     * { "data": {
     *          "from": 1,
     *          "to": 2,
     *          "details": "sample transaction",
     *          "amount": 14
     *      }
     * }
     *
     */
    public function store(TransactionStoreRequest $request, $id) {
        $validated = $request->validated();
        $transaction = Transaction::create($validated);
        return new TransactionResource($transaction);
    }
}
