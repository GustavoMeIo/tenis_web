<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: login.html"); // Redireciona para a página de login
    exit();
}

$hostname = "127.0.0.1";
$port = "3306";
$username = "root";
$password = "";
$dbname = "trafego";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tenis_web";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="UTF-8">

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <title>Homepage</title>
</head>

<body>
    <h1>Tabela de Dados</h1>

    <!-- Botão de Logout -->
    <form action="logout.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Senha</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['login']; ?></td>
                <td><?php echo $row['senha']; ?></td>
                <td><?php echo $row['nivel_seg']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>

<?php
mysqli_close($conn);
?>
