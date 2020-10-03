<?php

namespace App\Observers;

use App\Account;
use App\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        /**
         * CHECK maybe this could be moved to a dedicated service
         * to handle all account transactions related logic
        */
        $sender = Account::findOrFail($transaction->from);
        $reciever = Account::findOrFail($transaction->to);
        $sender->balance -= $transaction->amount;
        $reciever->balance += $transaction->amount;
        $sender->save();
        $reciever->save();
    }
}
