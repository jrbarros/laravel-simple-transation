<?php

namespace App\Models\DTO;

use App\Enum\TransactionType;

final class TransactionData
{
    public function __construct(
        public TransactionType $type,
        public string $account,
        public float $value,
    ) {}

    public static function createFromArray(array $data): self
    {
        return new self(
            TransactionType::from($data['forma_pagamento']),
            $data['conta_id'],
            $data['valor'],
        );
    }
}
