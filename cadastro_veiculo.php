<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"
        defer></script>
    <script src="js/validarCpfSenha.js" defer></script>
    <title>Cadastro de Veículo</title>
    <style>
        a {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1;
        }

        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .formulario {
            font-weight: bold;
        }

        .campos {
            width: 75%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btnEnvio {
            width: 25%;
            padding: 10px;
            background-color: #007bff;
            border-radius: 10px;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        .btnEnvio:hover {
            background-color: #0069d9;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php
    // Dados de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projeto";

    // Conectando ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Processamento do formulário de cadastro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $placa = $_POST["placa"];
        $cpf = $_POST["cpf"];

        // Inserindo os dados no banco de dados
        $sql = "INSERT INTO veiculo (marca, modelo, placa, cpf_cliente) VALUES ('$marca', '$modelo', '$placa', '$cpf')";

        if ($conn->query($sql) === TRUE) {
            cadastroVeiculo();
        } else {
            echo "Erro ao cadastrar veículo: " . $conn->error;
        }
    }

    // Fechando a conexão com o banco de dados
    $conn->close();
    ?>
    <div class="container">
        <h2>Cadastro de Veículo</h2>
        <form class="formulario" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="marca" class="formulario">Marca:</label><br>
            <input class="campos" type="text" id="marca" name="marca" required><br>

            <label for="modelo" class="formulario">Modelo:</label><br>
            <input class="campos" type="text" id="modelo" name="modelo" required><br>

            <label for="placa" class="formulario">Placa:</label><br>
            <input class="campos" type="text" id="placa" name="placa" required><br>

            <label for="cpf" class="formulario">CPF do Motorista:</label><br>
            <input class="campos" type="text" id="cpf" name="cpf" required><br>

            <input type="submit" value="Cadastrar" class="btnEnvio" onclick="validarInputCPF()">
        </form>
    </div>
    <?php
    function cadastroVeiculo()
    {
        echo '<script>';
        echo '    document.addEventListener("DOMContentLoaded", function() {';
        echo '        const myModal = new bootstrap.Modal(document.getElementById("exampleModal"));';
        echo '        const myInput = document.getElementById("myInput");';
        echo '';
        echo '        myModal.show();';
        echo '        myInput.focus();';
        echo '    });';
        echo '</script>';
        echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        echo '    <div class="modal-dialog">';
        echo '        <div class="modal-content">';
        echo '            <div class="modal-header">';
        echo '                <h1 class="modal-title fs-5" id="exampleModalLabel">Sucesso!</h1>';
        echo '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '            </div>';
        echo '            <div class="modal-body">';
        echo '                <p>Veículo cadastrado com sucesso!</p>';
        echo '            </div>';
        echo '            <div class="modal-footer">';
        echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
        echo '                <button type="button" name="excluir" class="btn btn-danger" id="confirmar"><a href="tela_cliente.php">Tela Inicial</a></button>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
    ?>
</body>

</html>