<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string account_id
 * @property float balance
 */
class Account extends Model
{
    use HasFactory;

    public const DEFAULT_BALANCE = 500;

    protected $fillable = [
        'account_id',
        'balance',
    ];
}
