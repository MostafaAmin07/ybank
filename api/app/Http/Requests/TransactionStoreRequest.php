<?php

namespace App\Http\Requests;

use App\Account;
use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != request()->id) {
                        $fail("That account {" . $value . "} is not yours!!");
                    }
                    $account = Account::find($value);
                    if ($account == null) {
                        $fail("That account {" . $value . "} doesn't exist. How did you get here!!");
                    }
                }
            ],
            'to' => [
                'required',
                function ($attribute, $value, $fail) {
                    $account = Account::find($value);
                    if($account == null) {
                        $fail("That account {" . $value . "} doesn't exist");
                    }
                    if ($value == request()->id) {
                        $fail("You can't transfer money to yourself.");
                    }
                }
            ],
            'amount' => [
                'required',
                function ($attribute, $value, $fail) {
                    $account = Account::findOrFail(request()->id);
                    if($value > $account->balance) {
                        $fail("You can't transfer money more that what you have.". $account->balance . " , " . $value);
                    }
                }
            ],
            'details' => ['nullable']
        ];
    }
}
