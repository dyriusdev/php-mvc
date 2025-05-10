<?php
    namespace Demo\Mvc\controllers;

    use Demo\Mvc\views\View;
                
    abstract class ViewController {
        
        /**
         * Get the view requested and prepare the arguments to be inserted into the content view
         * @param string $title of the view
         * @param string $content of the body
         * @return string html ready to be displayed
         */
        protected static function getView(string $title, string $content) : string {
            return View::render('', [
                'title' => $title,
                'content' => $content
            ]);
        }
    }
?>