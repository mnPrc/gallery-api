<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ForbiddenWords implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $forbiddenWords = ['shit', 'retard', 'bitch', 'kill yourself', 'kys'];

        foreach($forbiddenWords as $word){
            if(stripos($value, $word) !== false){
                $fail('Your comment contains vulgar or hurtful words, please be thoughtful of others');
            }
        }
    }
}