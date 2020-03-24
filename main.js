$("#btn-login").click(function () {
    var user = $("#login-form").find('input[name="login"]');
    var pass = $("#login-form").find('input[name="senha"]');

    if (!user.val()) {
        toastr.warning('Informe o campo Usuário', 'Atenção!');
        user.focus();
        return 0;
    } else if (!pass.val()) {
        toastr.warning('Informe o campo Senha', 'Atenção!');
        pass.focus();
        return 0;
    }

    pass.val(calcMD5(pass.val()));

    var data = $("#login-form").serialize();
    //$("#login-form").trigger("reset");

    $.ajax({
        type: 'POST',
        url: 'sources/loginValidate.php',
        data: data,
        dataType: 'json',
        beforeSend: function ()
        {
            $("#btn-login").html('Validando ...');
        },
        success: function (response) {
            console.log('response >> ', response);
            if (response.codigo == "1") {
                $("#btn-login").html('Entrar');
                toastr.success('Login efetuado com sucesso', 'Sucesso!');
                $("#login-form").trigger("reset");
                setTimeout(() => {
                    $("#login-alert").css('display', 'none')
                    $("#mensagem").html('');
                    window.location.href = "production/index.php";
                }, 1500);
            } else {
                toastr.error(response.mensagem, 'Ops!');
                $("#login-form").trigger("reset");
                $("#btn-login").html('Entrar');
            }
        }
    });
    return false;
});