<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'account',
        'amount',
        'type',
    ];
}
