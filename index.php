<?php
    require __DIR__ . '/includes/app.php';    
    
    use Demo\Mvc\http\Router;
       
    // Init router
    $router = new Router(URL);
    
    // Include all pages routes
    include __DIR__ . '/routes/pages.php';
       
    // Print route result
    $router->run()->sendResponse();
?>