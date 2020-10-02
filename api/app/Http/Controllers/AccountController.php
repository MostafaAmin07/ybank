<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show(Request $request, $id) {
        $account = Account::findOrFail($id);
        return new AccountResource($account);
    }
}
