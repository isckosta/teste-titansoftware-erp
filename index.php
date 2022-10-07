<?php
    
    require "partials/header.php";
    require "dao/ProductDAOMySQL.php";
    require "dao/PriceDAOMySQL.php";
    
    use dao\ProductDAOMySQL;
    use dao\PriceDAOMySQL;
    
    /* Se o objeto PDO estiver preenchido o objecto ProductDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $productDao = new ProductDAOMySQL($pdo);
    
    /* Se o objeto PDO estiver preenchido o objecto PriceDAOMySQL será inicializado recebendo a instância do PDO como argumento do construtor. */
    if (!empty($pdo)) $priceDao = new PriceDAOMySQL($pdo);
    
    /* Se o objeto PDO estiver preenchido o objecto método findAll() será chamado para exibir todos os resultados encontrados. */
    if (!empty($productDao)) $products = $productDao->findAll();
    
    $operator = @$_GET['operator'];
    $value = @$_GET['value'];
    $sortName = @$_GET['sort'];
    $orderSort = @$_GET['order_sort'];
    
    if (isset($orderSort) || isset($sortName) || isset($operator) || isset($value)) {
        
        // Filtro para trazer os produtos que forem maior que o valor informado no input
        if ($operator == 'bigger_then') {
            $operator = ">";
            
            // Filtro para trazer os produtos que forem igual ao valor informado no input
        } elseif ($operator == 'equal_to') {
            $operator = "=";
            
            // Filtro para trazer os produtos que forem menor que o valor informado no input
        } else {
            $operator = "<";
        }
        
        // Se ocorrer tudo bem, o sistema irá montar a query correta para ordenar os resultados
        if (!empty($productDao)) $products = $productDao->sort($operator, $value, $sortName, $orderSort);
    }

?>
<h1>Lista de produtos cadastrados no sistema</h1>
<br>
<hr>
<br>
<div class="sort">
    <form action="<?= $_SERVER['PHP_SELF'] ?>">
        <label for="sort"> Classificar por: </label>
        <select class="selectFilter" id="sort" name="sort" required">
          <option value="">Selecione</option>
          <option value="name" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'name') {
              echo "selected";
          } ?>>Nome</option>
          <option value="color" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'color') {
              echo "selected";
          } ?>>Cor</option>
          <option value="price" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price') {
              echo "selected";
          } ?>>Preço</option>
        </select>
        <label for="order_sort">Ordem: </label>
        <select class="selectFilter" name="order_sort" id="order_sort" required>
            <option value="">Selecione</option>
            <option value="asc" <?php if (isset($_GET['order_sort']) && $_GET['order_sort'] == 'asc') {
                echo "selected";
            } ?>>Ascendente</option>
            <option value="desc" <?php if (isset($_GET['order_sort']) && $_GET['order_sort'] == 'desc') {
                echo "selected";
            } ?>>Decrescente</option>
        </select>
        <label for="operator">Por valor: </label>
        <select class="selectFilter" name="operator" id="operator">
            <option value="default">Selecione</option>
            <option value="bigger_then" <?php if (isset($_GET['operator']) && $_GET['operator'] == 'bigger_then') {
                echo "selected";
            } ?>>Maior que: </option>
            <option value="equal_to" <?php if (isset($_GET['operator']) && $_GET['operator'] == 'equal_to') {
                echo "selected";
            } ?>>Igual a: </option>
            <option value="less_then" <?php if (isset($_GET['operator']) && $_GET['operator'] == 'less_then') {
                echo "selected";
            } ?>>Menor que: </option>
        </select>
        <input class="inputFilter" type="text" id="value" name="value" placeholder="Digite o valor do produto">
        <button class="btnSendFilter" type="submit">Enviar</button>
    </form>
</div>
<br>
<hr>
<br>
<table class="table_products">
  <tr>
    <th>Código</th>
    <th>Nome</a></th>
    <th>Cor</th>
    <th>Preço original</th>
    <th>Desconto (R$)</th>
    <th>Preço com desconto</th>
    <th>Ações</th>
  </tr>
    <?php if (!empty($products)) {
        foreach ($products as $product): ?>
            <?php
            // Calcula o desconto baseado no preço original do produto.
            $productPriceWithDiscount = calculateDiscountAccordingToColor($product->getPrice()->getPrice(), strtolower($product->getColor()));
            // Pega o valor do produto atual
            $productPrice = $product->getPrice()->getPrice();
            // Formata o valor do produto para a moeda Real (R$)
            $productPriceFormatted = formatMoney($productPrice);
            ?>
            <tr>
            <td><?= $product->getId() ?></td>
            <td><?= $product->getName(); ?></td>
            <td style="font-weight: bold; color: <?= showColor($product->getColor()); ?>"><?= $product->getColor() ?></td>
            <td>R$ <?= $productPriceFormatted ?></td>
            <td>R$ <?= formatMoney($productPriceWithDiscount); ?></td>
            <td>R$ <?= formatMoney($productPrice - $productPriceWithDiscount); ?></td>
            <td>
                <a class="btnExcluir"
                   href="excluir.php?id=<?= $product->getId() ?>&p=<?= $product->getPrice()->getId() ?>"
                   onclick="return confirm('Você tem certeza que deseja excluir esse produto?');">Excluir</a>
                <a class="btnEditar"
                   href="editar.php?id=<?= $product->getId() ?>&p=<?= $product->getPrice()->getId() ?>">Editar</a>
            </td>
          </tr>
        <?php endforeach;
    } else echo "<td colspan='25' style='text-align: center; vertical-align: middle;'>Nenhum produto encontrado.</td>" ?>
</table>
<br>
<hr>
<?php require "partials/footer.php" ?>

