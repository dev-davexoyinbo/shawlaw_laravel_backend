# Setup
```bash
composer install
cp .env.example .env
```

Configure the .env file to replace
```env
DB_CONNECTION=<database driver eg mysql>
DB_HOST=<host eg 127.0.0.1>
DB_PORT=<port eg 3360>
DB_DATABASE=<database name eg shurlaw>
DB_USERNAME=<database username>
DB_PASSWORD=<database password>
```


Run the setup command
```bash
php artisan platform:setup
```

## Startup the server
```bash
php artisan serve
```
