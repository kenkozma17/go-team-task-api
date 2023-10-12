## About GoTeam Task Management API

An API to provide Authentication, CRUD and sorting abilities built using Laravel 10, Event Broadcasting (Pusher) for real time updates and Laravel Sanctum for authentication. The UI can be found here: https://github.com/kenkozma17/go-team-task-app

## Setup

1. Clone repository to local or remote server (https://laravel.com/docs/10.x/deployment) where you can deploy/serve the application using Laravel Sail (https://laravel.com/docs/10.x/sail).
2. Install composer dependencies by executing the following command: `composer install`.
3. Copy the `.env.example` into a new `.env` file and add the following variables:

    Set PUSHER variables in `.env` that are provided in email instructions.

    ```
    BROADCAST_DRIVER=pusher
    PUSHER_APP_ID=xxx
    PUSHER_APP_KEY=xxx
    PUSHER_APP_SECRET=xxx
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=xxx
    ```

    Set Laravel Sanctum related `.env` variables provided values. If you are deploying on a remote server, make sure to add the appropriate scheme and domain name instead of localhost.

    ```
    APP_URL=http://localhost:8000
    FRONTEND_URL=http://localhost:8080
    SESSION_DOMAIN=localhost
    SANCTUM_STATEFUL_DOMAINS=localhost:8080
    ```

4. Setup database connection accordingly in `.env` file.
5. Run migrations and seed your database by executing the following command: `php artisan migrate:fresh --seed`. This should give create a user for you to login (provided in email) and 3 default status boards out of the box (Todo, In-Progress, Done).
6. Navigate to `/` route and look for JSON Object that displays the Laravel version.
