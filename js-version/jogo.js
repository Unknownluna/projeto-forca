class JogoForca {
    constructor() {
        this.palavras = ['PHP', 'JAVASCRIPT', 'PROGRAMACAO', 'BANCO', 'SISTEMA'];
        this.maxTentativas = 6;
        this.tentativas = 0;
        this.palavraSecreta = '';
        this.letrasReveladas = [];
        this.letrasErradas = [];
        this.jogoTerminou = false;
        
        this.init();
    }
    
    init() {
        this.selecionarPalavra();
        this.renderizarPalavra();
        this.renderizarTeclado();
        this.atualizarStatus();
        this.ocultarResultado();
        document.getElementById('btnReiniciar').style.display = 'none';
        document.getElementById('btnReiniciar').onclick = () => this.reiniciar();
    }
    
    selecionarPalavra() {
        this.palavraSecreta = this.palavras[Math.floor(Math.random() * this.palavras.length)];
        this.letrasReveladas = Array(this.palavraSecreta.length).fill('_');
        this.tentativas = 0;
        this.letrasErradas = [];
        this.jogoTerminou = false;
    }
    
    renderizarPalavra() {
        const container = document.getElementById('palavra');
        container.innerHTML = this.letrasReveladas.map(letra => 
            `<span class="letra">${letra}</span>`
        ).join('');
    }
    
    renderizarTeclado() {
        const teclado = document.getElementById('teclado');
        const letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        teclado.innerHTML = letras.split('').map(letra => 
            `<button class="tecla" data-letra="${letra}">${letra}</button>`
        ).join('');
        
        // Adicionar eventos
        teclado.querySelectorAll('.tecla').forEach(btn => {
            btn.addEventListener('click', () => {
                this.processarLetra(btn.dataset.letra);
            });
        });
    }
    
    processarLetra(letra) {
        if (this.jogoTerminou) return;
        if (this.letrasErradas.includes(letra)) return;
        if (this.letrasReveladas.includes(letra)) return;
        
        const posicoes = [];
        this.palavraSecreta.split('').forEach((l, i) => {
            if (l === letra) posicoes.push(i);
        });
        
        if (posicoes.length > 0) {
            // Letra correta
            posicoes.forEach(pos => {
                this.letrasReveladas[pos] = letra;
            });
            this.renderizarPalavra();
            
            // Verificar vitória
            if (!this.letrasReveladas.includes('_')) {
                this.vitoria();
            }
        } else {
            // Letra errada
            this.letrasErradas.push(letra);
            this.tentativas++;
            this.atualizarStatus();
            
            // Desabilitar tecla
            document.querySelector(`[data-letra="${letra}"]`).disabled = true;
            
            // Verificar derrota
            if (this.tentativas >= this.maxTentativas) {
                this.derrota();
            }
        }
    }
    
    vitoria() {
        this.jogoTerminou = true;
        this.mostrarResultado('🎉 Parabéns! Você venceu!', 'VITORIA');
    }
    
    derrota() {
        this.jogoTerminou = true;
        this.mostrarResultado(`💀 Você perdeu! A palavra era: ${this.palavraSecreta}`, 'DERROTA');
    }
    
    mostrarResultado(mensagem, tipo) {
        const resultado = document.getElementById('resultado');
        resultado.textContent = mensagem;
        resultado.className = `resultado ${tipo}`;
        resultado.style.display = 'block';
        document.getElementById('btnReiniciar').style.display = 'inline-block';
        
        // Desabilitar todas as teclas
        document.querySelectorAll('.tecla').forEach(btn => btn.disabled = true);
    }
    
    ocultarResultado() {
        document.getElementById('resultado').style.display = 'none';
    }
    
    atualizarStatus() {
        document.getElementById('tentativas').textContent = this.tentativas;
        document.getElementById('maxTentativas').textContent = this.maxTentativas;
        document.getElementById('letrasErradas').textContent = this.letrasErradas.join(', ');
    }
    
    reiniciar() {
        document.querySelectorAll('.tecla').forEach(btn => btn.disabled = false);
        this.init();
    }
}

// Iniciar o jogo quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    new JogoForca();
});