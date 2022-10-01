<?php

namespace Armincms\NovaTranslation\Nova\Actions;

use Illuminate\Support\Arr;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Spatie\TranslationLoader\LanguageLine;

class Export extends Action
{
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @return mixed
     */
    public function handle(ActionFields $fields)
    {
        $translations = collect();

        LanguageLine::chunk(10, function ($languageLines) use (&$translations) {
            $translations = $languageLines->map(function ($languageLine) {
                return Arr::except($languageLine->toArray(), 'id');
            })->merge($translations);
        });

        \Storage::disk('public')->put($filename = time().'.json', $translations->toJson(JSON_PRETTY_PRINT));

        return static::download(\Storage::disk('public')->url($filename), 'Translations.json');
    }
}
