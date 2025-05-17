<?php
    
    use Demo\Mvc\http\Response;
    use Demo\Mvc\controllers\HomeController;
    use Demo\Mvc\controllers\AboutController;
    
    //Home route
    $router->get('/', [
        function() {
            return new Response(200, HomeController::getHome());
        }
    ]);
    
    //About route
    $router->get('/about', [
        function() {
            return new Response(200, AboutController::getAbout());
        }
    ]);
    
    //Dynamic route
    $router->get('/page/{idPage}', [
        function($idPage) {
            return new Response(200, 'page ' . $idPage);
        }
    ]);
?>