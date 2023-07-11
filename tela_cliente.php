<!DOCTYPE html>
<html>

<head>
    <title>Opções do Cliente</title>
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
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border-radius: 10px;
            border: none;
            color: #fff;
            cursor: pointer;
            margin-top: 10px;
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
    <div class="container">
        <h1>Opções do Cliente</h1>
        <h2>Bem-vindo!
        </h2>
        <p>Escolha uma das opções abaixo:</p>
        <button class="btnEnvio"><a href="cadastro_veiculo.php">Cadastrar Veículo</a></button>
        <button class="btnEnvio"><a href="alocacao.php">Alocar vaga</a></button>
        <button class="btnEnvio"><a href="cadastro_cliente.php">Consultar cadastro</a></button>
        <button class="btnEnvio"><a href="veiculos.php">Consultar veículos cadastrados</a></button>
    </div>
</body>

</html>