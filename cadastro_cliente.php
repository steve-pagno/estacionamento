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

  // Dados do registro a ser buscado
  $cpf = $_POST['cpf_busca'];

  // Consulta para buscar os dados do cliente pelo CPF
  $sql = "SELECT * FROM motorista WHERE cpf_cliente='$cpf'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nome = $row['nome_cliente'];
    $email = $row['usuario_cliente'];
  } else {
    echo "Nenhum registro encontrado com o CPF informado.";
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
}

// Verifica se o formulário foi enviado para atualizar o cadastro
if (isset($_POST['atualizar'])) {
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

  // Dados do registro a ser alterado
  $novoNome = $_POST['nome'];
  $novoCpf = $_POST['cpf'];
  $novoEmail = $_POST['email'];

  // Consulta de atualização
  $sql = "UPDATE motorista SET nome_cliente='$novoNome', cpf_cliente='$novoCpf', usuario_cliente='$novoEmail' WHERE cpf_cliente='$novoCpf'";

  if ($conn->query($sql) === TRUE) {
    alteracao();
  } else {
    echo "Erro ao alterar o cadastro: " . $conn->error;
  }

  // Fecha a conexão com o banco de dados
  $conn->close();
}

// Verifica se o formulário foi enviado para excluir o cadastro
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

  // Dados do registro a ser excluído
  $excluirCpf = $_POST['cpf_busca'];

  // Consulta para excluir o registro
  $sql = "DELETE motorista FROM motorista WHERE cpf_cliente='$excluirCpf'";


  if ($conn->query($sql) === TRUE) {
    $nome = null;
    $cpf = null;
    $email = null;
  } else {
    echo "Erro ao excluir o cadastro: " . $conn->error;
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
  <title>Atualizar Registro</title>
</head>

<body class="container">
  <h2>Atualizar Registro</h2>
  <form method="post" action="" class="form-label">
    <div class="mb-3">
      <label for="cpf_busca" class="form-label">Digite seu CPF:</label>
      <input type="text" name="cpf_busca" id="cpf_busca" class="form-control"
        required><br><br>
    </div>
    <input type="submit" name="buscar" value="Buscar" class="btn btn-primary" >
  </form>

  <?php if (isset($nome)): ?>
    <h2>Atualizar Cadastro</h2>
    <form method="post" action="" class="form-label">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome; ?>" required><br><br>
      </div>
      <div class="mb-3">
        <label for="cpf" class="form-label">CPF:</label>
        <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $cpf; ?>" required><br><br>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required><br><br>
      </div>
      <input type="hidden" name="cpf_busca" value="<?php echo $cpf; ?>">
      <input type="submit" name="atualizar" value="Atualizar" class="btn btn-primary">
      <input type="submit" name="excluir" value="Excluir" class="btn btn-danger"
        onclick="return confirm('Tem certeza que deseja excluir o cadastro?')">
    </form>
  <?php endif; ?>
  <?php
  function alteracao()
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
    echo '                <p>Cadastro alterado com sucesso!</p>';
    echo '            </div>';
    echo '            <div class="modal-footer">';
    echo '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelar">Fechar!</button>';
    echo '                <button type="button" name="excluir" class="btn btn-danger" id="confirmar"><a href="tela_cliente.php">Tela inicial</a></button>';
    echo '            </div>';
    echo '        </div>';
    echo '    </div>';
    echo '</div>';
  }
  ?>
</body>

</html>