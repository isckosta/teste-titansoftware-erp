<?php
    /**
     * Criado por PhpStorm.
     * Arquivo: editar.php
     * Usuário: Israel Costa
     * Data: 06/10/2022
     * Hora: 14:57
     */
    
    use dao\ProductDAOMySQL;
    use dao\PriceDAOMySQL;
    
    require "config.php";
    require "dao/ProductDAOMySQL.php";
    require "dao/PriceDAOMySQL.php";
    
    /* Se o objeto PDO estiver preenchido o objecto ProductDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $productDao = new ProductDAOMySQL($pdo);
    
    /* Se o objeto PDO estiver preenchido o objecto PriceDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $priceDao = new PriceDAOMySQL($pdo);
    
    $product = false;
    $price = false;
    
    $inputGetProduct = filter_input(INPUT_GET, "id");
    $inputGetPrice = filter_input(INPUT_GET, "p");
    
    if ($inputGetProduct && $inputGetPrice) {
        
        // Se o objeto ProductDAOMySQL estiver preenchido, então o método findById buscará o produto pelo seu ID.
        if (!empty($productDao)) $product = $productDao->findById($inputGetProduct);
    
        // Se o objeto ProductDAOMySQL estiver preenchido, então o método findById buscará o preça relacionado ao produto pelo seu ID.
        if (!empty($priceDao)) $price = $priceDao->findById($inputGetPrice);
        
    }
    
    if ($product === false) {
        
        // Se a URL base do sistema tiver configurada, então após a edição do produto o usuário será redirecionado para a página inicial.
        if (!empty($base)) header("Location: " . $base);
        exit;
        
    }

?>

<?php require "partials/header.php" ?>
<form method="POST" action="editar_action.php">
        <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
        <input type="hidden" name="preco_id" value="<?= $price->getId() ?>">

        <h1>Cadastrar produto</h1>
        <br>
        <p>Por favor, preencha os dados a seguir para cadastrar um produto.</p>
        <br>
        <hr>
        <br>
        <div class="input">
            <label for="name"><b>Nome: </b></label>
            <input class="inputText" type="text" placeholder="Nome do produto" name="name" id="name" value="<?= $product->getName() ?>"
                   required>
        </div>
        <br>
       <div class="input">
            <label for="color"><b>Cor: </b></label>
            <input class="inputText" type="text" placeholder="Digite a cor do produto" name="color" id="color" readonly
                   value="<?= $product->getColor() ?>" required>
       </div>
        <br>
        <div class="input">
            <label for="price"><b>Preço: </b></label>
            <input class="inputText" type="text" placeholder="Digite o preço do produto" name="price" id="price"
                   value="<?= $product->getPrice()->getPrice() ?>" required>
       </div>
        <br>
        <button type="submit" class="registerbtn">Alterar</button>
    </form>
    <br>
    <hr>
    <br>
<?php require "partials/footer.php" ?>
