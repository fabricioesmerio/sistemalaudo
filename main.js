$("#btn-login").click(function () {
    var data = $("#login-form").serialize();

    console.log('data serialize ==>', typeof(data));

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
                $("#login-alert").removeClass('alert-danger');
                $("#login-alert").find('span').first().removeClass('glyphicon-exclamation-sign');
                $("#login-alert").find('span').first().addClass('glyphicon-ok-sign');
                //glyphicon-ok
                $("#login-alert").addClass('alert-info');
                $("#login-alert").css('display', 'block')
                $("#mensagem").html('<strong>Sucesso! '+ response.mensagem +'</strong><br />Redirecionando...');
                setTimeout(() => {
                    $("#login-alert").css('display', 'none')
                    $("#mensagem").html('');
                    window.location.href = "production/index.php";
                }, 2000);
            } else {
                console.log('else click login');
                $("#btn-login").html('Entrar');
                $("#login-alert").css('display', 'block')
                $("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
            }
        }
    });
    return false;
});