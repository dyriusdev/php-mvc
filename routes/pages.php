<?php
    
    use Demo\Mvc\http\Response;
    use Demo\Mvc\controllers\HomeController;
    use Demo\Mvc\controllers\AboutController;
use Demo\Mvc\controllers\TestimonyController;
    
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
    
    //Testimonials route
    $router->get('/testimonials', [
        function($request) {
            return new Response(200, TestimonyController::getTestimony($request));
        }
    ]);
    
    //Testimonials route (insert)
    $router->post('/testimonials', [
        function($request) {
            return new Response(200, TestimonyController::insertTestimony($request));
        }
    ]);
    
    
    
    
    
    //Dynamic route
    $router->get('/page/{idPage}', [
        function($idPage) {
            return new Response(200, 'page ' . $idPage);
        }
    ]);
?>