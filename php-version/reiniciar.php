<?php
session_start();

// Reiniciar o jogo com uma nova palavra aleatória
if (isset($_SESSION['jogo'])) {
    $palavras = $_SESSION['jogo']['palavras'];
    $nova_palavra = $palavras[array_rand($palavras)];
    
    $_SESSION['jogo'] = [
        'palavras' => $palavras,
        'palavra_secreta' => $nova_palavra,
        'letras_reveladas' => array_fill(0, strlen($nova_palavra), '_'),
        'tentativas' => 0,
        'max_tentativas' => 6,
        'letras_erradas' => []
    ];
}

header('Location: index.php');
exit;
?>