const formPerfil = document.getElementById('form-perfil');

window.addEventListener('load', function() {
    let nome = sessionStorage.getItem('nome');
    if (nome != null) {
        nome = nome.split(' ');
        primeiroNome = nome[0];
        document.getElementById('nome-usuario').innerHTML = primeiroNome;
        //carrega e preenche o formulário
        document.getElementById('nome_cadastro').value = sessionStorage.getItem('nome');
        document.getElementById('email_cadastro').value = sessionStorage.getItem('email');
        document.getElementById('cpf_cadastro').value = sessionStorage.getItem('cpf');
        document.getElementById('celular_cadastro').value = sessionStorage.getItem('celular');
        document.getElementById('usuario').value = sessionStorage.getItem('id');
    } else {
        window.location.href = "../index.html";
    }
});

function logout() {
    sessionStorage.clear();
    window.location.href = "../index.html";
}

formPerfil.addEventListener('submit', function(e) {
    e.preventDefault();
    const formattedData = {
        nome: this.nome_cadastro.value,
        email: this.email_cadastro.value,
        celular: this.cpf_cadastro.value,
        cpf: this.celular_cadastro.value,
        id: this.usuario.value
    }
    sendFormPerfil(formattedData);
})

async function sendFormPerfil(x) {
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/update.php", {
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
        Swal.fire("Sucesso", data.msg, "success");

        sessionStorage.setItem('email', document.getElementById('email_cadastro').value);
        sessionStorage.setItem('cpf', document.getElementById('cpf_cadastro').value);
        sessionStorage.setItem('nome', document.getElementById('nome_cadastro').value);
        sessionStorage.setItem('celular', document.getElementById('celular_cadastro').value);

    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        //carrega e preenche o formulário
        document.getElementById('nome_cadastro').value = sessionStorage.getItem('nome');
        document.getElementById('email_cadastro').value = sessionStorage.getItem('email');
        document.getElementById('cpf_cadastro').value = sessionStorage.getItem('cpf');
        document.getElementById('celular_cadastro').value = sessionStorage.getItem('celular');
        document.getElementById('usuario').value = sessionStorage.getItem('id');
    }
}