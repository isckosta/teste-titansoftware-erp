<?php
    
    namespace models;
    
    use models\Price as Price;
    
    class Product
    {
        private int $id;
        private string $name;
        private string $color;
        private Price $price;
        
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
        public function getName(): string
        {
            return $this->name;
        }
        
        /**
         * @param string $name
         */
        public function setName(string $name): void
        {
            $this->name = ucfirst($name);
        }
        
        /**
         * @return string
         */
        public function getColor(): string
        {
            return $this->color;
        }
        
        /**
         * @param string $color
         */
        public function setColor(string $color): void
        {
            $this->color = ucfirst($color);
        }
        
        /**
         * @return Price
         */
        public function getPrice(): Price
        {
            return $this->price;
        }
        
        /**
         * @param Price $price
         */
        public function setPrice(Price $price): void
        {
            $this->price = $price;
        }
        
    }
