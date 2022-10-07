<?php
    
    use models\Price;
    
    interface PriceDAOInterface
    {
        public function create(Price $price);
        
        public function findAll();
        
        public function findById($id);
        
        public function update(Price $price);
        
        public function delete($id);
    }