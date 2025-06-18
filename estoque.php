<?php
session_start();

// Verifica se existem produtos cadastrados na sessão
$products = $_SESSION["products"] ?? [];

// Processa a exclusão de produto
if (($_POST["action"] ?? "") === "delete" && isset($_POST["product_index"])) {
    $index = (int)$_POST["product_index"];
    if (isset($products[$index])) {
        unset($products[$index]);
        // Reindexar o array para evitar índices vazios
        $products = array_values($products);
        $_SESSION["products"] = $products;
        // Redirecionar para evitar reenvio do formulário
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }
}

// Processa o filtro por lote
$filtered_products = $products;
$lote_filter = $_GET["lote_filter"] ?? "";

if (!empty($lote_filter)) {
    $filtered_products = array_filter($products, function ($product) use ($lote_filter) {
        return isset($product["Lote"]) && $product["Lote"] == $lote_filter;
    });
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="estoque.css">
    <script src="estoque.js"></script>
</head>

<body>
    <div class="header">
        <h1>Estoque de Produtos</h1>
        <a href="escolha.html" class="exit-btn">Exit</a>
    </div>

    <hr>

    <div class="filter-form">
        <form method="GET" action="estoque.php">
            <label for="lote_filter">Lote:</label>
            <input type="text" id="lote_filter" name="lote_filter" value="<?php echo htmlspecialchars($lote_filter); ?>">
            <button type="submit" class="filter">Filtrar</button>
        </form>
    </div>

    <?php if (empty($filtered_products)): ?>
        <div class="no-products">
            <p>Nenhum produto encontrado com o lote ou nenhum produto cadastrado ainda.</p>
            <a href="cadastro.html" class="add-product-btn">Cadastrar Produto</a>
        </div>
    <?php else: ?>
        <div class="filter-form">
            <label>Filtrar por Status:</label>
            <button type="button" class="status-filter-btn" data-status="all">Todos</button>
            <button type="button" class="status-filter-btn" data-status="green"></button>
            <button type="button" class="status-filter-btn" data-status="yellow">Amarelo</button>
            <button type="button" class="status-filter-btn" data-status="red">Vermelho</button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Data de Fabricação</th>
                        <th>Data de Validade</th>
                        <th>Dias Restantes</th>
                        <th>Lote</th>
                        <th>Status</th>
                        <th class="actions-column">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtered_products as $index => $product): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($product["Imagem"]); ?>" alt="Imagem do Produto" class="product-image" width="100px"></td>
                            <td><?php echo htmlspecialchars($product["Nome"]); ?></td>
                            <td>
                                <?php
                                $description = htmlspecialchars($product["Descrição"]);
                                $limit = 75;
                                if (strlen($description) > $limit) {
                                    echo
                                    '<span class="description-short">' . substr($description, 0, $limit) . '...</span>' .
                                        '<span class="description-full" style="display:none;">' . $description . '</span>' .
                                        '<button class="toggle-description-btn" onclick="toggleDescription(this)">Mostrar Mais</button>';
                                } else {
                                    echo $description;
                                }
                                ?>
                            </td>
                            <td><?php echo date("d/m/Y", strtotime($product["Fabrication_Date"])); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($product["Data"])); ?></td>
                            <td>
                                <?php
                                $today = new DateTime();
                                $expiration_date = new DateTime($product["Data"]);
                                $interval = $today->diff($expiration_date);
                                $days_remaining = $interval->days;

                                if ($expiration_date < $today) {
                                    echo "Expirado há " . $days_remaining . " dias";
                                } else {
                                    echo $days_remaining . " dias";
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($product["Lote"] ?? ""); ?></td>
                            <td>
                                <?php
                                $status_class = "status-green"; // Padrão verde
                                if ($expiration_date < $today) {
                                    $status_class = "status-red"; // Expirado
                                } elseif ($days_remaining <= 10) {
                                    $status_class = "status-red"; // 10 dias ou menos
                                } elseif ($days_remaining <= 35) {
                                    $status_class = "status-yellow"; // 35 dias ou menos
                                }
                                ?>
                                <div class="status-indicator <?php echo $status_class; ?>"></div>
                            </td>
                            <td class="actions-column">
                                <form method="POST" class="delete-form" onsubmit="return confirmDelete(<?php echo json_encode($product['Nome']); ?>)">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="product_index" value="<?php echo $index; ?>">
                                    <button type="submit" class="delete-btn">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="cadastro.html" class="add-product-btn">Cadastrar Novo Produto</a>
    <?php endif; ?>
</body>

</html>