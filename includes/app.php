<?php
    require __DIR__ . '/../vendor/autoload.php';
    
    use Demo\Mvc\views\View;
    use WilliamCosta\DotEnv\Environment;
    use WilliamCosta\DatabaseManager\Database;
    
    // Load ambient variable
    Environment::load(__DIR__ . '/../');
    
    // Define database configuration
    Database::config(
        getenv('DB_HOST'),
        getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        getenv('DB_PORT')
    );
    
    // Setting constants of the project
    define('URL', getenv('URL'));
    
    // Define default variables
    View::init([
        'URL' => URL
    ]);
?>