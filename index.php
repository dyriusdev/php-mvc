<?php
    require __DIR__ . '/vendor/autoload.php';
    use Demo\Mvc\http\Router;
    use Demo\Mvc\views\View;
    
    WilliamCosta\DotEnv\Environment::load(__DIR__);
    
    // Setting constants of the project
    define('URL', getenv('URL'));
    
    // Define default variables
    View::init([
        'URL' => URL
    ]);
    
    $router = new Router(URL);
    
    // Include all pages routes
    include __DIR__ . '/routes/pages.php';
    
    $router->run()->sendResponse();
?>