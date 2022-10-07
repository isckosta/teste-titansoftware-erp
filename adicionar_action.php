<?php
    
    use dao\PriceDAOMySQL;
    use dao\ProductDAOMySQL;
    use models\Price;
    use models\Product;
    
    require "config.php";
    require "dao/ProductDAOMySQL.php";
    require "dao/PriceDAOMySQL.php";
    
    /* Se o objeto PDO estiver preenchido o objecto ProductDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $productDao = new ProductDAOMySQL($pdo);
    
    /* Se o objeto PDO estiver preenchido o objecto PriceDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $priceDao = new PriceDAOMySQL($pdo);
    
    // Campos visíveis de entrada para inserção de informações do Produto pelo usuário.
    $inputPostName = filter_input(INPUT_POST, 'name');
    $inputPostColor = filter_input(INPUT_POST, 'color');
    $inputPostPrice = filter_input(INPUT_POST, "price");
    
    if ($inputPostName && $inputPostColor && $inputPostPrice) {
        
        // Inicialização do objeto Price para definição das propriedades do objeto.
        $price = new Price();
        $price->setPrice($inputPostPrice);
        
        // Inicialização do objeto Product para definição das propriedades do objeto.
        $product = new Product();
        $product->setName($inputPostName);
        $product->setColor($inputPostColor);
        $product->setPrice($price);
        
        // Se o objeto ProductDAOMySQL estiver preenchido, então o produto será inserido.
        if (!empty($priceDao)) $priceDao->create($price);
        
        // Se o objeto ProductDAOMySQL estiver preenchido, então o preço do produto será inserido ao produto relacionado.
        if (!empty($productDao)) $productDao->create($product, $price);
        
        // Se a URL base do sistema tiver configurada, então após a edição do produto o usuário será redirecionado para a página inicial.
        if (!empty($base)) header("Location: " . $base);
    
    } else {
        // Se a URL base do sistema tiver configurada, então após a edição do produto o usuário será redirecionado para a página inicial.
        if (!empty($base)) header("Location:  " . $base . "/adicionar.php");
    }
    exit;

