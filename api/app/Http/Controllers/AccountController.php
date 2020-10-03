<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * GET Account Data.
     *
     * This endpoint allows you to retrieve the current account data
     *
     * @response status=404 scenario="Unknown account id"
     *
     * @response status=200 scenario="Known account id"
     * { "data": { "id": 1, "name": "john", "balance": 10000} }
     *
     */
    public function show(Request $request, $id) {
        $account = Account::findOrFail($id);
        return new AccountResource($account);
    }
}
