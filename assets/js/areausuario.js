window.addEventListener('load', function() {
    let nome = sessionStorage.getItem('nome');
    if (nome != null) {
        nome = nome.split(' ');
        primeiroNome = nome[0];
        document.getElementById('nome-usuario').innerHTML = primeiroNome;
    } else {
        window.location.href = "../index.html";
    }
});

function logout() {
    sessionStorage.clear();
    window.location.href = "../index.html";
}