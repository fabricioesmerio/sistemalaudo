
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


    function saveDoc(id, path) {
        // login=usuario&senha=qwerty
        console.log('meu id ==> ', id);
        console.log('path ==> ', path);
        let data = {id: id, path: path};

        $.ajax({
            type: 'POST',
            url: '../sources/saveDoc.php',
            data: data,
            success: function(response) {
                console.log('======>>', JSON.parse(response));
                // var resposta = JSON.parse(response);
                // if (resposta.codigo == 1) {
                //     $("#mensagem").html('<strong>Sucesso! </strong>' + resposta.mensagem);
                // } else {
                //     $("#mensagem").html('<strong>Erro! </strong>' + resposta.mensagem);
                // }
            }
        });

    }


    $("#btnUploadFile").click(function () {
        var file_data = $('#uploadedFile').prop('files')[0];
        var id = $('input[name="patNumber"]').val();
        // console.log('id ===> ', id);
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
                let resposta = JSON.parse(response);
                console.log('response 2 >> ', resposta.codigo);
                let path = resposta.path.split('..');
                saveDoc(id, path[1]);
                $("#btnUploadFile").html('Upload');
                $('#uploadedFile').val('');
                if (resposta.codigo == 1) {
                    // $("#btn-login").html('Entrar');
                    // $("#login-alert").css('display', 'none')
                    console.log('sucesso', resposta.mensagem);
                    // $("#mensagem").html('<strong>Sucesso! </strong>' + resposta.mensagem);
                    
                } else {
                    console.log('else click login');
                    $("#btnUploadFile").html('Upload');
                    $("#mensagem").html('<strong>Erro! </strong>' + resposta.mensagem);
                }
            }
        });
        return false;
    });

});

$(document).ready(function() {
    $('#studyList').DataTable({
        "order": [[ 2, "desc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    });
    $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
} );