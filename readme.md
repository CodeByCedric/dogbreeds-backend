# Readme

## Back-end

The following instructions allow you to get the project up and running using Laravel Sail

### (1. Install [Docker](https://www.docker.com/products/docker-desktop/))

For Windows users,ensure that Windows Subsystem for Linux 2 (WSL2)
is [installed and enabled](https://learn.microsoft.com/en-us/windows/wsl/install).

### 2. Install Laravel Sail into application

#### 2a. Composer is <u>not</u> installed:

Install [composer](https://getcomposer.org/)

#### 2b. Composer is installed:

Open a terminal, navigate to the root of the project, and run:

```
composer require laravel/sail --dev
```

```
php artisan sail:install
```

```
./vendor/bin/sail up
```

The full guide can be found [here](https://laravel.com/docs/10.x/sail#installing-sail-into-existing-applications)

### 3. Run migrations and seeders

```./vendor/bin/sail artisan migrate:fresh --seed```
