# Laravel REST API with Sanctum

This is an example of a REST API using auth tokens with Laravel Sanctum.

It basically returns json data about tasks created by authenticated users

## Usage

Change the *.env.example* to *.env* and add your database info

For SQLite, add
```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
```

Create a _database.sqlite_ file in the _database_ directory

```
# Run the webserver on port 8000
php artisan serve
```

## Routes

```
# Public


POST   /api/login
@body: email, password

POST   /api/register
@body: name, email, password, password_confirmation


# Protected

POST   /api/tasks
@body: name, slug, description, price

PUT   /api/tasks/:id
@body: ?name, ?slug, ?description, ?price

DELETE  /api/tasks/:id

POST    /api/logout
```
