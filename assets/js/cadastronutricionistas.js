const formCadastro = document.getElementById('form-cadastro');

formCadastro.addEventListener('submit', function(e) {
    e.preventDefault();
    const formattedData = {
        nome: this.nomeCadastro.value,
        email: this.emailCadastro.value,
        crn: this.crnCadastro.value,
        senha: this.senhaCadastro.value
    }
    sendFormCadastro(formattedData);
});

async function sendFormCadastro(x) {
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/create_nutricionista.php", {
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
                window.location.href = 'index.html';
            }
        });
    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        document.getElementById('form-cadastro').reset();
    }
}