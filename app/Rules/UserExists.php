<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;


class UserExists implements ValidationRule
{


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        dd($attribute, $value, $fail);
    }
}
