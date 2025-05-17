<?php
    namespace Demo\Mvc\controllers;
    
    use Demo\Mvc\views\View;
                
    class AboutController extends ViewController {
        
        public static function getAbout() {
            $content = View::render('about', [
                'name' => 'Test about',
                'description' => 'page about'
            ]);
            
            return parent::getView('About', $content);
        }
    }
?>