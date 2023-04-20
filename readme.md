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
