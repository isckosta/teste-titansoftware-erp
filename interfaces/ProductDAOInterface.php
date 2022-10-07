<?php
    
    use models\Price;
    use models\Product;
    
    interface ProductDAOInterface
    {
        public function create(Product $product, Price $price);
        
        public function findAll();
        
        public function findById($id);
        
        public function update(Product $product);
        
        public function delete($id);
        
        public function sort($column, $orderSort);
    }