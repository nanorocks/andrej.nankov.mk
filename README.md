# Andrej Nankov's Portfolio

Welcome to my professional portfolio, showcasing my work, projects, and interests. Explore the live site at [https://andrej.nankov.mk/](https://andrej.nankov.mk/).

## Table of Contents
- [About Me](#about-me)
- [Projects](#projects)
- [Contact](#contact)
- [License](#license)
- [nankov.mk Applications](#nankovmk-applications)

## About Me

I am Andrej Nankov, a seasoned professional with a diverse skill set and a passion for innovation. Learn more about my background, skills, and experiences that shape my professional journey.

## Projects

Discover a curated selection of projects that highlight my expertise and creativity.

### Project Showcase

1. **Example Project 1**
   - *Description*: Brief overview of the project.
   - *Link*: [Project 1](#)

2. **Example Project 2**
   - *Description*: Brief overview of the project.
   - *Link*: [Project 2](#)

Your feedback is valuable. Feel free to explore and reach out!

## Contact

Connect with me to discuss opportunities, collaborations, or just to say hello.

- *Email*: [andrejnankov@gmail.com](mailto:andrejnankov@gmail.com)
- *LinkedIn*: [nanorocks](https://www.linkedin.com/in/nanorocks/)

## License

This portfolio is licensed under the [MIT License](LICENSE.md) - see the [LICENSE.md](LICENSE.md) file for details.

## nankov.mk Applications

### API (WordPress + Postman)

Explore the API documentation using the provided Postman file for seamless integration and testing.

- The entire API is now powered by WordPress, with an integrated admin panel for streamlined CRUD operations.
- Access the admin panel: [https://wpadmin.nankov.mk/](https://wpadmin.nankov.mk/)
- Reference: [WordPress REST API Documentation](https://developer.wordpress.org/rest-api/)

Clear the cache by navigating to `domain_name/cache/clear`.

### Client App (Client)

Experience a sophisticated client application built with Laravel, incorporating HTML templates for dynamic content rendering. Advanced features include SEO optimization, HotJar, and Google Analytics integration.

Explore the client app: [https://nankov.mk/](https://nankov.mk/)

### Authentication for Single Sign-On (SSO) - External Apps

Secure authentication is implemented using Laravel Passport with OAuth 2 - Password Grant Tokens. Access the login page via `<domain>/login` with the added convenience of Laravel Breeze.

### Important Commands

Execute these commands for optimal functionality:

- `npm install` - Install dependencies (run at root).
- `npm run build` - Build the project (run at root).
- `php artisan migrate` - Run migrations (once during setup).
- `php artisan passport:install` - Create "personal access" and "password grant" clients for generating access tokens.
- `php artisan db:seed` - Seed the database to create the initial user.
- `php artisan monitoring:record` - for monitoring, its added in kernel.php for running on every 10 minutes
- `php artisan command:init` - for running migrate:fresh with passport:install & db:seed
- `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1` - for running a schedule on cron server

### Monitoring 

- `<domina>/pulse` - Laravel pulse for monitoring