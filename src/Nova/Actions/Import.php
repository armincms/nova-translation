<?php

namespace Armincms\NovaTranslation\Nova\Actions;

use Illuminate\Support\Arr;
use Laravel\Nova\Fields\{ActionFields, File, Boolean};
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Spatie\TranslationLoader\LanguageLine;

class Import extends DetachedAction
{ 
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields 
     * @return mixed
     */
    public function handle(ActionFields $fields)
    {
        $translations = json_decode(request()->file('translations')->get(), true);

        if(boolval($fields->get('override')) === true) {
            $this->cleanOverridedTranslations($translations);
        }

        LanguageLine::insert(collect($translations)->map(function($translation) {
            return array_merge($translation, [
                'text' => json_encode($translation['text'])
            ]);
        })->all());

        \Artisan::call('cache:clear'); 

        return static::message(__('Please reload the page to see new translations.')); 
    }

    public function cleanOverridedTranslations($translations)
    {
        $query = (new LanguageLine)->getQuery();

        foreach ($translations as $translation) {
            $query->orWhere(function($query) use ($translation) {
                $query->where('group', $translation['group'])
                      ->where('key', $translation['key']);
            });
        }

        $query->delete(); 
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('Translations', 'translations')
                ->acceptedTypes('application/json')
                ->required()
                ->rules('required', 'mimes:json'),

            Boolean::make(__('Override'), 'override', function() {
                return false;
            }),
        ];
    }
}
