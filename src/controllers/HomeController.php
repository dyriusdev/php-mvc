<?php
    namespace Demo\Mvc\controllers;
    
    use Demo\Mvc\views\View;
                
    class HomeController extends ViewController {
        
        public static function getHome() {
            $content = View::render('home', [
                'name' => 'Test home',
                'description' => 'Information inserted into home.html'
            ]);
            
            return parent::getView('Home', $content);
        }
    }
?>