const formLogin = document.getElementById('form-login');
const formCadastro = document.getElementById('form-cadastro');

formLogin.addEventListener('submit', function(e) {
    e.preventDefault();
    const formattedData = {
        email: this.emailLogin.value,
        senha: this.senhaLogin.value
    }
    sendFormLogin(formattedData);
})

formCadastro.addEventListener('submit', function(e) {
    e.preventDefault();
    let controle = "cadastro";
    sendForm(controle);
})

async function sendFormLogin(x) {
    const formData = new FormData(formLogin);
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/login.php", {
        method: "POST",
        body: bodyContent,
        header: {
            'Content-type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow'
    });

    const data = await response.json();

    sessionStorage.setItem('email', data.email);
    sessionStorage.setItem('cpf', data.cpf);
    sessionStorage.setItem('nome', data.nome);
    sessionStorage.setItem('id', data.id);

    window.location.href = "./areadousuario";
}