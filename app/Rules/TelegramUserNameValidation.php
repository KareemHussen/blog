<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TelegramUserNameValidation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = "/^@\S+$/";

        if (! preg_match($pattern, $value)) {
            $fail("The Telegram Username must start with '@' and must not contain any spaces.");
        }
    }
}
