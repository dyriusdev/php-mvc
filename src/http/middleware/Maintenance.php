<?php
    namespace Demo\Mvc\http\middleware;

    use Demo\Mvc\http\Request;
    use Closure;
    use Demo\Mvc\http\Response;
                                
    class Maintenance {
        
        public function handle(Request $request, Closure $next) : Response {
            if (getenv('MAINTENANCE') == 'true') {
                throw new \Exception('Page in maintenance. Try again later', 200);
            }
            return $next($request);
        }
    }
?>