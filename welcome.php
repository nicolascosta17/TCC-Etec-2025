<?php
// Inicia a sessão para gerenciar dados entre páginas
session_start();

// Recebe os dados do formulário via POST, usando operador null coalescing (??) 
// para definir string vazia como valor padrão caso o campo não exista
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

// Verifica se as credenciais fornecidas correspondem às credenciais válidas
if ($login == "adm" && $password == "123456") {
    // Credenciais corretas: redireciona para a página de escolha de funcionalidades
    header("Location: escolha.html");
    exit; // Interrompe a execução do script após o redirecionamento
} else {
    // Credenciais incorretas: armazena mensagem de erro na sessão
    $_SESSION['login_error'] = "Login ou senha incorretos. Por favor, tente novamente.";
    // Redireciona de volta para a página de login
    header("Location: index.php");
    exit; // Interrompe a execução do script após o redirecionamento
}
?>