<?php
    namespace Demo\Mvc\http;
    
    use \Closure;
    use \Exception;
    use \ReflectionFunction;
    
    class Router {
        
        private string $url = '', $prefix = '';
        private array $routes = [];
        private Request $request;
        
        public function __construct(string $url) {
            $this->request = new Request();
            $this->url = $url;
            $this->setPrefix();
        }
        
        /**
         * Define route prefix
         */
        private function setPrefix() : void {
            $parseURL = parse_url($this->url);
            $this->prefix = $parseURL['path'] ?? '';
        }
        
        /**
         * Register the route
         * @param string $method
         * @param string $route
         * @param array $params
         */
        private function addRoute(string $method, string $route, array $params = []) : void {
            // Validating params
            foreach ($params as $key => $value) {
                if ($value instanceof Closure) {
                    $params['controller'] = $value;
                    unset($params[$key]);
                    continue;
                }
            }
            
            // Route variables (dinamyc support)
            $params['variables'] = [];
            $patternVariable = '/{(.*?)}/';
            if (preg_match_all($patternVariable, $route, $matches)) {
                $route = preg_replace($patternVariable, '(.*?)', $route);
                $params['variables'] = $matches[1];
            }
            
            
            $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
            
            $this->routes[$patternRoute][$method] = $params;
        }
        
        private function getUri() : string {
            $uri = $this->request->getUri();
            $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
            return end($xUri);
        }
        
        /**
         * Get all data from current route
         * @return array
         */
        private function getRoute() : array {
            $uri = $this->getUri();
            $method = $this->request->getMethod();
            
            foreach ($this->routes as $pattern => $methods) {
                // Check if uri match the defined pattern
                if (preg_match($pattern, $uri, $matches)) {
                    // Validate methods
                    if (isset($methods[$method])) {
                        unset($matches[0]);
                        
                        // Processed keys
                        $keys = $methods[$method]['variables'];
                        $methods[$method]['variables'] = array_combine($keys, $matches);
                        $methods[$method]['variables']['request'] = $this->request;
                        
                        return $methods[$method];
                    }
                    
                    throw new Exception("Method not allowed", 405);
                }
            }
            
            throw new Exception("URL not found", 404);
        }
        
        /**
         * This method execute the current route
         * @return Response
         */
        public function run() : Response {
            try {
                $route = $this->getRoute();
                
                if (!isset($route['controller'])) {
                    throw new Exception('URL can´t be processed', 500);
                }
                
                $args = [];
                $reflection = new ReflectionFunction($route['controller']);
                foreach ($reflection->getParameters() as $parameter) {
                    $name = $parameter->getName();
                    $args[$name] = $route['variables'][$name] ?? '';
                }
                
                return call_user_func_array($route['controller'], $args);
            } catch (Exception $e) {
                return new Response($e->getCode(), $e->getMessage());
            }
        }
        
        /**
         * Define the GET route
         * @param string $route
         * @param array $params
         */
        public function get(string $route, array $params = []) {
            return $this->addRoute('GET', $route, $params);
        }
        
        /**
         * Define the POST route
         * @param string $route
         * @param array $params
         */
        public function post(string $route, array $params = []) {
            return $this->addRoute('POST', $route, $params);
        }
        
        /**
         * Define the PUT route
         * @param string $route
         * @param array $params
         */
        public function put(string $route, array $params = []) {
            return $this->addRoute('PUT', $route, $params);
        }
        
        /**
         * Define the DELETE route
         * @param string $route
         * @param array $params
         */
        public function delete(string $route, array $params = []) {
            return $this->addRoute('DELETE', $route, $params);
        }
    }
?>