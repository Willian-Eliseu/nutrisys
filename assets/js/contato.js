const formContato = document.getElementById('formContato');

formContato.onsubmit = (e) => {
    e.preventDefault();
    const formattedData = {
        nome: this.nome.value,
        sobrenome: this.sobrenome.value,
        email: this.email.value,
        celular: this.celular.value,
        mensagem: this.mensagem.value
    }
    sendFormContato(formattedData);
}

async function sendFormContato(x) {
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/send_contato.php", {
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
                document.getElementById('formContato').reset();
            }
        });
    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        document.getElementById('formContato').reset();
    }
}