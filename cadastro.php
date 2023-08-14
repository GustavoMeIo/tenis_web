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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os valores do formulário
    $email = $_POST['email'];
	$login = $_POST['login'];
	$password = $_POST['password'];

    $sql = "INSERT INTO tenis_web (email, login, senha) VALUES ('$email', '$login', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: login.html");
    } else {
        header("Location: cadastro.html");
    }
}

echo "ainda não";

// Fecha a conexão
mysqli_close($conn);
