
$('document').ready(function () {

    // $("#btn-login").click(function () {
    //     var data = $("#login-form").serialize();

    //     $.ajax({
    //         type: 'POST',
    //         url: 'sources/loginValidate.php',
    //         data: data,
    //         dataType: 'json',
    //         beforeSend: function ()
    //         {
    //             $("#btn-login").html('Validando ...');
    //         },
    //         success: function (response) {
    //             console.log('response >> ', response);
    //             if (response.codigo == "1") {
    //                 $("#btn-login").html('Entrar');
    //                 $("#login-alert").css('display', 'none')
    //                 window.location.href = "production/index.php";
    //             } else {
    //                 console.log('else click login');
    //                 $("#btn-login").html('Entrar');
    //                 $("#login-alert").css('display', 'block')
    //                 $("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
    //             }
    //         }
    //     });
    //     return false;
    // });


    $("#btnUploadFile").click(function () {
        var file_data = $('#uploadedFile').prop('files')[0];
        var form_data = new FormData();                  
        form_data.append('file', file_data);

        

        $.ajax({
            type: 'POST',
            url: '../sources/upload-file.php',
            data: form_data,
            dataType: 'text',
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function ()
            {
                $("#btnUploadFile").html('Enviando ...');
            },
            afterSend: function()
            {
                $("#btnUploadFile").html('Upload');
            },
            success: function (response) {
                console.log('response >> ', response);
                $("#btnUploadFile").html('Upload');
                $('#uploadedFile').val('');
                if (response.codigo == "1") {
                    // $("#btn-login").html('Entrar');
                    // $("#login-alert").css('display', 'none')
                } else {
                    console.log('else click login');
                    $("#btnUploadFile").html('Upload');
                    $("#login-alert").css('display', 'block')
                    $("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
                }
            }
        });
        return false;
    });

});

$(document).ready(function() {
    $('#studyList').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    });
} );