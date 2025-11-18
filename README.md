# Andrej Nankov Personal Website & Portfolio

A modern Laravel-based personal website and portfolio showcasing projects, technical expertise, and providing a platform for professional networking. Built as a comprehensive portfolio solution for developers and technical professionals.

## 🚀 About This Project

This is the personal website and portfolio of **Andrej Nankov** - a Fractional CTO, Startup Consultant, and Senior Engineer who partners with startups and companies to turn complex ideas into reliable, scalable software solutions. The site serves as both a portfolio showcase and a functional web application demonstrating modern Laravel development practices.

## ✨ Features

### Core Functionality
- **Professional Portfolio**: Showcase projects, skills, and professional experience
- **Newsletter System**: Built-in newsletter subscription with email management
- **Social Links Management**: Dynamic social media links with admin panel control
- **User Authentication**: Complete auth system with dashboard and profile management
- **Admin Panel**: Filament-based admin interface for content management

### Technical Features
- **Modern Laravel 12+** with latest PHP 8.4 support
- **Livewire 3.4+** for reactive components and real-time UI updates
- **Volt** integration for enhanced Livewire development
- **Filament 4.0** admin panel with full CRUD capabilities
- **Laravel Horizon** for queue monitoring and management
- **Responsive Design** using Tailwind CSS 3+ and DaisyUI components
- **Vite Build System** for optimized asset compilation
- **Docker Development Environment** with MySQL, Redis, and Adminer
- **Laravel Breeze** authentication scaffolding
- **Social Authentication** via Laravel Socialite
- **Cloudflare Turnstile** CAPTCHA integration
- **Database Newsletter** package for subscriber management
- **License Management** system for products/services

## 🛠 Technical Stack

### Backend
- **Laravel 12+** - PHP framework
- **PHP 8.4** - Server-side language
- **MySQL 5.7** - Primary database
- **Redis** - Caching and session storage
- **Laravel Horizon** - Queue management
- **Livewire** - Full-stack framework

### Frontend
- **Tailwind CSS 3+** - Utility-first CSS framework
- **DaisyUI** - Tailwind CSS component library
- **Vite 6.0** - Build tool and dev server
- **Blade Templates** - Laravel templating engine
- **Alpine.js** - Lightweight JavaScript framework (via Livewire)

### Development & Deployment
- **Docker & Docker Compose** - Containerization
- **Laravel Pint** - Code formatting
- **PHPUnit** - Testing framework
- **Laravel Pail** - Log monitoring
- **Concurrently** - Multi-process development

## 📦 What's Included

### 🌟 Portfolio Components
- Professional landing page with bio and services
- Project showcase capabilities
- Contact and about pages
- Newsletter subscription system
- Social media integration

### 🔧 Admin Features
- Filament admin panel (`/admin`)
- User management
- Newsletter subscriber management
- Social links management
- License management system
- Content management capabilities

### 🎨 UI Components
- Responsive design for all devices
- **Multiple theme support** (light, dark, cupcake, bumblebee, emerald, luxury, valentine, halloween, night, forest)
- Modern component library with DaisyUI and Tailwind Typography
- Accessibility-focused design
- SEO optimized with meta tags and Open Graph support

## 🚀 Getting Started

### Prerequisites

- **Docker & Docker Compose** (recommended)
- **PHP 8.4+** (if running locally)
- **Node.js 18+** (LTS version)
- **Composer** (PHP dependency manager)

### Quick Start with Docker

1. **Clone the repository:**
   ```bash
   git clone https://github.com/nanorocks/andrej.nankov.mk.git
   cd andrej.nankov.mk
   ```

2. **Start the development environment:**
   ```bash
   docker compose up -d --build
   ```

3. **Install dependencies and set up the application:**
   ```bash
   # Install PHP dependencies
   docker compose exec app composer install
   
   # Copy environment file and generate app key
   docker compose exec app cp .env.example .env
   docker compose exec app php artisan key:generate
   
   # Install Node dependencies and build assets
   docker compose exec app npm install
   docker compose exec app npm run build
   
   # Run database migrations and seed
   docker compose exec app php artisan migrate --seed
   ```

4. **Access the application:**
   - **Website**: [http://localhost](http://localhost)
   - **Admin Panel**: [http://localhost/admin](http://localhost/admin)
   - **Database Admin**: [http://localhost:54320](http://localhost:54320)
   - **Horizon Dashboard**: [http://localhost/horizon](http://localhost/horizon)
5. Shiled install
   - https://filamentphp.com/plugins/bezhansalleh-shield
   - `php artisan shield:setup`
   
### Local Development (Without Docker)

1. **Clone and navigate:**
   ```bash
   git clone https://github.com/nanorocks/andrej.nankov.mk.git
   cd andrej.nankov.mk/website
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup:**
   ```bash
   # Configure your database in .env file
   php artisan migrate --seed
   ```

5. **Start development servers:**
   ```bash
   # Option 1: Use Laravel's built-in dev command (concurrent)
   composer dev
   
   # Option 2: Start servers individually
   php artisan serve
   npm run dev
   php artisan queue:work
   ```

## 🔧 Development

### Available Commands

```bash
# Code formatting
./vendor/bin/pint

# Generate CRUD resources (custom package)
php artisan make:crud ResourceName

# Queue management
php artisan horizon
php artisan queue:work

# Asset compilation
npm run dev          # Development with hot reload
npm run build        # Production build

# Testing
php artisan test     # Run PHPUnit tests
vendor/bin/phpunit   # Alternative testing command

# Log monitoring
php artisan pail

# Database operations
php artisan migrate
php artisan migrate:fresh --seed
```

### Development Workflow

The project includes a comprehensive development setup with:

- **Hot reloading** for frontend assets via Vite
- **Queue processing** with Horizon dashboard
- **Real-time log monitoring** with Pail
- **Automated code formatting** with Pint
- **Concurrent development servers** via Composer script

### Environment Configuration

Key environment variables to configure:

```env
APP_NAME="Andrej Nankov"
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=portfolioapp
QUEUE_CONNECTION=database
CACHE_STORE=database
```

## 🗃 Database Schema

The application includes several key tables:

- **users** - User authentication and profiles
- **social_links** - Dynamic social media links
- **newsletter_subscribers** - Email subscription management
- **licenses** - Product/service license management
- **jobs** - Queue job processing
- **cache** - Application caching

## 📱 API & Integrations

- **Newsletter API** via custom package
- **Social Authentication** (configurable providers)
- **Cloudflare Turnstile** for CAPTCHA
- **License Management API** for products/services

## 🚀 Deployment

The project includes automated deployment workflows:

### CI/CD Pipeline
- **PHP Insights** - Code quality analysis on push/PR
- **Automated cPanel Deployment** - Direct deployment to hosting on main branch push

### Docker Production

1. Build production images
2. Configure environment variables
3. Run migrations
4. Set up reverse proxy (nginx/caddy)
5. Configure SSL certificates

### Traditional Hosting (cPanel/FTP)

The project includes automated deployment via GitHub Actions:

1. **Automatic Deployment**: Push to `main` branch triggers deployment
2. **FTP Sync**: Files are automatically synced to cPanel hosting
3. **Environment Setup**: Configure `.env` on server
4. **Database Migration**: Run migrations on production server

Manual deployment steps:
1. Upload files via FTP/Git
2. Install composer dependencies: `composer install --no-dev`
3. Configure web server (Apache/Nginx)
4. Set up database and run migrations
5. Configure file permissions
6. Set up cron jobs for queue processing

## 📚 Documentation & Resources

### Laravel Ecosystem
- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs/quickstart)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Horizon](https://laravel.com/docs/horizon)

### Frontend & Styling
- [Tailwind CSS](https://tailwindcss.com/docs)
- [DaisyUI Components](https://daisyui.com/)
- [Vite Documentation](https://vitejs.dev/guide/)

### Development Tools
- [CRUD Generator](https://github.com/ibex-devops/laravel-crud-generator)
- [Laravel Pint](https://laravel.com/docs/pint)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

**Built with ❤️ using Laravel, Livewire, and modern web technologies.**

For questions or collaboration opportunities, visit [andrej.nankov.mk](http://andrej.nankov.mk) or connect via the social links on the website.
