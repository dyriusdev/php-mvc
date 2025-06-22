<?php
    namespace Demo\Mvc\http\middleware;

    use Closure;
use Demo\Mvc\http\Request;
use Demo\Mvc\http\Response;
                                    
    class Queue {
        
        /**
         * Mapping middlewares
         * @var array
         */
        private static array $map = [];
        
        /**
         * Default middlewares
         * @var array
         */
        private static array $default = [];
        
        /**
         * Queue of middleware to be executed
         * @var array
         */
        private array $middlewares = [];
        
        /**
         * Execution function from controller
         * @var Closure
         */
        private Closure $controller;
        
        /**
         * Arguments to controller
         * @var array
         */
        private array $controllerArgs = [];
        
        public function __construct($middlewares, $controller, $controllerArgs) {
            $this->middlewares = array_merge(self::$default, $middlewares);
            $this->controller = $controller;
            $this->controllerArgs = $controllerArgs;
        }
        
        public static function setMap(array $map) {
            self::$map = $map;
        }
        
        public static function setDefault(array $default) {
            self::$default = $default;
        }
        
        /**
         * Execute the next level from the queue
         * @param Request $request
         * @return Response
         */
        public function next(Request $request) : Response {
            if (empty($this->middlewares)) {
                return call_user_func_array($this->controller, $this->controllerArgs);
            }
            
            $middleware = array_shift($this->middlewares);
            
            if (!isset(self::$map[$middleware])) {
                throw new \Exception('Error processing midleware request', 500);
            }
            
            $queue = $this;
            $next = function ($request) use($queue) {
                return $queue->next($request);
            };
            
            return (new self::$map[$middleware])->handle($request, $next);
        }
    }
?>