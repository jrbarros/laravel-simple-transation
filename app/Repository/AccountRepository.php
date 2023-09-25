<?php

namespace App\Repository;

use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Cache\Repository;


class AccountRepository implements AccountRepositoryInterface
{
    public function __construct(
        private Account $account,
        private Repository $cache
    ) {}

    public function getCacheKey($id): string
    {
        return 'account_' . $id;
    }

    public function getAccountCacheKey($id): string
    {
        return 'account_number_' . $id;
    }

    /**
     * @param $accountId
     * @return Account|null
     */
    public function findByAccountId($accountId)
    {
        $cacheKey = $this->getAccountCacheKey($accountId);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        return $this->account->newQuery()->where('account_id', $accountId)->first();
    }

    /**
     * @param $id
     * @return Account|null
     */
    public function find($id) : ?Account
    {
        $cacheKey = $this->getCacheKey($id);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        return $this->account->newQuery()->find($id);
    }

    /**
     * @param array $attributes
     * @return Account
     */
    public function create(array $attributes): Account
    {
        $account = $this->account
            ->newQuery()
            ->create($attributes);
        $cacheKey = $this->getCacheKey($account->account_id);

        $this->cache->remember($cacheKey, 60 * 60 * 24, fn() => $account);

        return $account;
    }

    /**
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function update($id , array $attributes): bool
    {
        $account =  $this->account->newQuery()->find($id);
        if ($account === null) {
           return false;
        }

        $account->update($attributes);
        $cacheKey = $this->getCacheKey($account->account_id);

        $this->cache->remember($cacheKey, 60 * 60 * 24, fn() => $account);

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $account =  $this->account->newQuery()->find($id);
        if ($account === null) {
            return false;
        }

        $account->delete();
        $cacheKey = $this->getCacheKey($id);

        $this->cache->forget($cacheKey);

        return true;
    }
}
