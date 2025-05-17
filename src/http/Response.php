<?php
    namespace Demo\Mvc\http;
    
    class Response {
        
        private int $statusCode = 200;
        private array $headers = [];
        private string $contentType = 'text/html';
        private mixed $content;
        
        public function __construct(int $httpCode, mixed $content, string $contentType = 'text/html') {
            $this->statusCode = $httpCode;
            $this->content = $content;
            $this->setContentType($contentType);
        }
        
        public function setContentType(string $contentType) : void {
            $this->contentType = $contentType;
            $this->addHeader('Content-Type', $contentType);
        }
        
        /**
         * Method responsable to add an register to the header response
         * @param string $key
         * @param string $value
         */
        public function addHeader(string $key, string $value) : void {
            $this->headers[$key] = $value;
        }
        
        /**
         * Send the response to the client
         */
        public function sendResponse() : void {
            $this->sendHeaders();
            
            switch ($this->contentType) {
                case 'text/html':
                    echo $this->content;
                    exit;
            }
        }
        
        /**
         * Send all headers to the client
         */
        private function sendHeaders() : void {
            // Send http status
            http_response_code($this->statusCode);
            
            // Send headers
            foreach ($this->headers as $key => $value) {
                header($key . ':' . $value);
            }
        }
    }
?>