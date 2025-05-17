<?php
    require __DIR__ . '/vendor/autoload.php';
    use Demo\Mvc\http\Router;
    use Demo\Mvc\views\View;
    
    // Setting constants of the project
    define('URL', 'http://localhost:8400/mvc');
    
    // Define default variables
    View::init([
        'URL' => URL
    ]);
    
    $router = new Router(URL);
    
    // Include all pages routes
    include __DIR__ . '/routes/pages.php';
    
    $router->run()->sendResponse();
?>