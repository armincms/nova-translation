<?php

namespace Armincms\NovaTranslation;

use Illuminate\Database\Eloquent\Model;
use Armincms\DatabaseLocalization\{Store, Cacheable};

class Translation extends Model
{  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'text' => 'json',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function($model) {
            $store = app(Store::class); 

            if($store instanceof Cacheable) {
                foreach ($model->text as $locale => $value) {
                    $store->forget($locale, $model->group, $model->namespace);
                } 
            }
        });
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('database-localization.database', 'database_localization');
    }

    public function setGroupAttribute(string $group = null)
    {
        $this->attributes['group'] = $group ?? '*';
    }

    public function setNamespaceAttribute(string $namespace = null)
    {
        $this->attributes['namespace'] = $namespace ?? '*';
    }
}
