<?php

use Vtiful\Kernel\Format;
// cadastro.php

session_start();

$name_product    = trim($_POST["name"] ?? '');
$expiration_date = trim($_POST["validity"] ?? '');
$description     = trim($_POST["description"] ?? '');
$fabrication_date = trim($_POST["fabrications"] ?? '');
$fabricate       = trim($_POST["fabricate"] ?? '');
$lote            = trim($_POST["lote"] ?? '');
$unidade         = trim($_POST["unidade"] ?? '');
$successMsg = $errorMsg = "";
$imagePath = '';

// Processar upload da imagem
if (isset($_FILES['image'])){
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = $_FILES['image']['type'];
    
    if (in_array($fileType, $allowedTypes)) {
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $targetPath;
        } else {
            $errorMsg = "Erro ao fazer upload da imagem.";
        }
    } else {
        $errorMsg = "Tipo de arquivo não permitido. Use apenas JPEG, PNG ou GIF.";
    }
}

// Verifica se formulário foi enviado corretamente
if (!empty($name_product) && !empty($expiration_date) && !empty($imagePath)) {
    $products = array(
        "Nome"       => $name_product,
        "Imagem"     => $imagePath,
        "Data"       => $expiration_date,
        "Fabrication_Date"  => $fabrication_date,
        "Fabricante" => $fabricate,
        "Lote"       => $lote,
        "Unidade"    => $unidade,
        "Descrição"  => $description
    );

    // Armazena no array de sessão
    $_SESSION['products'][] = $products;

    $successMsg = "Produto cadastrado com sucesso!";
} elseif (empty($errorMsg)) {
    $errorMsg = "Nome, data de validade e imagem são obrigatórios.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>

    <?php if (!empty($successMsg)): ?>
        <div class="message success">
            <?php echo $successMsg; ?>
            <?php if (!empty($imagePath)): ?>
                <img src="<?php echo $imagePath; ?>" class="product-preview" alt="Preview do Produto">
            <?php endif; ?>
        </div>
    <?php elseif (!empty($errorMsg)): ?>
        <div class="message error"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <div class="back-link">
        <a href="cadastro.html">Voltar ao cadastro</a>
    </div>

</body>
</html>