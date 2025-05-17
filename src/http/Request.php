<?php
    namespace Demo\Mvc\http;
    
    class Request {
        
        private string $method, $uri;
        private array $queryParams = [], $postVars = [], $headers = [];
    
        public function __construct() {
            $this->queryParams = $_GET ?? [];
            $this->postVars = $_POST ?? [];
            $this->headers = getallheaders();
            $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';
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