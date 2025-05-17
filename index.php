<?php
    require __DIR__ . '/vendor/autoload.php';
    use Demo\Mvc\controllers\HomeController;
    
    echo HomeController::getHome();
?>