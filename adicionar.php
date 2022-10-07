<?php require "partials/header.php"?>
    <form method="POST" action="adicionar_action.php">
        <h1>Cadastrar produto</h1>
        <br>
        <p>Por favor, preencha os dados a seguir para cadastrar um produto.</p>
        <br>
        <hr>
        <br>
        <div class="input">
            <label for="name"><b>Nome: </b></label>
            <input class="inputText" type="text" placeholder="Nome do produto" name="name" id="name" required>
        </div>
        <br>
       <div class="input">
            <label for="color"><b>Cor: </b></label>
            <select class="selectInput" id="color" name="color" required>
              <option value="">Selecione</option>
              <option value="azul">Azul</option>
              <option value="vermelho">Vermelho</option>
              <option value="amarelo">Amarelo</option>
            </select>
       </div>
        <br>
        <div class="input">
            <label for="price"><b>Preço: </b></label>
            <input class="inputText" type="text" placeholder="Digite o preço do produto" name="price" id="price" required>
       </div>
        <br>
        <button type="submit" class="registerbtn">Cadastrar</button>
    </form>
    <br>
    <hr>
<?php require "partials/footer.php"?>