protected $routeMiddleware = [
    // ...
    'auth.admin' => \App\Http\Middleware\AdminMiddleware::class,
];

protected $routeMiddleware = [
    'staff.role' => \App\Http\Middleware\StaffRole::class,
];