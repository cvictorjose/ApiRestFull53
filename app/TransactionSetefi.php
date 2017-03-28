<?php

namespace App;

use App\Transaction;

class TransactionSetefi extends Transaction
{
    public function __construct(array $attributes = array()){
        parent::__construct($attributes);
        $this->type = "setefi";
    }
}
