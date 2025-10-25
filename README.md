## Development
- `docker compose up -d` - Zapnutie web servera a php containera
- `docker compose exec php bash` - Command line v php containery
  - Update composer dependencies: `composer update`
  - Run artisan commands: `php artisan [command]`
  - **Overenie rules pre štýl kódu:** `composer pint` **(V pipeline)**
  - **Statická analýza kódu:** `composer stan` **(V pipeline)**
  - Pustenie všetkých testov: `composer tests` **(V pipeline)**
- App url: http://localhost

## For time setup
- `git clone https://github.com/refactorian/laravel-docker.git`
- `cd laravel-docker`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `composer setup`


# Useful commands

### Basic docker compose commands
- Create and start containers
    - `docker compose up -d`
- Stop and remove containers, networks
    - `docker compose down`
- Stop all services
    - `docker compose stop`
- Restart service containers
    - `docker compose restart`
- Run a command inside a container
    - `docker compose exec [container] [command]`

### Useful Laravel Commands
- Display basic information about your application
    - `php artisan about`
- Remove the configuration cache file
    - `php artisan config:clear`
- Flush the application cache
    - `php artisan cache:clear`
- Clear all cached events and listeners
    - `php artisan event:clear`
- Delete all of the jobs from the specified queue
    - `php artisan queue:clear`
- Remove the route cache file
    - `php artisan route:clear`
- Clear all compiled view files
    - `php artisan view:clear`
- Remove the compiled class file
    - `php artisan clear-compiled`
- Remove the cached bootstrap files
    - `php artisan optimize:clear`
- Delete the cached mutex files created by scheduler
    - `php artisan schedule:clear-cache`
- Flush expired password reset tokens
    - `php artisan auth:clear-resets`
