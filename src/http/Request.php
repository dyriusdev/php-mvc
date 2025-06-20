<?php
    namespace Demo\Mvc\http;
    
    class Request {
        
        private Router $router;
        private string $method, $uri;
        private array $queryParams = [], $postVars = [], $headers = [];
    
        public function __construct($router) {
            $this->router = $router;
            
            $this->queryParams = $_GET ?? [];
            $this->postVars = $_POST ?? [];
            $this->headers = getallheaders();
            $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->setUri();
        }
        
        private function setUri() {
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';
            
            $xUri = explode('?', $this->uri);
            $this->uri = $xUri[0];
            
        }
        
        public function getRouter() {
            return $this->router;
        }
        
        public function getMethod() {
            return $this->method;
        }
        
        public function getUri() {
            return $this->uri;
        }
        
        public function getQueryParams() {
            return $this->queryParams;
        }
        
        public function getPostVars() {
            return $this->postVars;
        }
        
        public function getHeaders() {
            return $this->headers;
        }
    }
?>