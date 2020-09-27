<?php

namespace Armincms\NovaTranslation;

use Illuminate\Database\Eloquent\Model; 

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
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('database-localization.database');
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
