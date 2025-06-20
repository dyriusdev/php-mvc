<?php
    namespace Demo\Mvc\models\entity;
    
    use WilliamCosta\DatabaseManager\Database;

    class Testimony {
        
        public int $id;
        
        public string $name, $message, $date;
        
        /**
         * Responsable to register the current instance in database
         * @return boolean
         */
        public function register() : bool {
            $this->date = date('Y-m-d H:i:s');
            $this->id = (new Database('testmony'))->insert([
                'name' => $this->name,
                'message' => $this->message,
                'date' => $this->date
            ]);
            
            return true;
        }
        
        
        public static function getTestimonials($where = null, $order = null, $limit = null, $fields = '*') {
            return (new Database('testmony'))->select($where, $order, $limit, $fields);
        }
    }
?>