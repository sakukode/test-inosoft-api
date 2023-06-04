# Test Backend Inosoft API

Test Backend Inosoft API is a Laravel-based application that provides Rest API for vehicle sales.

## Requirements

Before installing Project Name, make sure you have the following prerequisites:

- PHP 8.0
- Laravel 8
- MongoDB 4.2

## Installation

Follow these steps to install and set up Project Name:

1. Clone the repository:

   ```shell
   git clone https://github.com/sakukode/test-inosoft-api.git
   ```

2. Install the dependencies using Composer:

   ```shell
   composer install
   ```

3. If you prefer to use Laravel Sail for local development, build the Docker images:

   ```shell
   ./vendor/bin/sail build --no-cache
   ```

4. Start the application on your local machine:

   ```shell
   ./vendor/bin/sail up -d
   ```

5. Copy the `.env` file:

   ```shell
   cp .env.example .env
   ```

6. Generate an application key:

   ```shell
   php artisan key:generate
   ```

7. Run the database migrations and seed the database:

   ```shell
   php artisan migrate --seed
   ```

## Testing

To run the tests for Project Name, follow these steps:

1. Create a copy of the `.env.example` file and name it `.env.testing`. Update the configuration accordingly.

2. Run the tests using the Artisan command:

   ```shell
   php artisan test
   ```


## License

Project Name is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).