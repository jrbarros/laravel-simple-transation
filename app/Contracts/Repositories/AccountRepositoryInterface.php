<?php

namespace App\Contracts\Repositories;

use App\Models\Account;

interface AccountRepositoryInterface
{

    public function getCacheKey($id);

    public function find($id) : ?Account;

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function findByAccountId($accountId);
}

