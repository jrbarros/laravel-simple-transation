<?php

namespace App\Service;

use App\Models\Account;
use App\Models\DTO\AccountData;
use App\Repository\AccountRepository;

readonly class AccountService
{
    public function __construct(
        private AccountRepository $accountRepository
    ) {}

    /**
     * @param AccountData $accountData
     * @return Account
     */
    public function create(AccountData $accountData): Account
    {
        /**
         * Se o valor não for informado, o valor padrão é 500
         */
        if (empty($accountData->balance)) {
            $accountData = new AccountData(
                $accountData->account_id,
                Account::DEFAULT_BALANCE
            );
        }

        return $this->accountRepository->create($accountData->toArray());
    }
}
