<?php

namespace Tests\Feature;

use App\Account;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeTransactionTest extends TestCase
{
    use RefreshDatabase;
    private $from;
    private $to;
    private $amount;
    private $details;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddValidTransactionScenario()
    {
        $this->_resetTransactionValues();

        $this->seed();
        $response = $this->get('api/accounts/1');
        $response->assertOk();
        $sender = Account::find($this->from);
        $reciever = Account::find($this->to);
        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'to'=> $this->to,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $senderOriginalBalance = $sender->balance;
        $recieverOriginalBalance = $reciever->balance;
        $response->assertStatus(201);

        $sender = Account::find($this->from);
        $reciever = Account::find($this->to);
        $this->assertEquals($senderOriginalBalance - $this->amount, $sender->balance);
        $this->assertEquals($recieverOriginalBalance + $this->amount, $reciever->balance);
    }

    public function testAddInvalidTransactionFromScenario()
    {
        $this->_resetTransactionValues();
        $this->from = 2;
        $this->seed();

        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'to'=> $this->to,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    public function testAddInvalidTransactionMissingFromScenario()
    {
        $this->_resetTransactionValues();
        $this->seed();

        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'to'=> $this->to,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    public function testAddInvalidTransactionToScenario()
    {
        $this->_resetTransactionValues();
        $this->to = 5;
        $this->seed();

        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'to'=> $this->to,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    public function testAddInvalidTransactionMissingToScenario()
    {
        $this->_resetTransactionValues();
        $this->seed();

        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    public function testAddInvalidTransactionToSameAsFromScenario()
    {
        $this->seed();
        $this->_resetTransactionValues();
        $this->to = 1;
        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'to'=> $this->to,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    public function testAddInvalidTransactionMissingAmountScenario()
    {
        $this->seed();
        $this->_resetTransactionValues();
        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'to'=> $this->to,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    public function testAddInvalidTransactionAmountLargerThanBalanceScenario()
    {
        $this->seed();
        $this->_resetTransactionValues();
        $this->amount = 2000000;
        $response = $this->json('POST', 'api/accounts/1/transactions', [
            'from'=> $this->from,
            'to'=> $this->to,
            'amount'=>$this->amount,
            'details'=>$this->details
        ]);
        $response->assertStatus(422);
    }

    private function _resetTransactionValues() {
        $this->from = 1;
        $this->to = 2;
        $this->amount = 20;
        $this->details = 'bla bla';
    }
}
