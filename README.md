

## Symfony Docker with Microservice
- Base on [Gary tuto](https://www.youtube.com/watch?v=pZv93AEJhS8&list=PLQH1-k79HB39Coin4J75MC4aLXR7WsORM&ab_channel=GaryClarke) project for promotion engine price.
- Reference redis [Yohan](https://www.youtube.com/watch?v=diwQMw9odvA&t=1500s)

### Redis for caching
- Use docker for redis
- redis-commander for UI : http://127.0.0.1:8081
- acces container redis, 
  + check connection: `redis-cli`
  + check session real time, number session open : redis-cli --stat  
- Install phpredis  (predis)
`composer require predis/predis`
- Check extension php-redis extension in php, modify Dockerfile & docker-compose.yml
- Make sur REDIS_URL in .env is: `REDIS_URL="redis://redis:6379"` because we connect php service container 
to redis container.


## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

* Production, development and CI ready
* [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
* Automatic HTTPS (in dev and in prod!)
* HTTP/2, HTTP/3 and [Preload](https://symfony.com/doc/current/web_link.html) support
* Built-in [Mercure](https://symfony.com/doc/current/mercure.html) hub
* [Vulcain](https://vulcain.rocks) support
* Native [XDebug](docs/xdebug.md) integration
* Just 2 services (PHP FPM and Caddy server)
* Super-readable configuration

**Enjoy!**

## Docs

1. [Build options](docs/build.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using a Makefile](docs/makefile.md)
8. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.fr), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
