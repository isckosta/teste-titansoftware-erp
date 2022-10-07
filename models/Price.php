<?php
    
    namespace models;
    
    class Price
    {
        public int $id;
        public string $price;
    
        /**
         * @return int
         */
        public function getId(): int
        {
            return $this->id;
        }
    
        /**
         * @param int $id
         */
        public function setId(int $id): void
        {
            $this->id = $id;
        }
    
        /**
         * @return string
         */
        public function getPrice(): string
        {
            return $this->price;
        }
    
        /**
         * @param string $price
         */
        public function setPrice(string $price): void
        {
            $this->price = $price;
        }
        
        
    }