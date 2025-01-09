<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDomain implements Rule
{
    public function passes($attribute, $value)
    {
        $domain = substr(strrchr($value, "@"), 1);
        return checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
    }

    public function message()
    {
        return 'The :attribute must have a valid domain.';
    }
}
