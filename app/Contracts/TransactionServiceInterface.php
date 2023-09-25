<?php

namespace App\Contracts;

use App\Models\DTO\TransactionData;

interface TransactionServiceInterface
{
    public function processTransaction(TransactionData $transactionData);
}
