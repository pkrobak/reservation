# This is a recruitment project

### Setup:

1. `cp docker/.env.example docker.env`
2. `cp laravel/.env.example laravel/.env`
3. `cd docker`
4. `docker-compose up` if you want use `-d` flag to do it in a background

### Tests:
1. `docker exec -it docker_php_1 bash`
2. `php artisan test`

Tests generally does not run on separate DB, but it was done just for code skill presentation.

If you have any problems please fell free to contact me: `pkrobak@gmail.com`
