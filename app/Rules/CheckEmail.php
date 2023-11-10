<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class CheckEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if((auth()->user()->email != $value)) {
            $user = User::where("email", $value)->limit(1)->count();
            if($user >= 1) $fail("This email is not available");
        }        
    }
}
