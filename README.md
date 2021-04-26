## SugarCRM
#### Connect to SugarCRM API and fetch opportunities and show on openstreetmap.org map by Accounts
I try to create application by OOP, SOLID principles, 
please fist check index.php and then check the src\Services

Used libraries:
1. PHPUnit for testing purpose
2. Symfony/Dotenv to load configuration with zero overhead

### Build and run

``` 
    docker-compose build

    docker-compose up -d

    docker exec -it php8 composer install
``` 
After this PHP runs on http://0.0.0.0:8000 or 
http://localhost:8000

### Test

```  docker exec -it php8 ./vendor/bin/phpunit  ```
