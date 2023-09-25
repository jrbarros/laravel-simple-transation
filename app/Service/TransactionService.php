<?php

namespace App\Service;

use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Contracts\TransactionServiceInterface;
use App\Exceptions\AccountDoesNotHaveSufficientBalance;
use App\Exceptions\AccountNotExist;
use App\Models\Account;
use App\Models\DTO\TransactionData;
use App\Repository\TransactionRepository;

class TransactionService implements TransactionServiceInterface
{

    /**
     * @param AccountRepositoryInterface $accountRepository
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly TransactionRepository $transactionRepository
    ) {}


    /**
     * @param TransactionData $transactionData
     * @return Account
     * @throws AccountNotExist|AccountDoesNotHaveSufficientBalance
     */
    public function processTransaction(TransactionData $transactionData): Account
    {
        /** @var Account $account */
        $account = $this->accountRepository->findByAccountId($transactionData->account);
        $value   = $this->getValueIncrementedTax($transactionData);

        if ($account === null) {
            throw new AccountNotExist('Conta não encontrada');
        }

        if ($account->balance < $value) {
           throw new AccountDoesNotHaveSufficientBalance('Conta não possui saldo suficiente');
        }

        $this->doProcessTransaction($account, $transactionData, $value);

        return $account->refresh();
    }


    /**
     * @param TransactionData $data
     * @return float|int
     */
    public function getValueIncrementedTax(TransactionData $data): float|int
    {
        $value = $data->value;
        $tax = $data->type->getTax();

        if ($tax === 0) {
            return $value;
        }

        return $value * (1 + ($tax / 100));
    }

    /**
     * @param Account $account
     * @param TransactionData $transactionData
     * @param float|int $value
     * @return void
     */
    private function doProcessTransaction(Account $account, TransactionData $transactionData, float|int $value): void
    {
        $data = [
            'account' => $account->id,
            'amount' => $value,
            'type' => $transactionData->type->value,
        ];

        $this->transactionRepository->create($data);

        $balance = $account->balance - $value;

        $this->accountRepository->update($account->id, ['balance' => $balance]);
    }
}
