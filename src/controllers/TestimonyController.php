<?php
    namespace Demo\Mvc\controllers;
    
    use Demo\Mvc\views\View;
    use Demo\Mvc\models\entity\Testimony;
    use WilliamCosta\DatabaseManager\Pagination;
                                
    class TestimonyController extends ViewController {
        
        private static function getTestimonyItems($request, &$pagination) {
            $items = '';
            
            $amount = Testimony::getTestimonials(null, null, null, 'COUNT(*) as amt')->fetchObject()->amt;
            
            $queryParams = $request->getQueryParams();
            $currentPage = $queryParams['page'] ?? 1;
            
            $pagination = new Pagination($amount, $currentPage, 1);
            
            $results = Testimony::getTestimonials(null, 'id DESC', $pagination->getLimit());
            
            while ($testimony = $results->fetchObject(Testimony::class)) {
                $items .= View::render('testimony_card', [
                    'name' => $testimony->name,
                    'message' => $testimony->message,
                    'date' => date('d/m/Y H:i:s', strtotime($testimony->date))
                ]);
            }
            
            return $items;
        }
        
        public static function getTestimony($request) {
            $content = View::render('testimonials', [
                'items' => self::getTestimonyItems($request, $pagination),
                'pagination' => parent::getPagination($request, $pagination)
            ]);
            
            return parent::getView('Testimonials', $content);
        }
        
        public static function insertTestimony($request) {
            $postVars = $request->getPostVars();
            
            $testimony = new Testimony();
            $testimony->name = $postVars['name'];
            $testimony->message = $postVars['message'];
            $testimony->register();
            
            return self::getTestimony($request);
        }
    }
?>