<?php
    namespace Demo\Mvc\views;
    
    class View {
        
        /**
         * Read content from the file and return the result
         * @param string $view is the name of the file
         * @return string is the content of the file if exists otherwise return an empty string
         */
        private static function getContentView(string $view) : string {
            $file = __DIR__ . '/../../resources/view/' . $view . '.html';
            return file_exists($file) ? file_get_contents($file) : '';
        }
        
        /**
         * Read the content of the view and prepare the information
         * to be displayed inside the content
         * @param string $view the name of the file to be showed
         * @param array $args list of arguments to be placed inside the content view
         * @return string html prepared to be showed
         */
        public static function render(string $view, array $args = []) : string {
            $contentView = self::getContentView($view);
            
            $keys = array_keys($args);
            $keys = array_map(function($item) {
                return '{{' . $item . '}}';
            }, $keys);
            
            return str_replace($keys, array_values($args), $contentView);
        }
    }
?>