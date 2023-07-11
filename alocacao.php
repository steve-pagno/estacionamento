<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"
        defer></script>
    <title>Alocação de Vagas</title>
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

    // Processamento do formulário de alocação/desalocação
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $placa = isset($_POST['placa']) ? $_POST['placa'] : '';
        $vaga = isset($_POST['vaga']) ? $_POST['vaga'] : '';

        // Verificar se o veículo já está alocado
        $sql_check = "SELECT * FROM vaga WHERE placa_veiculo = '$placa' AND dt_saida IS NULL";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // O veículo já está alocado, desalocar a vaga
            $sql_update = "UPDATE vaga SET dt_saida = CURRENT_TIMESTAMP WHERE placa_veiculo = '$placa'";

            if ($conn->query($sql_update) === TRUE) {
                desalocado();
            } else {
                echo "Erro ao desalocar vaga: " . $conn->error;
            }
        } else {
            // Verificar se há outra vaga já alocada para a placa
            $sql_check_another = "SELECT * FROM vaga WHERE dt_saida = NULL";
            $result_check_another = $conn->query($sql_check_another);

            if ($result_check_another->num_rows != NULL) {
                echo "Essa placa já está alocada em outra vaga. Não é possível alocar mais de uma vaga por vez.";
            } else {
                // O veículo não está alocado, alocar a vaga
                $sql_insert = "INSERT INTO vaga (placa_veiculo, nm_vaga, dt_entrada, dt_saida) VALUES ('$placa', '$vaga', CURRENT_TIMESTAMP, NULL)";

                if ($conn->query($sql_insert) === TRUE) {
                    alocado();
                } else {
                    echo "Erro ao alocar vaga: " . $conn->error;
                }
            }
        }
    }

    // Verificar o status da vaga para exibir o texto do botão
    $placa = $_POST["placa"] ?? "";
    $sql_status = "SELECT * FROM vaga WHERE placa_veiculo = '$placa' AND dt_saida IS NULL";
    $result_status = $conn->query($sql_status);
    $is_allocated = ($result_status->num_rows > 0);

    // Fechando a conexão com o banco de dados
    $conn->close();
    ?>
    <div class="container">
        <h2>Alocação de Vagas</h2>
        <?php if ($is_allocated) { ?>
            <form class="formulario" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="placa" class="formulario">Placa do Veículo:</label><br>
                <input type="text" id="placa" name="placa" class="campos" required value="<?php echo $placa; ?>"><br><br>
                <input type="submit" name="desalocar" value="Desalocar Vaga" class="btnEnvio">
            </form>
        <?php } else { ?>
            <form class="formulario" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="placa" class="formulario">Placa do Veículo:</label><br>
                <input type="text" id="placa" name="placa" class="campos" required value="<?php echo $placa; ?>"><br><br>
                <label for="placa" class="formulario">Número da vaga</label><br>
                <input type="text" id="vaga" name="vaga" class="campos" required><br><br>
                <input type="submit" value="Alocar Vaga" class="btnEnvio">
            </form>
        <?php } ?>
    </div>

    <?php

    function alocado()
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
        echo '                <p>Vaga alocada com sucesso!</p>';
        echo '            </div>';
        echo '            <div class="modal-footer">';
        echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }

    function desalocado()
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
        echo '                <p>Vaga desalocada com sucesso!</p>';
        echo '            </div>';
        echo '            <div class="modal-footer">';
        echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
    ?>
</body>

</html>