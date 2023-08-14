<!DOCTYPE html>
<html lang="UTF-8">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link para o arquivo CSS -->
    <script src="script.js"></script> <!-- Link para o arquivo JS -->

    <!-- links do BootsTrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Fim dos links do BootsTrap -->

    <title>Redefinir Senha</title>
</head>

<body>
    <div class="wrapper">
        <div id="formContent">
            <h1 style="color: #fff;">Redefinir Senha</h1>
            <!-- Reset Form -->
            <form id="resetPasswordForm" method="post" action="resetsenha.php">
                <input type="text" disabled name="novo_email" value="<?php echo $_GET['email']; ?>">
                <input type="hidden" name="novo_email" value="<?php echo $_GET['email']; ?>">
                <input type="password" name="nova_senha" placeholder="Nova Senha" required>
                <input type="password" name="confirmar_nova_senha" placeholder="Confirmar Nova Senha" required>
                <input type="submit" class="btn btn-primary fadeIn fourth" value="Redefinir Senha">
            </form>
        </div>
    </div>
</body>

</html>

<?php
$hostname = "127.0.0.1";
$port = "3306";
$username = "root";
$password = "";
$dbname = "trafego"; // Substitua pelo nome do seu banco de dados

// Conexão com o banco de dados
$conn = mysqli_connect($hostname, $username, $password, $dbname, $port);

// Verifica a conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// var_dump($_POST);
// var_dump($_GET);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["novo_email"]) && isset($_POST["nova_senha"]) && isset($_POST["confirmar_nova_senha"])) {
        $email = $_POST["novo_email"];
        $novaSenha = $_POST["nova_senha"];
        $confirmarNovaSenha = $_POST["confirmar_nova_senha"];

        if ($novaSenha === $confirmarNovaSenha) {
            // Atualiza a senha no banco de dados
            $updateSql = "UPDATE tenis_web SET senha = '$novaSenha' WHERE email = '$email'";
            if (mysqli_query($conn, $updateSql)) {
                echo "Senha atualizada com sucesso!";
                header("Location: login.html");
            } else {
                echo "Erro ao atualizar a senha: " . mysqli_error($conn);
            }
        } else {
            echo "As senhas não coincidem.";
        }
    }
}

// Fecha a conexão
mysqli_close($conn);
?>