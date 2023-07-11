<?php
// Dados do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtendo os dados do formulário
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

// Verificando se os campos obrigatórios estão preenchidos
if ($nome !== '' && $cpf !== '' && $usuario !== '' && $senha !== '') {
    // Gerando o hash da senha
    $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);

    // Preparando a consulta SQL com statement
    $stmt = $conn->prepare("INSERT INTO motorista (nome_cliente, cpf_cliente, usuario_cliente, senha_cliente) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $cpf, $usuario, $hashedSenha);

    // Executando a consulta preparada
    if ($stmt->execute()) {
        aviso();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    // Fechando a consulta preparada
    $stmt->close();
}

// Fechando a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"
        defer></script>
    <script src="js/validarCpfSenha.js" defer></script>
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
    <title>Cadastro de Motorista</title>
</head>

<body>
    <div class="container">
        <h2>Cadastro de Motorista</h2>
        <form method="POST" class="formulario">
            <label for="nome" class="formulario">Nome do Motorista:</label><br>
            <input type="text" name="nome" id="nome" class="campos" placeholder="Nome completo" required><br>

            <label for="cpf" class="formulario">CPF:</label><br>
            <input type="text" name="cpf" id="cpf" class="campos" placeholder="Ex.: 12345678900" required><br>

            <label for="usuario" class="formulario">Email:</label><br>
            <input type="email" name="usuario" id="usuario" class="campos" placeholder="nome@gmail.com" required><br>

            <label for="senha" class="formulario">Senha:</label><br>
            <input type="password" name="senha" id="senha" class="campos" placeholder="Sua senha (apenas números)" min="4" max="8"
                onkeypress="permitirApenasNumeros(event)" required><br>

            <input type="checkbox" id="mostrar"> Mostrar senha<br>
            <input type="submit" value="Cadastrar" class="btnEnvio" id="btnEnvio" onclick="validarInputCPF()">
            <?php
            function aviso()
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
                echo '                <p>Cadastro realizado com sucesso!</p>';
                echo '            </div>';
                echo '            <div class="modal-footer">';
                echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
                echo '                <button type="button" name="excluir" class="btn btn-danger" id="confirmar"><a href="login.php">Fazer login!</a></button>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </form>
    </div>
    <script>
        //Mostrar senha
        let mostrar1 = document.getElementById('mostrar');
        let passwordInput = document.querySelector('#senha');
        mostrar1.addEventListener('click', function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });

        //permite apenas números na senha
        function permitirApenasNumeros(event) {
            let campo = document.getElementById('senha');
            // Obtém o código da tecla pressionada
            var codigoTecla = event.which || event.keyCode;

            // Verifica se o código da tecla não corresponde a um número
            if (codigoTecla < 48 || codigoTecla > 57) {
                // Impede a entrada da tecla no campo de entrada
                event.preventDefault();
            }
        }
    </script>
</body>

</html>