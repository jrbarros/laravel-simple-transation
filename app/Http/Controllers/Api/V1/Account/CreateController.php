<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\DTO\AccountData;
use App\Service\AccountService;
use Illuminate\Http\JsonResponse;

class CreateController extends Controller
{
    /**
     * @param AccountService $accountService
     */
    public function __construct(
        private readonly AccountService $accountService,
    ) { }

    /**
     * @param AccountRequest $request
     * @return JsonResponse
     */
    public function __invoke(AccountRequest $request)
    {
        $data['account_id'] = $request->validated()['conta_id'];
        $data['balance'] = $request->get('valor');

        $accountData = AccountData::createFromArray($data);

        $account = $this->accountService->create($accountData);

        return response()->json(new AccountResource($account), 201);
    }
}
