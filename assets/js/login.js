const myModal = new bootstrap.Modal(document.getElementById('modalForm'), {});
const formSenha = document.getElementById('formSenha');
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

    if (data.codigo == 1) {
        //sucesso
        sessionStorage.setItem('email', data.email);
        sessionStorage.setItem('cpf', data.cpf);
        sessionStorage.setItem('nome', data.nome);
        sessionStorage.setItem('id', data.id);
        sessionStorage.setItem('celular', data.celular);

        window.location.href = "./areadousuario";
    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        document.getElementById('form-login').reset();
    }
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
        Swal.fire("Sucesso", data.msg, "success");
        document.getElementById('form-cadastro').reset();
    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        document.getElementById('form-cadastro').reset();
    }
}

function redefinirSenha() {
    myModal.show();
}

formSenha.onsubmit = (e) => {

    e.preventDefault();

    if (this.novaSenha.value != this.repeteNovaSenha.value) {
        Swal.fire("Atenção", "As senhas precisam ser iguais", "warning");
    } else {
        const formattedData = {
            email: this.emailSenha.value,
            cpf: this.cpfSenha.value,
            novasenha: this.novaSenha.value
        }
        sendFormSenha(formattedData);
    }
}

async function sendFormSenha(x) {
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/send_novasenha.php", {
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
        Swal.fire({
            title: 'Sucesso',
            html: `${data.msg}`,
            allowOutsideClick: false,
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            showConfirmButton: true,
            cancelButtonText: 'Não',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location.reload();
            }
        });
    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        document.getElementById('formSenha').reset();
    }
}