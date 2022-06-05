<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

//curl http://localhost/BookShop/index.php --verbose
// TODO: handle request
$sp = new \ServiceProvider();

// --- APPLICATION
$sp->register(\Application\AddBookToCartCommand::class);
$sp->register(\Application\BooksQuery::class);
$sp->register(\Application\CategoriesQuery::class);
$sp->register(\Application\CheckOutCommand::class);
$sp->register(\Application\RemoveBookFromCartCommand::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
// --------- SERVICES
$sp->register(\Application\Services\AuthenticationService::class);
$sp->register(\Application\Services\CartService::class);
// --- PRESENTATION
$sp->register(\Presentation\MVC\MVC::class, function () {
    return new \Presentation\MVC\MVC();
}, isSingleton: true);
// controllers
$sp->register(\Presentation\Controllers\Books::class);
$sp->register(\Presentation\Controllers\Cart::class);
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\Order::class);
$sp->register(\Presentation\Controllers\User::class);

// --- INFRASTRUCTURE
$sp->register(\Infrastructure\Session::class, isSingleton: true);   // !! Important damit start_session nur einmal aufgerufen wird
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
$sp->register(\Infrastructure\Repository::class, implementation: function() {
    return new \Infrastructure\Repository('localhost', 'root', '', 'bookshop');}, isSingleton: true);
$sp->register(\Application\Interfaces\BookRepository::class, \Infrastructure\Repository::class);    //statt FakeRepo nur Repository hinschreiben
$sp->register(\Application\Interfaces\CategoryRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\OrderRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);

$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);