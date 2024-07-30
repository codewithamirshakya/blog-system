## Setup 

To set up the project, first of all we need to setup environment for laravel. 

- Refer to documentation of laravel https://laravel.com/docs/11.x

## Run project

To run project please follow these steps

- Clone repository [blog-system]
- Go to root application folder
- Run command ``composer install``
- Copy the .env.example to .env and change database according.
- Run command ``php artisan migrate:fresh --seed`` to setup db and seeder files
- Run command ``php artisan serve``
- To find the documentation of the goto ``{baseUrl}/docs``
- Currently, two users with role ``admin`` and `author` will be created

## User credentials
- `email: admin@blog.com`, `password: password` with role `admin`
- `email: author@blog.com`, `password: password` with role `author`

Above credentials can be used test functionality

## Documentation
- For api documentation, it available to http://localhost:8000/docs. If you are running on http://localhost:8000
- In the documentation you have a option to use postman or openai. 

## Project changes
In this project as a requirement it was told to use morphic relation of tags. But instead i have implemented a spatie package 

``composer require spatie/laravel-tags
  ``

The sole purpose of using this package is flexible and easy and attach on any model. 

Also, made of few changes on the acl policy part.
For this package use is ``composer require spatie/laravel-permission
`` 
Also, I have created permission set for all permission for ``admin`` and `author`.
For, that it can be referenced on 
``
[RoleSeeder.php]
[PermissionSeeder.php]
[RolePermissionSeeder.php]
``

Permission set is created on PermissionSeeder

# For monitoring
For monitoring and tracking the application 
Telescope package is installed 
- To enable/disable the telescope it can be done by adding `TELESCOPE_ENABLED=false|true`.







