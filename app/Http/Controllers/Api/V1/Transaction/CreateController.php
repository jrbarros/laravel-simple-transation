<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\AccountResource;
use App\Models\DTO\TransactionData;
use App\Service\TransactionService;
use Illuminate\Http\JsonResponse;

class CreateController extends Controller
{
    /**
     * @param TransactionService $transactionService
     */
    public function __construct(
        private TransactionService $transactionService
    ) { }


    /**
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function __invoke(TransactionRequest $request)
    {
        $data = $request->validated();

        $transactionData = TransactionData::createFromArray($data);

        try {
            $account = $this->transactionService->processTransaction($transactionData);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(new AccountResource($account));
    }
}
