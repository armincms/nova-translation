<?php

namespace Armincms\NovaTranslation\Nova;

use Illuminate\Http\Request; 
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\{ID, Text}; 

class Translation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Spatie\TranslationLoader\LanguageLine::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'key';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [ 
        'key', 'text'
    ]; 

    /**
     * The available locales.
     *
     * @var array
     */
    public static $locales = []; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [ 
            Text::make(__('Translation Key'), 'key')
                ->readonly($request->isUpdateOrUpdateAttachedRequest())
                ->sortable(),

            Text::make(__('Translation Group'), 'group')
                ->readonly($request->isUpdateOrUpdateAttachedRequest())
                ->onlyOnForms()
                ->sortable()
                ->nullable()
                ->fillUsing(function($request, $model, $attribute) {
                    $model->group = $request->get($attribute) ?? '*';
                }), 

            new Panel(__('Translations'), function() {
                return static::sortedLocales()->map(function($label, $locale) {
                    return Text::make($label, "text->{$locale}")
                                ->nullable(true, ['', null]) 
                                ->hideFromIndex($locale !== app()->getLocale())
                                ->updateRules(new Rules\Replacements(request('key') ?? $this->key));
                });
            }),
        ];
    }

    /**
     * Set the available locales.
     * 
     * @param array $locales
     * @return  static
     */
    public static function setLocales(array $locales)
    {
        static::$locales = array_merge(static::getLocales(), $locales);
    }

    /**
     * Get the avaialabe locales.
     * 
     * @return array
     */
    public static function getLocales() : array
    {
        return static::$locales ?? [
            'fa' => __('Persian'),
            'en' => __('English'),
        ];
    } 

    /**
     * Get the sorted locales.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function sortedLocales()
    {
        return collect(static::getLocales())->sortBy(function($label, $locale) {
            if($locale == config('database-localization.locale', 'en')) {
                return 0;
            }

            if($locale == app()->getLocale()) {
                return 1;
            }

            return time();
        });
    }

    /**
     * Get the actions available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Actions\Export,

            new Actions\Import,
        ];
    }
}
