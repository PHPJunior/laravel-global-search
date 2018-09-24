# Laravel Global Search [ WIP ]
Laravel Global Search 

### Config

```php
return [
    'resources' => [
        \App\Models\Auth\User::class
    ],
    'limit' => 10
];
```

### Usage

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

```php
LaravelGlobalSearch::search($text)
```
