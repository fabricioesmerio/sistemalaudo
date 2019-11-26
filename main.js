$("#btn-login").click(function () {
    var data = $("#login-form").serialize();

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
                $("#login-alert").css('display', 'none')
                window.location.href = "production/index.php";
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