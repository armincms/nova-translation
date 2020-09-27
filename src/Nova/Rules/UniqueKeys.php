<?php

namespace Armincms\NovaTranslation\Nova\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Armincms\NovaTranslation\Translation;

class UniqueKeys implements Rule
{ 
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Translation::where([
            'key' => $value,
            'group' => request('group') ?? '*',
            'namespace' => request('namespace') ?? '*',
        ])->count() == 0; 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('This string has been translated.');
    }
}
