<?php

namespace App;

use App\Transaction;

class TransactionBankTransfer extends Transaction
{
    public function __construct(array $attributes = array()){
        parent::__construct($attributes);
        $this->type = "bank_transfer";
    }
}
