# 🎯 Jogo da Forca - PHP vs JavaScript

## 📋 Sobre o Projeto

Este projeto apresenta duas implementações completas do clássico **Jogo da Forca**, desenvolvidas com abordagens diferentes:

- **🐘 PHP (Server-Side)**: Lógica executada no servidor com sessões
- **🟨 JavaScript (Client-Side)**: Lógica executada no navegador com manipulação DOM

## 🎮 Funcionalidades

### Ambas as versões oferecem:
- ✅ Palavras aleatórias
- ✅ Validação de letras
- ✅ Sistema de tentativas (6 chances)
- ✅ Tratamento de vitória/derrota
- ✅ Reiniciar jogo
- ✅ Interface UI amigável

### Diferenciais de cada versão:

| Funcionalidade | PHP | JavaScript |
|----------------|-----|------------|
| Processamento | Servidor | Navegador |
| Feedback | Page reload | Instantâneo |
| Teclado Virtual | ❌ | ✅ |
| Segurança | Alta | Baixa |
| Dados | Protegidos | Expostos |

## 🚀 Como Executar

### Versão PHP
```bash
# 1. Iniciar servidor PHP
php -S localhost:8000

# 2. Acessar no navegador
http://localhost:8000/php-version/index.php
