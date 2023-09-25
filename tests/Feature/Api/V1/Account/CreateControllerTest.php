<?php

namespace Feature\Api\V1\Account;

use App\Models\Account;
use Database\Factories\AccountFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_account_successful()
    {
        $data = [
            'conta_id' => '1234567',
            'valor' => 600
        ];

        $this
            ->json('post', 'api/v1/conta', $data)
            ->assertSuccessful()
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'conta_id',
                    'saldo',
                ]
            );
    }

    public function test_create_account_check_value_default()
    {
        $accountId = rand(1000000, 9999999);
        $data = ['conta_id' => $accountId];

        $this
            ->json('post', 'api/v1/conta', $data)
            ->assertStatus(201)
            ->assertJson(
                [
                    'conta_id' => $accountId,
                    'saldo' => Account::DEFAULT_BALANCE,
                ]
            );
    }

    public function test_create_account_validate_account_id_required()
    {
        $data = ['valor' => 600];

        $this
            ->json('post', 'api/v1/conta', $data)
            ->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'A conta é obrigatória',
                    'errors' => [
                       'conta_id' => [
                           'A conta é obrigatória'
                       ]
                   ]
                ]
            );
    }

    public function test_create_account_validate_account_id_is_unique()
    {
        $account =  (new AccountFactory)->create();
        $data = [
            'conta_id' => $account->account_id,
            'valor' => 600
        ];

        $this
            ->json('post', 'api/v1/conta', $data)
            ->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'A conta já existe',
                    'errors' => [
                        'conta_id' => [
                            'A conta já existe'
                        ]
                    ]
                ]
            );
    }

}
