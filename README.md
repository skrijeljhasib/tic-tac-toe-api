# Tic Tac Toe API

## Requirements

In order to use this application, you have to install docker and docker-compose in your machine. Check [Docker](https://docs.docker.com/)

Software that will be installed in your docker containers:

- PHP 7.3.1 (Redis extension, ...)
- Composer >= 1.8.3
- Apache 2.4.25
- Redis 5.0
- Traefik

## Usage

- Add line `127.0.0.1 tic-tac-toe-api.local` in your `/etc/hosts` file.
- Run:
    - `docker-compose up -d`
    - `docker exec -it tic-tac-toe-api_api_1 composer install`
- Check [Traefik](http://127.0.0.1:8080/dashboard/) for more information about your docker containers).
- Install a REST client tool like [Postman](https://www.getpostman.com/) to make the API calls. Check the OpenAPI documentation below.
- Or go to [tic-tac-toe-api.local](http://tic-tac-toe-api.local) where you can find the frontend game which is using this API.
- Have fun!

## Tests

Run in your docker `vendor/bin/grumphp run`

## OpenAPI documentation

Check [SwaggerHub API Doc](https://app.swaggerhub.com/apis-docs/skrijeljhasib/tic-tac-toe-api/1.0)

## Contributors

- Skrijelj Hasib

