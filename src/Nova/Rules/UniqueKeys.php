<?php

namespace Armincms\NovaTranslation\Nova\Rules;

use Armincms\NovaTranslation\Translation;
use Illuminate\Contracts\Validation\Rule;

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
