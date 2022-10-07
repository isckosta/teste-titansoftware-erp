<?php
    
    use dao\PriceDAOMySQL;
    use dao\ProductDAOMySQL;
    
    require "config.php";
    require "dao/ProductDAOMySQL.php";
    require "dao/PriceDAOMySQL.php";
    
    /* Se o objeto PDO estiver preenchido o objecto ProductDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $productDao = new ProductDAOMySQL($pdo);
    
    /* Se o objeto PDO estiver preenchido o objecto PriceDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $priceDao = new PriceDAOMySQL($pdo);
    
    $productId = filter_input(INPUT_GET, "id");
    $priceId = filter_input(INPUT_GET, "p");
    
    if ($productId) {
        
        // Se o objeto ProductDAOMySQL estiver preenchido, então será feita a exclusão do produto corretamente.
        if (!empty($productDao)) $productDao->delete($productId);
        
        // Se o objeto PriceDAOMySQL estiver preenchido, então será feita a exclusão do price relacionado ao produto corretamente.
        if (!empty($priceDao)) $priceDao->delete($priceId);
    }
    
    // Se a URL base do sistema tiver configurada, então após a edição do produto o usuário será redirecionado para a página inicial.
    if (!empty($base)) header("Location: " . $base);
    exit;