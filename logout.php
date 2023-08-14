<?php
session_start();

// Encerra a sessão
if (isset($_POST['logout'])) {
    // Encerra a sessão
    session_unset();
    session_destroy();

    // Redireciona para a página de login
    header("Location: login.html");
    exit();
} else {
    echo "Erro ao tentar fazer logout.";
}
?>
