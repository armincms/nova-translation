# Nova Translation
Nova implementation of the `armincms/database-localization` package


## Installation
step 1:
	install by composer : `composer require armincms/nova-translation`.

step 2:
	php artisan migrate to create `armincms/database-localization` table.

step 3: 
	Register `Armincms\NovaTranslation\Translation` resource.
	
	```
	Nova::resources([
		\Armincms\NovaTranslation\Translation
	])
	```