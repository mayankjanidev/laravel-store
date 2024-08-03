# Laravel Store

Create reusable database queries and data objects in Laravel.

## Requirements

-   PHP >= 8.1
-   Laravel >= 9.0

## Installation

Install the package via Composer:

```sh
composer require mayankjanidev/laravel-store
```

## Purpose

Often, we have business critical data that we want to manage in a project. We might use them in controllers, services, console commands, admins, and other pieces of code. Laravel Store helps you centralize this critical data, so it's easy to manage and update it from time to time. This helps debug things faster and avoids query duplication scattered around the codebase.

## Basic Usage

Create a store via the command line:
```sh
php artisan make:store TopRatedMovies
```

A store file will be created in App\Stores\TopRatedMovies.

You can also specify your own location, like for example in App\Data:
```sh
php artisan make:store TopRatedMovies --namespace=Data
```

Store example:
```php
namespace App\Stores;

use Illuminate\Database\Eloquent\Builder;

use Mayank\Store\QueryStore;
use App\Models\Movie;

class TopRatedMovies extends QueryStore
{
    public function query(): Builder
    {
        return Movie::orderByDesc('rating');
    }
}
```

You can now use this class anywhere in your codebase to fetch data. For example, in a controller:

```php
class TopRatedMoviesController extends Controller
{
    public function index(TopRatedMovies $topRatedMovies)
    {
        $movies = $topRatedMovies->get();
        ...
    }
}
```

This example uses dependency injection, but you can also manually instantiate the classes.

```php
$movies = (new TopRatedMovies)->get();
```

Congrats! Now you have one central place where you can customize the database queries, and you won't have to hunt down controllers to find it. But this is just the beginning, Laravel Store offers even more powerful features to manage data in your application.

## Caching

Every store has its own methods to manage cache.

Get cached data:
```php
(new TopRatedMovies)->getCachedData();
```

Build cache:
```php
(new TopRatedMovies)->cache();
```

Clear cache:
```php
(new TopRatedMovies)->clearCache();
```

### Customize Cache Settings
By default, cache duration is forever, and the cache key is calculated by the class name ('top-rated-movies' in this case). But you can customize it.

```php
class TopRatedMovies extends QueryStore
{
    public function cacheKey(): string
    {
        return 'best-movies';
    }

    public function cacheDuration(): DateTime
    {
        return now()->addHours(2);
    }
}
```

### Manually specifying cache data
By default, all the data specified in the `query()` method will be cached by executing `->get()` on the query. But you can cache a portion of the data.

```php
class TopRatedMovies extends QueryStore
{
    public function cacheData(): Collection
    {
        return $this->query()->limit(250)->get();
    }
}
```

## Pagination
You can get the paginated data for your database queries.

```php
(new TopRatedMovies)->paginate();
(new TopRatedMovies)->simplePaginate();
```

This just calls the `->paginate()` method on the `query()`, so it works the same as [Laravel Pagination](https://laravel.com/docs/pagination).

## Custom Store
You might have some data in your application that is in a different format, like an array, and does not return a database query. In those cases, you can use a `CustomStore` where you can return data in your own format rather than being dependent on Laravel model and query builder.

```php
use Mayank\Store\CustomStore;

class Languages extends CustomStore
{
    public function data(): array
    {
        return ['English', 'Spanish', 'French'];
    }
}
```

Create a custom store via the command line:
```sh
php artisan make:store Languages --custom
```

All the caching methods work exactly the same as in `QueryStore`.

## Cache Commands
If you manage your data via the command line or via [Task Scheduling](https://laravel.com/docs/scheduling), Laravel Store provides cache specific commands:

Cache data:
```sh
php artisan store:cache TopRatedMovies
```

Clear cache:
```sh
php artisan store:clear TopRatedMovies
```

Use in Task Scheduling:
```sh
Schedule::command('store:cache TopRatedMovies')->daily();
```

## Advanced Usage

### Invalidate cache when data is changed
You might want to invalidate the cache or rebuild it when the underlying data is changed. Combine this package with [Laravel Observers](https://laravel.com/docs/eloquent#observers) to achieve the same.

```php
class MovieObserver
{
    public function updated(Movie $movie): void
    {
        (new TopRatedMovies)->clearCache();
    }
}
```

### Different variations of the same data
In some cases, you might want to show different variations of the same data. For example, in your API you would like to show a very small subset of data. As Laravel Store is just a class, you can add your own methods to it.

```php
class TopRatedMovies extends QueryStore
{
    public function query(): Builder
    {
        return Movie::orderByDesc('rating');
    }

    public function getDataForApi(): Collection
    {
        return $this->query()->limit(10)->get();
    }
}
```

### Dependency on other classes
In some cases, your data could be dependent on some other piece of data. In those cases, you could simply use constructors to inject it.

```php
class TopRatedMovies extends QueryStore
{
    public function __construct(protected Country $country)
    {
    }

    public function query(): Builder
    {
        return Movie::orderByDesc('rating')->where('country', $this->country->name);
    }
}
```

Laravel's [Service Container](https://laravel.com/docs/container) can automatically resolve your dependencies.

## License

This package is released under the [MIT License](LICENSE).
