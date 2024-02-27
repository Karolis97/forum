<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Forum Application

## Description
This Laravel Forum application is a modern, full-featured forum web application built using Laravel, Vue.js 3, and Tailwind CSS. It follows Test-Driven Development (TDD) principles for robust and reliable code. The application features user authentication, thread creation, replies, and a sleek, responsive UI.

## Requirements
- Composer
- Docker Desktop (for Laravel Sail)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Karolis97/forum.git
```

2. Clone the repository:
```bash
cd forum
```

3. Install composer dependencies
```bash
composer install
```

4. Copy the .env.example file to .env and configure your application and database settings:
```bash
cp .env.example .env
```

5. Start the Docker environment with Laravel Sail (this command will install all necessary Docker containers):
```bash
./vendor/bin/sail up -d
```

6. Install NPM packages and run Vite.js for asset compilation:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

7. Generate an application key:
```bash
./vendor/bin/sail artisan key:generate
```

8. Run the database migrations and seeders to set up your database with initial data:
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

## Usage
To access the application, open your web browser and visit http://localhost. You should see the Laravel Forum application running. Register a new account or login to start participating in forum discussions.

#### Demo account:
###### user@example.com
###### password
