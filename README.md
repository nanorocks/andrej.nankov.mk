# Andrej Nankov Personal Website

This is a Laravel-based web application serving as the personal website and portfolio for Andrej Nankov. It showcases projects, blog posts, and provides a platform for sharing technical resources and notes.

## Features

- Modern Laravel 12+ stack with Livewire and Vite
- Responsive design using Tailwind CSS and DaisyUI
- Authentication and user dashboard
- Dynamic navigation and theme switching
- Integration with PostgreSQL and MySQL
- Dockerized development environment
- Example CRUD generator and code formatting tools

## Getting Started

### Prerequisites

- Docker & Docker Compose
- Node.js (LTS)
- Composer

### Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/andrej-nankov/personal-website.git
    cd personal-website
    ```

2. Copy `.env.example` to `.env` and configure your environment variables.

3. Build and start the Docker containers:
    ```bash
    docker-compose up --build
    ```

4. Install PHP dependencies:
    ```bash
    docker-compose exec app composer install
    ```

5. Install Node dependencies and build assets:
    ```bash
    docker-compose exec app npm install
    docker-compose exec app npm run build
    ```

6. Run migrations:
    ```bash
    docker-compose exec app php artisan migrate
    ```

### Usage

- Access the site at [http://localhost:8000](http://localhost:8000)
- Register or log in to access the dashboard
- Use the theme switcher in the navigation bar to change appearance

## Development

- Format code with Pint:
    ```bash
    ./vendor/bin/pint
    ```
- Generate CRUD resources:
    ```bash
    php artisan make:crud ResourceName
    ```

## References

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com/docs/quickstart)
- [DaisyUI](https://daisyui.com/)
- [CRUD Generator](https://github.com/awais-vteams/laravel-crud-generator)

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
