# Nova Translation
Nova implementation of the `armincms/database-localization` package


## Installation
- step 1:

	install package by the `composer require armincms/nova-translation` command.

- step 2:

	Then run the `php artisan migrate` to create `armincms/database-localization` table.

- step 3: 

	Finally register the `Armincms\NovaTranslation\Translation` resource.
	
	```
	Nova::resources([
		\Armincms\NovaTranslation\Translation
	]) 
	```
