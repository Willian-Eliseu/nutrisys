const myModal = new bootstrap.Modal(document.getElementById('modalForm'), {});

window.addEventListener('load', function() {
    const formattedData = {
        email: sessionStorage.getItem('email'),
        cpf: sessionStorage.getItem('cpf')
    }
    getSolicitacoes(formattedData);
});

async function getSolicitacoes(x) {

    var bodyContent = JSON.stringify(x);
    const response = await fetch("https://test.wl.tv.br/eliseu/nutrisys/apinutrisys/api/solicitacoes_get.php", {
        method: "POST",
        body: bodyContent,
        header: {
            'Content-type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow'
    });

    const data = await response.json();

    if (data != 0) {
        const corpo = data.body;
        let tableBody = "";
        for (x in corpo) {
            tableBody += `<tr>
                <td class="text-center">${corpo[x]['nutri_nome']}</td>
                <td class="text-center">${corpo[x]['data_sol']}</td>
                <td class="text-center"><a href="javascript:detalhesSolicitacao('${corpo[x]['nutri_nome']}','${corpo[x]['nutri_email']}','${corpo[x]['mensagem']}','${corpo[x]['data']}')" class="text-decoration-none text-dark"><i class="bi bi-pencil-square"></i></a></td>
            </tr>`;
        }
        document.getElementById('table_content').innerHTML = tableBody;
    } else {
        //erro
        Swal.fire("Erro", "Nenhum registro encontrado", "error");
    }
}

function detalhesSolicitacao(nome, email, mensagem, datasol) {
    document.getElementById('dsolicitacao').value = `${datasol}`;
    document.getElementById('nnome').value = `${nome}`;
    document.getElementById('nemail').value = `${email}`;
    document.getElementById('mensagem').innerHTML = `${mensagem}`;
    myModal.show();
}