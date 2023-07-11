<?php
// Configurações do banco de dados
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "projeto";

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os valores enviados pelo formulário
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Criar uma conexão com o banco de dados
    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // Verificar se houve um erro na conexão
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consultar o banco de dados para verificar as credenciais de login
    $query = "SELECT * FROM motorista WHERE usuario_cliente = '$username'";
    $result = $conn->query($query);

    // Verificar se foi encontrada uma linha correspondente
    if ($result->num_rows == 1) {
        // Obter os dados do usuário
        $row = $result->fetch_assoc();
        $hashedSenha = $row["senha_cliente"];

        // Verificar se a senha corresponde ao hash
        if (password_verify($password, $hashedSenha)) {
            // Login bem-sucedido
            // Redirecionar para a página do usuário
            header("Location: tela_cliente.php");
            exit();
        }
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007bff;
            cursor: pointer;
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
            width: 50%;
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
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="formulario">
            <label for="username" class="formulario">Email:</label><br>
            <input type="text" name="username" class="campos" required><br>
            <label for="password" class="formulario">Senha:</label><br>
            <input type="password" name="password" id="senha" class="campos" onkeypress="permitirApenasNumeros(event)" required><br>
            <input type="checkbox" id="mostrar"> Mostrar senha<br>
            <input type="submit" value="Login" class="btnEnvio">
            <p>Não tem conta? <a href="cadastro.php">Crie uma!</a></p>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<p class="error-message">Nome de usuário ou senha incorretos!</p>';
        }
        ?>
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