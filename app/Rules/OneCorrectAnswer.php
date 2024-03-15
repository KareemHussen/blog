<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OneCorrectAnswer implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $correctAnswers = 0;

        foreach ($value as $answer) {

            if (!isset($answer['isCorrect'])){
                $fail('The questions.answers.isCorrect field is required.');
                return;
            }

            if ($answer['isCorrect']) {
                $correctAnswers++;
            }

            if ($correctAnswers > 1) {
                $fail('Answers must have at most one correct answer.');
            }
        }

        if ($correctAnswers < 1) {
            $fail('Answers must have at least one correct answer.');
        }

    }
}
