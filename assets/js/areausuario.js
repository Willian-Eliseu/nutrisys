window.addEventListener('load', function() {
    let nome = sessionStorage.getItem('nome');
    nome = nome.split(' ');
    primeiroNome = nome[0];
    document.getElementById('nome-usuario').value = primeiroNome;
})