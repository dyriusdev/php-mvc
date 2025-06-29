<?php
    namespace Demo\Mvc\controllers;

    use Demo\Mvc\views\View;
                
    abstract class ViewController {
        
        /**
         * Responsable to render the header of the page
         * @return string with the header
         */
        private static function getHeader() : string {
            return View::render('header');
        }
        
        /**
         * Responsable to render the footer of the page
         * @return string with the footer
         */
        private static function getFooter() : string {
            return View::render('footer');
        }
        
        /**
         * Get the view requested and prepare the arguments to be inserted into the content view
         * @param string $title of the view
         * @param string $content of the body
         * @return string html ready to be displayed
         */
        protected static function getView(string $title, string $content) : string {
            return View::render('page', [
                'title' => $title,
                'header' => self::getHeader(),
                'content' => $content,
                'footer' => self::getFooter()
            ]);
        }
        
        public static function getPagination($request, $pagination) {
            $pages = $pagination->getPages();
            if (count($pages) <= 1) {
                return '';
            }
            
            $links = '';
            $url = $request->getRouter()->getCurrentUrl();
            $queryParams = $request->getQueryParams();
            
            foreach ($pages as $page) {
                $queryParams['page'] = $page['page'];
                $link = $url . '?' . http_build_query($queryParams);
                
                $links .= View::render('link', [
                    'link' => $link,
                    'page' => $page['page'],
                    'active' => $page['current'] ? 'active' : ''
                ]);
            }
            
            return View::render('box', ['links' => $links]);
        }
    }
?>