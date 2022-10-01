<?php

namespace Armincms\NovaTranslation\Nova\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Replacements implements Rule
{
    public function __construct(string $key = null)
    {
        $this->key = $key;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        preg_match_all('/^\:[^\s\:]+/', $this->key, $matches);

        if (empty($value) || empty($matches[0])) {
            return true;
        }

        return collect($matches)->pluck(0)->filter(function ($matched) use ($value) {
            return ! Str::contains($value, $matched);
        })->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Position of the `:parameters` not determined.');
    }
}
