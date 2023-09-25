<?php

namespace Feature\Api\V1\Transaction;

use App\Enum\TransactionType;
use App\Models\Account;
use App\Models\DTO\TransactionData;
use App\Service\TransactionService;
use Database\Factories\AccountFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_transaction_debit()
    {
        $account = AccountFactory::new()->create(); // Balance default 500 see AccountFactory::definition
        $transactionType =  TransactionType::from('d');
        $valor = 20;

        $data = [
            'forma_pagamento' => $transactionType->value,
            'conta_id' => $account->account_id,
            'valor' => $valor,
        ];

        $transactionData = TransactionData::createFromArray($data);

        /** @var TransactionService $transactionService */
        $transactionService = app(TransactionService::class);

        $saldo = Account::DEFAULT_BALANCE - $transactionService->getValueIncrementedTax($transactionData);

        $this->json('post','api/v1/transacao', $data)
            ->assertSuccessful()
            ->assertJson(
                [
                    'conta_id' => $account->account_id,
                    'saldo' => $saldo,
                ]
            );
    }

    public function test_create_transaction_credit()
    {
        $account = AccountFactory::new()->create(); // Balance default 500 see AccountFactory::definition
        $transactionType =  TransactionType::from('c');
        $valor = 100;

        $data = [
            'forma_pagamento' => $transactionType->value,
            'conta_id' => $account->account_id,
            'valor' => $valor,
        ];

        $transactionData = TransactionData::createFromArray($data);

        /** @var TransactionService $transactionService */
        $transactionService = app(TransactionService::class);

        $saldo = Account::DEFAULT_BALANCE - $transactionService->getValueIncrementedTax($transactionData);

        $this->json('post','api/v1/transacao', $data)
            ->assertSuccessful()
            ->assertJson(
                [
                    'conta_id' => $account->account_id,
                    'saldo' => $saldo,
                ]
            );
    }

    public function test_create_transaction_pix()
    {
        $account = AccountFactory::new()->create(); // Balance default 500 see AccountFactory::definition
        $transactionType =  TransactionType::from('p');
        $valor = 75;

        $data = [
            'forma_pagamento' => $transactionType->value,
            'conta_id' => $account->account_id,
            'valor' => $valor,
        ];

        $transactionData = TransactionData::createFromArray($data);

        /** @var TransactionService $transactionService */
        $transactionService = app(TransactionService::class);

        $saldo = Account::DEFAULT_BALANCE - $transactionService->getValueIncrementedTax($transactionData);

        $this->json('post','api/v1/transacao', $data)
            ->assertSuccessful()
            ->assertJson(
                [
                    'conta_id' => $account->account_id,
                    'saldo' => $saldo,
                ]
            );
    }

    public function test_create_transaction_balance_is_low_then_transaction()
    {
        $account = AccountFactory::new()->create(); // Balance default 500 see AccountFactory::definition
        $transactionType =  TransactionType::from('p');
        $valor = 510;

        $data = [
            'forma_pagamento' => $transactionType->value,
            'conta_id' => $account->account_id,
            'valor' => $valor,
        ];

        $this->json('post','api/v1/transacao', $data)
            ->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'Conta não possui saldo suficiente',
                ]
            );
    }
}
