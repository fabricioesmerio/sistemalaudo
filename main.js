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

    var newPass = calcMD5(pass.val());

    $("#btn-login").find('span').first().removeClass("display-none");
    fetch('sources/loginValidate.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `login=${user.val()}&senha=${newPass}`
    })
        .then(response => response.json())
        .then(result => {
            if (result.codigo == "1") {
                $("#btn-login").find('span').first().addClass("display-none");
                toastr.success('Login efetuado com sucesso', 'Sucesso!');
                $("#login-form").trigger("reset");
                setTimeout(() => {
                    $("#login-alert").css('display', 'none')
                    $("#mensagem").html('');
                    window.location.href = "production/index.php";
                }, 1500);
            } else {
                toastr.error(result.mensagem, 'Ops!');
                $("#login-form").trigger("reset");
                $("#btn-login").find('span').first().addClass("display-none");
            }
        })
        .catch(err => {
            toastr.error(err, 'Erro!');
            $("#login-form").trigger("reset");
            $("#btn-login").find('span').first().addClass("display-none");
        });
});

$("#btn-login-paciente").click(function () {
    var user = $("#login-form").find('input[name="login_paciente"]');
    var pass = $("#login-form").find('input[name="senha_paciente"]');

    if (!user.val()) {
        toastr.warning('Informe o campo Login', 'Atenção!');
        user.focus();
        return 0;
    } else if (!pass.val()) {
        toastr.warning('Informe o campo Senha', 'Atenção!');
        pass.focus();
        return 0;
    }

    $("#btn-login-paciente").find('span').first().removeClass("display-none");
    fetch('sources/loginValidatePaciente.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `login=${user.val()}&senha=${pass.val()}`
    })
        .then(response => response.json())
        .then(result => {
            if (result.codigo == "1") {
                $("#btn-login-paciente").find('span').first().addClass("display-none");
                toastr.success('Login efetuado com sucesso', 'Sucesso!');
                $("#login-form").trigger("reset");
                setTimeout(() => {
                    $("#login-alert").css('display', 'none')
                    $("#mensagem").html('');
                    window.location.href = "production/index.php";
                }, 1500);
            } else {
                toastr.error(result.mensagem, 'Ops!');
                $("#login-form").trigger("reset");
                $("#btn-login-paciente").find('span').first().addClass("display-none");
            }
        })
        .catch(err => {
            toastr.error(err, 'Erro!');
            $("#login-form").trigger("reset");
            $("#btn-login-paciente").find('span').first().addClass("display-none");
        });
});