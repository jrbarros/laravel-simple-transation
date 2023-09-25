<?php

namespace Feature\Api\V1\Account;

use App\Models\Account;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_account()
    {
        $account = Account::factory()->create();
        $this
            ->get('api/v1/conta' . '?id=' . $account->account_id)
            ->assertSuccessful()
            ->assertJsonStructure(
                [
                    'conta_id',
                    'saldo',
                ]
            );
    }

    public function test_get_account_return_404()
    {
        $this
            ->get('api/v1/conta' . '?id=' . rand(1000000, 9999999))
            ->assertStatus(404);
    }
}
