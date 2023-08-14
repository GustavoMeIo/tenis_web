<?php
session_start(); // Inicia a sessão

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

// Função para verificar as credenciais e redirecionar
function verificarCredenciais($conn, $login, $password)
{
    $sql = "SELECT * FROM tenis_web WHERE login = '$login' AND senha = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['nivel_seg'] == '1') {
            // Credenciais corretas e nível de acesso é de 'admin' = '1', redireciona para homepage_adm.php
            $_SESSION['usuario_autenticado'] = true; // Marca o usuário como autenticado
            $_SESSION['login_attempts'] = 0; // Reseta o contador de tentativas de login
            header("Location: homepage_adm.php");
            
        } else {
            $_SESSION['usuario_autenticado'] = true; // Marca o usuário como autenticado
            $_SESSION['login_attempts'] = 0; // Reseta o contador de tentativas de login 
            // Credenciais corretas, mas nível de acesso não é 'admin' = '0' redireciona para homepage.php
            header("Location: homepage.php");
        }
    } else {
        // Credenciais incorretas
        $_SESSION['login_attempts']++; // Incrementa o contador de tentativas de login
        $_SESSION['ultimo_login_attempt'] = time(); // Armazena o tempo da última tentativa
        header("Location: login.html");
    }
}

// Verifica o número de tentativas de login e bloqueia temporariamente após um certo limite
if ($_SESSION['login_attempts'] >= 3) {
    $bloqueioTemporario = 60 * 1; // Bloqueio temporário de 5 minutos (em segundos)
    $tempoRestante = $bloqueioTemporario - (time() - $_SESSION['ultimo_login_attempt']);
    if ($tempoRestante > 0) {
        die("Você excedeu o limite de tentativas. Tente novamente após " . $tempoRestante . " segundos.");
    } else {
        // Reset do contador e do tempo de última tentativa
        $_SESSION['login_attempts'] = 0;
        $_SESSION['ultimo_login_attempt'] = 0;

        // Defina um item de sessão JavaScript para mostrar o modal
        $_SESSION['show_modal'] = true; 
        // Defina um item de sessão JavaScript para mostrar o modal
        
    }
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os valores do formulário
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Chama a função para verificar as credenciais e redirecionar
    verificarCredenciais($conn, $login, $password);
}

// Fecha a conexão
mysqli_close($conn);
?>



