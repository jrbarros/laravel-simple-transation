<?php

namespace App\Repository;

use App\Models\Transaction;
use Illuminate\Cache\Repository;

class TransactionRepository
{
    /**
     * @param Transaction $transaction
     * @param Repository $cache
     */
    public function __construct(
        private Transaction $transaction,
        private Repository  $cache
    ) {}

    public function getCacheKey($id): string
    {
        return 'transaction_' . $id;
    }

    public function getAccountCacheKey($id): string
    {
        return 'account_number_' . $id;
    }



    /**
     * @param $id
     * @return Transaction|null
     */
    public function find($id) : ?Transaction
    {
        $cacheKey = $this->getCacheKey($id);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        return $this->transaction->newQuery()->find($id);
    }

    /**
     * @param array $attributes
     * @return Transaction
     */
    public function create(array $attributes): Transaction
    {
        $transaction = $this->transaction
            ->newQuery()
            ->create($attributes);
        $cacheKey = $this->getCacheKey($transaction->id);

        $this->cache->remember($cacheKey, 60 * 60 * 24, fn() => $transaction);

        return $transaction;
    }

    /**
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function update($id , array $attributes): bool
    {
        $account =  $this->transaction->newQuery()->find($id);
        if ($account === null) {
            return false;
        }

        $account = $account->update($attributes);
        $cacheKey = $this->getCacheKey($account->id);

        $this->cache->remember($cacheKey, 60 * 60 * 24, fn() => $account);

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $account =  $this->transaction->newQuery()->find($id);
        if ($account === null) {
            return false;
        }

        $account->delete();
        $cacheKey = $this->getCacheKey($id);

        $this->cache->forget($cacheKey);

        return true;
    }
}
