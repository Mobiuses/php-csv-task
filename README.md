#  PHP backend test-task

## Installation

```
git clone https://gitlab.com/default1951018/test-task.git
cd test-task
cp .env.example .env
docker-compose up -d --build
docker-compose exec php composer install
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
```

#### Optional
```
docker-compose exec php php artisan migrate:fresh
docker-compose exec php php artisan db:seed
```

### Tests
```
docker-compose exec php php artisan test
```

## Usage

### Feature: Import
```
http://localhost/import
```
OR
```
docker-compose exec php php artisan db:seed
```


### Feature: Export
```
http://localhost/export
```

### Feature: API endpoint ``GET /api/clients``

required Header: ``Accept : application/json``

Expected response JSON collection
```
http://localhost/api/clients
```
### Pagination
GET param: ``page``,``per_page``
```
http://localhost/api/clients?page=1
http://localhost/api/clients?page=2
http://localhost/api/clients?page=2&per_page=1000
```

### Filters
GET param: ``category``
```
http://localhost/api/clients?category=films
http://localhost/api/clients?category=toys
```

GET param: ``gender``
```
http://localhost/api/clients?gender=male
http://localhost/api/clients?gender=female
```

GET param: ``birth_date``
```
http://localhost/api/clients?birth_date=1993-11-08
http://localhost/api/clients?birth_date=1996-02-27
```

GET param: ``age``
```
http://localhost/api/clients?age=25
http://localhost/api/clients?age=19
```

GET param: ``age range ``
```
http://localhost/api/clients?age_after=25&age_before=28   (25 - 28)
http://localhost/api/clients?age_after=19&age_before=37   (19 - 37)
http://localhost/api/clients?age_after=35&age_before=56   (35 - 56)
```

### Mixed Filter examples

```
http://localhost/api/clients?gender=male&category=films&age_after=25&age_before=28
http://localhost/api/clients?age=27&gender=female
http://localhost/api/clients?birth_date=1996-02-27&gender=female
http://localhost/api/clients?age_after=35&age_before=56&gender=male&category=toys&per_page=1000&page=3
```
