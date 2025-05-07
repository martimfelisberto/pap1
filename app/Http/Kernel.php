protected $routeMiddleware = [
// ...existing code...
'admin' => \App\Http\Middleware\AdminMiddleware::class,
];