<?php
session_start();

// Inicializar jogo se não existir
if (!isset($_SESSION['jogo'])) {
    $_SESSION['jogo'] = [
        'palavras' => ['PHP', 'JAVASCRIPT', 'PROGRAMACAO', 'BANCO', 'SISTEMA'],
        'palavra_secreta' => '',
        'letras_reveladas' => [],
        'tentativas' => 0,
        'max_tentativas' => 6,
        'letras_erradas' => [],
        'jogo_terminou' => false
    ];
}

// Função para iniciar novo jogo
function iniciarNovoJogo() {
    $jogo = &$_SESSION['jogo'];
    $palavra = $jogo['palavras'][array_rand($jogo['palavras'])];
    $jogo['palavra_secreta'] = $palavra;
    $jogo['letras_reveladas'] = array_fill(0, strlen($palavra), '_');
    $jogo['tentativas'] = 0;
    $jogo['letras_erradas'] = [];
    $jogo['jogo_terminou'] = false;
}

// Processar letra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['letra'])) {
    $letra = strtoupper(trim($_POST['letra']));
    $jogo = &$_SESSION['jogo'];
    
    if (!$jogo['jogo_terminou'] && !in_array($letra, $jogo['letras_erradas'])) {
        $posicoes = array_keys(array_intersect(
            str_split($jogo['palavra_secreta']), 
            [$letra]
        ));
        
        if (!empty($posicoes)) {
            foreach ($posicoes as $pos) {
                $jogo['letras_reveladas'][$pos] = $letra;
            }
        } else {
            $jogo['letras_erradas'][] = $letra;
            $jogo['tentativas']++;
        }
        
        // Verificar vitória
        if (!in_array('_', $jogo['letras_reveladas'])) {
            $jogo['jogo_terminou'] = true;
            $jogo['resultado'] = 'VITORIA';
        }
        
        // Verificar derrota
        if ($jogo['tentativas'] >= $jogo['max_tentativas']) {
            $jogo['jogo_terminou'] = true;
            $jogo['resultado'] = 'DERROTA';
        }
    }
}

// Iniciar jogo se não tiver palavra
if (empty($_SESSION['jogo']['palavra_secreta'])) {
    iniciarNovoJogo();
}

// Reiniciar jogo
if (isset($_GET['reiniciar'])) {
    iniciarNovoJogo();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo da Forca - PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>🐘 Jogo da Forca - PHP</h1>
        
        <div class="game-area">
            <!-- Status do jogo -->
            <div class="status">
                <p>Tentativas: <?= $_SESSION['jogo']['tentativas'] ?> / <?= $_SESSION['jogo']['max_tentativas'] ?></p>
                <p>Letras erradas: <?= implode(', ', $_SESSION['jogo']['letras_erradas']) ?></p>
            </div>
            
            <!-- Palavra oculta -->
            <div class="palavra">
                <?php foreach ($_SESSION['jogo']['letras_reveladas'] as $letra): ?>
                    <span class="letra"><?= $letra ?></span>
                <?php endforeach; ?>
            </div>
            
            <!-- Formulário para enviar letra -->
            <?php if (!$_SESSION['jogo']['jogo_terminou']): ?>
                <form method="POST" class="input-area">
                    <input type="text" name="letra" maxlength="1" required 
                           placeholder="Digite uma letra" pattern="[A-Za-z]">
                    <button type="submit">Enviar</button>
                </form>
            <?php else: ?>
                <div class="resultado <?= $_SESSION['jogo']['resultado'] ?>">
                    <?php if ($_SESSION['jogo']['resultado'] === 'VITORIA'): ?>
                        🎉 Parabéns! Você venceu!
                    <?php else: ?>
                        💀 Você perdeu! A palavra era: <?= $_SESSION['jogo']['palavra_secreta'] ?>
                    <?php endif; ?>
                </div>
                <a href="?reiniciar=1" class="btn-reiniciar">🔄 Novo Jogo</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>