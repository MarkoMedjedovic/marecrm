### Route confirmation

````
php artisan route:list
````

### Controller creation

````
php artisan make:controller controller name
````

### model creation

Check option list php artisan make:model -h
Basically, options are created with -a
Model, Factory, Migration, Seeder, Request, Controller, Policy

````
php artisan make:model model name -a
````

### Migration

````
php artisan migrate
````

### Create storage link

Make images etc. placed in public accessible from outside

````
php artisan storage:link
````

### Run seeder when migrating

````
php artisan migrate:fresh --seed
````# marecrm
