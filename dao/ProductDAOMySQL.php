<?php
    
    namespace dao;
    
    use http\Params;
    use models\Price;
    use models\Product;
    use PDO;
    use ProductDAOInterface as ProductDAOInterfaceAlias;
    
    require "models/Product.php";
    require "models/Price.php";
    require "interfaces/ProductDAOInterface.php";
    
    class ProductDAOMySQL implements ProductDAOInterfaceAlias
    {
        
        private PDO $pdo;
        
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }
        
        /**
         * Responsável por buscar o produto pelo id.
         * Retorna um objeto Produto ou um boolean (falso) caso não seja retornado nem um objeto.
         * @param $id
         * @return Product|bool
         */
        public function findById($id): Product|bool
        {
            $sql = $this->pdo->prepare("SELECT
                    products.id as product_id,
                    products.NAME as product_name,
                    products.color as product_color,
                    products.price_id as product_price,
                    price.id as price_id,
                    price.price as price
                FROM
                    products
                    INNER JOIN price ON price.id = products.price_id WHERE products.id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            
            // Se a consulta algum resultado, então o objeto Product será inicializado e suas propriedades atribuídas
            if ($sql->rowCount() > 0) {
                $data = $sql->fetch();
                
                $product = new Product();
                $price = new Price();
                $price->setId($data['price_id']);
                $price->setPrice($data['price']);
                $product->setId($data['product_id']);
                $product->setName($data['product_name']);
                $product->setColor($data['product_color']);
                $product->setPrice($price);
                
                // Retornará o objeto Product, após todas as suas propriedades serem definidas.
                return $product;
            } else {
                // Caso falhe, retornará falso.
                return false;
            }
        }
        
        /**
         * Responsável por inserir o produto no Banco de Dados.
         * Retorna um objeto Product.
         * @param Product $product
         * @param Price $price
         * @return Product
         */
        public function create(Product $product, Price $price): Product
        {
            $sql = $this->pdo->prepare("INSERT INTO products (name, color, price_id) VALUES (:name, :color, :price_id)");
            $sql->bindValue(":name", $product->getName());
            $sql->bindValue(":color", $product->getColor());
            $sql->bindValue(":price_id", $price->getId());
            $sql->execute();
            
            // Retorna o identificador para a linha inserida mais recentemente em uma tabela no banco de dados.
            $product->setId($this->pdo->lastInsertId());
            
            return $product;
        }
        
        /**
         * Responsável por buscar todos os produtos no Banco de Dados.
         * Retorna um array com o objeto Product.
         * @return array
         */
        public function findAll(): array
        {
            // Inicializa o array para receber o objeto Product posteriormente.
            $array = [];
            
            $sql = $this->pdo->prepare("
                SELECT
                    products.id as product_id,
                    products.NAME as product_name,
                    products.color as product_color,
                    products.price_id as product_price_id,
                    price.id as price_id,
                    price.price as price
                FROM
                    products
                    INNER JOIN price ON price.id = products.price_id;
            ");
            $sql->execute();
            
            // Se a consulta algum resultado, então o objeto Product será inicializado e suas propriedades atribuídas
            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll();
                
                foreach ($data as $item) {
                    $price = new Price();
                    $price->setId($item['price_id']);
                    $price->setPrice($item['price']);
                    
                    $product = new Product();
                    $product->setId($item['product_id']);
                    $product->setName($item['product_name']);
                    $product->setColor($item['product_color']);
                    $product->setPrice($price);
                    
                    // Insere o objeto Product dentro do array.
                    $array[] = $product;
                }
            }
            
            return $array;
        }
        
        /** Responsável por atualizar o produto no Banco de Dados.
         * Retorna um boolean (true) em caso de sucesso.
         * @param Product $product
         * @return bool
         */
        public function update(Product $product): bool
        {
            $sql = $this->pdo->prepare("UPDATE products SET name = :name, color = :color WHERE id = :id");
            $sql->bindValue(":name", $product->getName());
            $sql->bindValue(":color", $product->getColor());
            $sql->bindValue(":id", $product->getId());
            $sql->execute();
            
            return true;
        }
        
        /** Responsável por deletar o produto do Banco de Dados.
         * Não retorna nada.
         * @param $id
         * @return void
         */
        public function delete($id): void
        {
            $sql = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
        
        public function sort($operator, $value, $column = "name", $orderSort = "ASC"): array
        {
            // Inicializa o array para receber o objeto Product posteriormente.
            $array = [];
            
            $sql = "
                SELECT
                    products.id as product_id,
                    products.NAME as product_name,
                    products.color as product_color,
                    products.price_id as product_price_id,
                    price.id as price_id,
                    price.price as price
                FROM
                    products
                    INNER JOIN price ON price.id = products.price_id
            ";
            
            if ($_GET['operator'] == 'default') {
                $sql .= " ORDER BY ${column} ${orderSort}";
            } elseif ($_GET['operator'] == 'bigger_then' || $_GET['operator'] == 'less_then') {
                $sql .= " WHERE price ${operator} ${value} ORDER BY ${column} ${orderSort}";
            } else {
                $sql .= " WHERE price ${operator} ${value} ORDER BY ${column} ${orderSort}";
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            // Se a consulta algum resultado, então o objeto Product será inicializado e suas propriedades atribuídas
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
                
                foreach ($data as $item) {
                    $price = new Price();
                    $price->setId($item['price_id']);
                    $price->setPrice($item['price']);
                    
                    $product = new Product();
                    $product->setId($item['product_id']);
                    $product->setName($item['product_name']);
                    $product->setColor($item['product_color']);
                    $product->setPrice($price);
                    
                    // Insere o objeto Product dentro do array.
                    $array[] = $product;
                }
            }
            
            return $array;
        }
    }