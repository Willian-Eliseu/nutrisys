const myModal = new bootstrap.Modal(document.getElementById('modalForm'), {});
const formSubmit = document.getElementById('formSubmit');

window.addEventListener('load', function() {
    getNutricionistas();
});

async function getNutricionistas() {

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/nutri_get.php");

    const data = await response.json();

    if (data != 0) {
        const corpo = data.body;
        let tableBody = "";
        //console.log(corpo[x]['nome']);
        for (x in corpo) {
            tableBody += `<tr>
                <td class="text-center">${corpo[x]['nome']}</td>
                <td class="text-center">${corpo[x]['crn']}</td>
                <td class="text-center">${corpo[x]['email']}</td>
                <td class="text-center"><a href="javascript:contato('${corpo[x]['nome']}','${corpo[x]['email']}')" class="text-decoration-none text-dark"><i class="bi bi-pencil-square"></i></a></td>
            </tr>`;
        }
        document.getElementById('table_content').innerHTML = tableBody;
    } else {
        //erro
        Swal.fire("Erro", "Nenhum registro encontrado", "error");
    }
}

function contato(nome, email) {
    document.getElementById('nomeUsuario').value = sessionStorage.getItem('nome');
    document.getElementById('emailUsuario').value = sessionStorage.getItem('email');
    document.getElementById('nomeNutricionista').value = `${nome}`;
    document.getElementById('emailNutricionista').value = `${email}`;
    myModal.show();
}

formSubmit.onsubmit = (e) => {
    e.preventDefault();
    const formattedData = {
        nomeUsuario: this.nomeUsuario.value,
        emailUsuario: this.emailUsuario.value,
        nomeNutricionista: this.nomeNutricionista.value,
        emailNutricionista: this.emailNutricionista.value,
        mensagem: this.mensagem.value
    }
    sendFormSubmit(formattedData);
}

async function sendFormSubmit(x) {
    var bodyContent = JSON.stringify(x);

    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/send_request.php", {
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
                window.location.href = "./consultas.html";
            }
        });
    } else {
        //erro
        Swal.fire("Erro", data.msg, "error");
        document.getElementById('formSubmit').reset();
    }
}