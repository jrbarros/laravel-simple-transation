<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository
    ) {}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $id = $request->get('id');

        $account = $this->accountRepository->findByAccountId($id);

        if ($account === null) {
            return response()->json(['message' => 'Conta não encontrada'], 404);
        }

        return response()->json(new AccountResource($account));
    }

}
