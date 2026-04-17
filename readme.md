# mukuru-site
## Structure
```basch
.
├── app
│   ├── Console
│   │   └── Kernel.php
│   ├── Exceptions
│   │   └── Handler.php
│   ├── Http
│   │   ├── Controllers
│   │   ├── Kernel.php
│   │   └── Middleware
│   ├── Providers
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── BroadcastServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   └── User.php
├── artisan
├── bootstrap
│   ├── app.php
│   └── cache
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── broadcasting.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   └── 2014_10_12_100000_create_password_resets_table.php
│   └── seeds
│       └── DatabaseSeeder.php
├── package-lock.json
├── package.json
├── phpunit.xml
├── public
│   ├── css
│   │   └── app.css
│   ├── favicon.ico
│   ├── fonts
│   │   └── vendor
│   ├── index.php
│   ├── js
│   │   └── app.js
│   ├── mix-manifest.json
│   ├── robots.txt
│   └── web.config
├── readme.md
├── resources
│   ├── assets
│   │   ├── js
│   │   └── sass
│   ├── lang
│   │   └── en
│   └── views
│       ├── layouts
│       └── welcome.blade.php
├── routes
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
├── server.php
├── storage
│   ├── app
│   │   └── public
│   ├── framework
│   │   ├── cache
│   │   ├── sessions
│   │   ├── testing
│   │   └── views
│   └── logs
├── tests
│   ├── CreatesApplication.php
│   ├── Feature
│   │   └── ExampleTest.php
│   ├── TestCase.php
│   └── Unit
│       └── ExampleTest.php
└── webpack.mix.js
```
#### Requires:
- php > 7.0
- npm 5.6.0
- composer

### Manual Setup Instructions

- Run npm install
- Run composer install
- Copy .env.tpl and update the api-url and database configurations

### Running the application

- Run php artisan serve --port 8080

- after entering your info in the front end, click outside the text field for Vue to send the api call

---

## Codebase Assessment Report (Story 01KPDSEX-s-001)

**Assessment Date:** 2026-04-17

### Environment Status
- ✅ **PHP 8.5.5** installed (exceeds PHP 7.4+ requirement)
- ✅ **Composer 2.9.7** installed and available
- ❌ **Dependencies:** Compatibility issues with PHP 8.5.5

### Current Test Suite Status
- **Framework:** PHPUnit ~6.0
- **Status:** CANNOT EXECUTE (dependency conflicts)
- **Test Files:** Feature/ExampleTest.php, Unit/ExampleTest.php

### Dependencies Audit Results
**Laravel 5.5 Framework** - END OF LIFE (August 2020)
- Core dependencies locked to PHP 7.x versions
- 34+ packages incompatible with current PHP 8.5.5
- Security risk: No patches available for framework

### Critical Issues Identified
1. **Composer Lock Incompatibility:** All locked packages require PHP ^7.0-^7.1.3
2. **Security Risk:** Laravel 5.5 has unpatched vulnerabilities
3. **Frontend Dependencies:** Outdated (Vue 2.5.7, Bootstrap 3.3.7, Laravel Mix 1.0)
4. **Missing Configuration:** .env file not present

### Backup Status
- ✅ `composer.lock` backed up to `backup-pre-upgrade/`
- ❌ `vendor/` directory not present (dependencies not installed)

### Immediate Resolution Required
```bash
# Fix dependency compatibility
composer update

# Create environment configuration  
cp .env.example .env
php artisan key:generate

# Install frontend dependencies
npm install
```

### Upgrade Path Recommendation
- **Immediate:** Resolve PHP 8.x compatibility with `composer update`
- **Short-term:** Consider PHP version downgrade to 7.4 for stability
- **Long-term:** Plan Laravel upgrade to modern LTS version (10.x+)
