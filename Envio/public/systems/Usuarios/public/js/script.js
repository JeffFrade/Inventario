function edi()
{
    var x = confirm('Deseja Editar os Dados?');

    if (x == true) {
        return true;
    } else {
        return false;
    }
}

function del()
{
    var x = confirm('Deseja Deletar os Dados?');

    if (x == true) {
        return true;
    } else {
        return false;
    }
}

function cong()
{
    var x = confirm('Deseja Congelar o Usuário?');

    if (x === true) {
        return true;
    }
    return false;
}