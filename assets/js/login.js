const formLogin = document.getElementById('form-login');
const formCadastro = document.getElementById('form-cadastro');
const mensagens = document.getElementById('dialogMessage');

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
    const formattedData = {
        nome: this.nomeCadastro.value,
        email: this.emailCadastro.value,
        celular: this.celularCadastro.value,
        cpf: this.cpfCadastro.value,
        senha: this.senhaCadastro.value
    }
    sendFormCadastro(formattedData);
})

async function sendFormLogin(x) {
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
    sessionStorage.setItem('celular', data.celular);

    window.location.href = "./areadousuario";
}

async function sendFormCadastro(x) {
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/create.php", {
        method: "POST",
        body: bodyContent,
        header: {
            'Content-type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow'
    });

    const data = await response.json();

    if (data.codigo == 1) {
        //sucesso
        abrirDialog("Sucesso", data.msg);
    } else {
        //erro
        abrirDialog("Erro", data.msg);
    }
}

function abrirDialog(x, y) {
    document.getElementById('dialogHeader').innerHTML = x;
    document.getElementById('dialogBody').innerHTML = y;
    mensagens.setAttribute('open', true);
    mensagens.classList.remove('msgFechada');
}

document.getElementById('dialogClose').addEventListener('click', function() {
    mensagens.classList.add('msgFechada');
})