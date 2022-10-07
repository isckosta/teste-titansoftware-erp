<?php
    
    use dao\PriceDAOMySQL;
    use dao\ProductDAOMySQL;
    use models\Product;
    use models\Price;
    
    require "config.php";
    require "dao/ProductDAOMySQL.php";
    require "dao/PriceDAOMySQL.php";
    
    /* Se o objeto PDO estiver preenchido o objecto ProductDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $productDAO = new ProductDAOMySQL($pdo);
    
    /* Se o objeto PDO estiver preenchido o objecto PriceDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $priceDAO = new PriceDAOMySQL($pdo);
    
    /* Todos os nomes de variávels seguem o padrão de convenção da Programação Orientada à Objetos, exceto os campos de atributos de elementos HTML e colunas de Banco de Dados. */
    
    // Campos ocultos para manipulação dos dados de Produto e Preço.
    $inputHiddenProductId = filter_input(INPUT_POST, "product_id");
    $inputHiddenPriceId = filter_input(INPUT_POST, "preco_id");
    
    // Campos visíveis de entrada para inserção de informações de edição do Produto pelo usuário.
    $inputProductName = filter_input(INPUT_POST, 'name');
    $inputColor = filter_input(INPUT_POST, 'color');
    $inputPrice = filter_input(INPUT_POST, 'price');
    
    if ($inputHiddenProductId && $inputHiddenPriceId && $inputProductName && $inputColor && $inputPrice) {
        
        // Inicialização do objeto Price para definição das propriedades do objeto.
        $price = new Price();
        $price->setId($inputHiddenPriceId);
        $price->setPrice($inputPrice);
        
        // Inicialização do objeto Product para definição das propriedades do objeto.
        $product = new Product();
        $product->setId($inputHiddenProductId);
        $product->setName($inputProductName);
        $product->setColor($inputColor);
        $product->setPrice($price);
        
        // Se o objeto ProductDAOMySQL estiver preenchido, então será feita a edição do produto corretamente.
        if (isset($productDAO)) $productDAO->update($product);
        
        // Se o objeto PriceDAOMySQL estiver preenchido, então será feita a edição do price relacionado ao produto corretamente.
        if (isset($priceDAO)) $priceDAO->update($price);
        
        // Se a URL base do sistema tiver configurada, então após a edição do produto o usuário será redirecionado para a página inicial.
        if (!empty($base)) header("Location: " . $base);
    
    } else {
    
        // Se a URL base do sistema tiver configurada, então após a edição do produto o usuário será redirecionado para a página inicial.
        if (!empty($base)) header("Location:  " . $base . "/editar.php?id=" . $inputHiddenProductId);
    }
    exit;
