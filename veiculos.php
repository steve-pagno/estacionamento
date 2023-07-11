<?php
session_start();

// Verifica se o formulário foi enviado
if (isset($_POST['buscar'])) {
    // Configurações do banco de dados
    $servername = "localhost";
    $port = "3306";
    $username = "root";
    $password = "";
    $dbname = "projeto";

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Dados do cliente para busca
    $cpf = $_POST['cpf_busca'];

    // Consulta para buscar os veículos do cliente pelo CPF
    $sql = "SELECT * FROM veiculo WHERE cpf_cliente='$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $veiculos = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $veiculos = [];
        veiculo1();
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}

// Verifica se o formulário foi enviado para excluir o veículo
if (isset($_POST['excluir'])) {
    // Configurações do banco de dados
    $servername = "localhost";
    $port = "3306";
    $username = "root";
    $password = "";
    $dbname = "projeto";

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Dados do veículo a ser excluído
    $excluirPlaca = $_POST['placa'];

    // Consulta para excluir o veículo
    $sql = "DELETE FROM veiculo WHERE placa='$excluirPlaca'";

    if ($conn->query($sql) === TRUE) {
        veiculo();
    } else {
        echo "Erro ao excluir o veículo: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"
        defer></script>
    <title>Consulta de Veículos</title>
    <style>
        a {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }
    </style>
</head>

<body class="container">
    <h2>Consulta de Veículos</h2>
    <form method="post" action="" class="form-label">
        <div class="mb-3">
            <label for="cpf_busca" class="form-label">Digite o CPF do cliente:</label>
            <input type="text" name="cpf_busca" id="cpf_busca" class="form-control" onclick="validarInputCPF()"
                required><br><br>
        </div>
        <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
    </form>

    <?php if (!empty($veiculos)): ?>
        <h2>Veículos cadastrados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td>
                            <?php echo $veiculo['placa']; ?>
                        </td>
                        <td>
                            <?php echo $veiculo['marca']; ?>
                        </td>
                        <td>
                            <?php echo $veiculo['modelo']; ?>
                        </td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="placa" value="<?php echo $veiculo['placa']; ?>">
                                <input type="submit" name="excluir" value="Excluir" class="btn btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir o veículo?')">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php
    function veiculo()
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
        echo '                <p>Veículo excluído com sucesso!</p>';
        echo '            </div>';
        echo '            <div class="modal-footer">';
        echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
        echo '                <button type="button" name="excluir" class="btn btn-danger" id="confirmar"><a href="tela_cliente.php">Tela inicial</a></button>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }

    function veiculo1()
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
        echo '                <p>Não há veículos cadastrados para o CPF informado!</p>';
        echo '            </div>';
        echo '            <div class="modal-footer">';
        echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
        echo '                <button type="button" name="excluir" class="btn btn-danger" id="confirmar"><a href="cadastro_veiculo.php">Cadastrar veículo</a></button>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
    ?>
</body>

</html>