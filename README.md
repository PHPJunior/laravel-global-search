# Laravel Global Search

Laravel Global Search 

[![Latest Stable Version](https://poser.pugx.org/php-junior/laravel-global-search/v/stable)](https://packagist.org/packages/php-junior/laravel-global-search)
[![Total Downloads](https://poser.pugx.org/php-junior/laravel-global-search/downloads)](https://packagist.org/packages/php-junior/laravel-global-search)
[![License](https://poser.pugx.org/php-junior/laravel-global-search/license)](https://packagist.org/packages/php-junior/laravel-global-search)

## Installation
```php
composer require php-junior/laravel-global-search
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
PhpJunior\LaravelGlobalSearch\LaravelGlobalSearchProvider::class,
```

```php 
php artisan vendor:publish --provider="PhpJunior\LaravelGlobalSearch\LaravelGlobalSearchProvider"
```

This is the contents of the published config file:

```php
return [
    'resources' => [
        \App\Models\Auth\User::class
    ],
    'limit' => 10
];
```

## Usage
First <code>PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable</code> trait to models

```php
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;

class User extends Authenticatable
{
    use GlobalSearchable;
    
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    protected  $search = [
        'name', 'email',
    ];

    /**
     * The columns that should be displayed.
     *
     * @var array
     */
    protected $only = [
        'name', 'email'
    ];

    /**
     * The columns that should be ordered.
     *
     * @var array
     */
    protected  $order = [
        'name' => 'desc',
        'email' => 'asc'
    ];

    // Optional
    protected $searchQuery = [
        [
            'method' => 'where',
            'column' => 'email',
            'operator' => '=',
            'value' => 'usern@user.com'
        ],
        [
            'method' => 'whereBetween',
            'column' => 'votes',
            'value' => [1, 100]
        ]
    ];

    /**
     * @var string
     */
    protected $searchIndex = 'users-index';
}
```

Search 
```php
LaravelGlobalSearch::search($text)
```


## Credits
- All Contributors

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
