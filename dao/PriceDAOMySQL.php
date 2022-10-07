<?php
    
    namespace dao;
    
    use models\Price;
    use PDO;
    use PriceDAOInterface;
    
    require "interfaces/PriceDAOInterface.php";
    
    class PriceDAOMySQL implements PriceDAOInterface
    {
        private PDO $pdo;
        
        // Método construtor
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }
        
        /**
         * Responsável por buscar o preço do produto pelo id. Basicamente, será usado apenas internamente pelo objeto Produto.
         * Retorna um objeto Price ou um boolean (falso) caso não seja retornado nem um objeto.
         * @param $id
         * @return Price|bool
         */
        public function findById($id): Price|bool
        {
            $sql = $this->pdo->prepare("SELECT * FROM price WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            
            // Se a consulta algum resultado, então o objeto Price será inicializado e suas propriedades atribuídas
            if ($sql->rowCount() > 0) {
                $data = $sql->fetch();
                
                $price = new Price();
                $price->setId($data['id']);
                $price->setPrice($data['price']);
                
                // Retornará o objeto Price, após todas as suas propriedades serem definidas.
                return $price;
            } else {
                // Caso falhe, retornará falso.
                return false;
            }
        }
        
        /**
         * Responsável por inserir o preço do produto no Banco de Dados.
         * Retorna um objeto Price.
         * @param Price $price
         * @return Price
         */
        public function create(Price $price): Price
        {
            $sql = $this->pdo->prepare("INSERT INTO price (price) VALUES (:price)");
            $sql->bindValue(":price", $price->getPrice());
            $sql->execute();
            
            // Retorna o identificador para a linha inserida mais recentemente em uma tabela no banco de dados.
            $price->setId($this->pdo->lastInsertId());
            
            return $price;
        }
        
        /**
         * Responsável por buscar todos os preços do produto no Banco de Dados.
         * Retorna um array com o objeto Price.
         * @return array
         */
        public function findAll(): array
        {
            // Inicializa o array para receber o objeto Price posteriormente.
            $array = [];
            
            $sql = $this->pdo->prepare("SELECT * FROM price");
            $sql->execute();
            
            // Se a consulta algum resultado, então o objeto Price será inicializado e suas propriedades atribuídas
            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll();
                
                foreach ($data as $item) {
                    $price = new Price();
                    $price->setId($item['id']);
                    $price->setPrice($item['price']);
                    
                    // Insere o objeto Price dentro do array.
                    $array[] = $price;
                }
            }
            
            // Retornará o array, após todas as suas propriedades do objeto Price serem definidas.
            return $array;
        }
        
        /** Responsável por atualizar o preço do produto no Banco de Dados.
         * Retorna um boolean (true) em caso de sucesso.
         * @param Price $price
         * @return bool
         */
        public function update(Price $price): bool
        {
            $sql = $this->pdo->prepare("UPDATE price SET price = :price WHERE id = :id");
            $sql->bindValue(":price", $price->getPrice());
            $sql->bindValue(":id", $price->getId());
            $sql->execute();
            
            return true;
        }
        
        /** Responsável por deletar o preço do produto do Banco de Dados, usada internamente pelo objeto Produto.
         * Não retorna nada.
         * @param $id
         * @return void
         */
        public function delete($id): void
        {
            $sql = $this->pdo->prepare("DELETE FROM price WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
    }