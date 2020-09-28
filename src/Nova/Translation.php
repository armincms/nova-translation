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
    public static $model = \Armincms\NovaTranslation\Translation::class;

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
                ->sortable()
                ->creationRules(new Rules\UniqueKeys),

            Text::make(__('Translation Group'), 'group')
                ->readonly($request->isUpdateOrUpdateAttachedRequest())
                ->sortable(),

            Text::make(__('Translation Namespace'), 'namespace')
                ->readonly($request->isUpdateOrUpdateAttachedRequest())
                ->sortable(),

            new Panel(__('Translations'), function() {
                return collect(static::getLocales())->map(function($label, $locale) {
                    return Text::make($label, "text->{$locale}")
                                ->nullable(true, ['', null])
                                ->onlyOnForms($locale !== app()->getLocale())
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
     * Determine if the current user can delete the given resource or throw an exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToDelete(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can delete the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }
}
