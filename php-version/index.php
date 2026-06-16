<?php
session_start();

// Inicializar jogo se não existir
if (!isset($_SESSION['jogo'])) {
    $_SESSION['jogo'] = [
        'palavras' => ['PHP', 'JAVASCRIPT', 'PROGRAMACAO'],
        'palavra_secreta' => 'PHP',
        'letras_reveladas' => ['_', '_', '_'],
        'tentativas' => 0,
        'max_tentativas' => 6
    ];
}

// Processar letra (VALIDAÇÃO)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['letra'])) {
    $letra = strtoupper(trim($_POST['letra']));
    $jogo = &$_SESSION['jogo'];
    
    // VALIDAÇÃO: Verificar se a letra existe na palavra
    $posicoes = array_keys(array_intersect(
        str_split($jogo['palavra_secreta']), 
        [$letra]
    ));
    
    if (!empty($posicoes)) {
        foreach ($posicoes as $pos) {
            $jogo['letras_reveladas'][$pos] = $letra;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Jogo da Forca - PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Jogo da Forca - PHP</h1>
        <div class="palavra">
            <?php foreach ($_SESSION['jogo']['letras_reveladas'] as $letra): ?>
                <span class="letra"><?= $letra ?></span>
            <?php endforeach; ?>
        </div>
        <form method="POST">
            <input type="text" name="letra" maxlength="1">
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>