<?php

namespace App\Models\DTO;

readonly final class AccountData
{
    public function __construct(
        public string $account_id,
        public ?float $balance
    ) {}

    public static function createFromArray(array $data): self
    {
        return new self(
            $data['account_id'],
            $data['balance']
        );
    }

    public function toArray(): array
    {
        return [
            'account_id' => $this->account_id,
            'balance' => $this->balance
        ];
    }
}
