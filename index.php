<?php
// Inicia a sessão PHP para gerenciar dados do usuário entre páginas
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruby tintas aeronáuticas - Login</title>
    <!-- Importação do arquivo CSS para estilização da página -->
    <link rel="stylesheet" href="welcome.css">
</head>
<body>
    <!-- Elementos decorativos para melhorar a aparência visual -->
    <div class="decoration"></div>
    <div class="decoration"></div>

    <!-- Marca AEROLAB no topo da página -->
    <h1 class="marca">RUBY</h1>
    <h4 class="submarca">TINTAS AERONÁUTICAS</h4>

    <!-- Área central contendo o formulário de login -->
    <div class="central">
        <?php
        // Verifica se existe uma mensagem de erro de login na sessão
        $showError = isset($_SESSION['login_error']);
        ?>

        <?php if ($showError): ?>
            <!-- Exibe a mensagem de erro caso exista -->
            <div class="error-message">
                <?= $_SESSION['login_error'] ?>
            </div>
            <?php 
            // Remove a mensagem de erro da sessão após exibi-la
            // Isso evita que a mensagem apareça novamente em recarregamentos
            unset($_SESSION['login_error']); 
            ?>
        <?php endif; ?>

        <!-- Formulário de login que envia dados para welcome.php via POST -->
        <form action="welcome.php" method="POST">
            <!-- Campo de entrada para o nome de usuário -->
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" placeholder="Digite seu login">

            <!-- Campo de entrada para a senha -->
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha">
            <br>
            <a href="https://wa.me/5516991486026?text=Ol%C3%A1%2C%20quero%20utilizar%20o%20sistema%20da%20Ruby%20na%20minha%20empresa!%20%F0%9F%98%81", target="_blank">Contato</a>
            <!-- Botão de submissão do formulário -->
            <button type="submit" class="btn">ENTRAR</button>
        </form>
    </div>

    <!-- Rodapé da página com informações da empresa -->
    <div class="footer">
        © 2025 Ruby tintas aeronáuticas - Transformando sua empresa em inovação
    </div>
</body>

</html>