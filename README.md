This project is a TODO application that helps you organize your tasks:

1) Requirements:
    -Docker installed: In docker->settings->General->Use the WSL2 base Engine for windows
                                            ->Resources->WSL Integration->your Ubuntu
    -Ubuntu terminal or subsystem
    -Composer installed
    -Symfony installed
    -PHP 8


2) Set Up:
   1) Clone the project: git clone ;P
   2) Create containers with: docker-compose up -d
   3) In .env you should have all variables installed
   4) Create a database: docker-compose exec php-fpm bin/console doctrine:database:create
   5) Create the tables: docker-compose exec php-fpm symfony console doctrine:migrations:migrate
   6) Load fixtures: docker-compose exec php-fpm symfony console doctrine:fixtures:load
   7) Open a browser write: localhost
   8) To be able to connect to the application go to Log In if you have an account if not create another one at Sign up
   9) Open localhost:1080 to see if you received an email and confirm you email
   10) Connect to the application, and you can Add/Edit and Delete your TODO items.
   11) If a TODO item is marked as DONE then that items can't receive any changes or to be deleted.

3) Test for testing:
   1) In .env.test you should have your variables defined
   2) Change in .env the APP_ENV=dev to APP_ENV=test
   3) Now create a new database that will have the name assignment_test: docker-compose exec php-fpm bin/console doctrine:database:create
   4) Create schema: docker-compose exec php-fpm symfony console --env=test doctrine:schema:create
   5) Load fixtures: docker-compose exec php-fpm symfony console doctrine:fixtures:load
   6) Open a browser write: localhost and check if the app works
   7) Now in the console do the testing with: docker-compose exec php-fpm  ./vendor/bin/phpunit

That should cover all the item and Good luck, and I hope this app will help you.




    
