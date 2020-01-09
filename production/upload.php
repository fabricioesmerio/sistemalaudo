<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';
require_once '../class/DocPaciente.php';
require_once '../DAO/DocPacienteDAO.php';

if(isset($_GET['patNumber'])) {
    $idPatient = $_GET['patNumber'];

        require_once '../DAO/DocPacienteDAO.php';
        require_once '../class/DocPaciente.php';

        $newDoc = new DocPaciente();
        $newDocDAO = new DocPacienteDAO();


        if (isset($_POST['uploadBtn2']) && isset($_FILES['uploadedFile'])) {
            if (0 < $_FILES['uploadedFile']['error']) {
                $_SESSION['erro'] = '
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Erro!</strong> Ocorreu um erro, tente novamente.
                                    </div>
                                    ';
                $list = $newDocDAO->getById($idPatient);
            } else {
                $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
                $fileName = $_FILES['uploadedFile']['name'];
                $fileSize = $_FILES['uploadedFile']['size'];
                $fileType = $_FILES['uploadedFile']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'docx', 'xlsx', 'pdf');

                if (in_array($fileExtension, $allowedfileExtensions)) {
                        $uploadFileDir = '../uploads/';
                        $dest_path = $uploadFileDir . $newFileName;

                        if(move_uploaded_file($fileTmpPath, $dest_path))
                        {
                            $path = explode('..', $dest_path);
                            $newDoc->setId_paciente($idPatient);
                            $newDoc->setArquivo($path[1]);
                            if ($newDocDAO->save($newDoc)) {
                                $_SESSION['sucesso'] = '
                                                        <div class="alert alert-success alert-dismissible" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <strong>Sucesso!</strong>Upload do arquivo realizado com sucesso!
                                                        </div>
                                                        ';
                            } else {
                                $_SESSION['erro'] = '
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <strong>Erro!</strong> Ocorreu um erro ao salvar o arquivo.
                                                    </div>
                                                    ';
                            }
                        }
                        else
                        {
                            $_SESSION['erro'] = '
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong>Erro!</strong> Erro ao fazer upload!
                                                </div>
                                                ';
                        }
                    } else {
                        $_SESSION['erro'] = '
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <strong>Erro!</strong>Extensão não permitida.
                                            </div>
                                            ';
                    }
                    $list = $newDocDAO->getById($idPatient);
            }
        } else {
            $doc = new DocPaciente();
            $docDAO = new DocPacienteDAO();
            $list = $docDAO->getById($idPatient);
        }

?>

<div class="container">
    <div class="right_col" role="main">
        <form method="POST" action="upload.php?patNumber=<?= $idPatient?>" id="formUploadFile" enctype="multipart/form-data">
        <div class="upload-file">
            <h2>Adicionar arquivo</h2>
            <input type="file" id="uploadedFile" name="uploadedFile" />
            <input type="hidden" name="patNumber" value="<?= $idPatient?>">
            <button type="submit" name="uploadBtn2" class="btn btn-primary" id="btnUploadFile2" disabled>Upload</button>
        </div>

        <div id="mensagem" style="padding: 4px 1px; margin-top: 8px;">
            <?php
                if (isset($_SESSION['sucesso'])) {
                    echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']);
                } elseif (isset($_SESSION['erro'])) {
                    echo $_SESSION['erro'];
                    unset($_SESSION['erro']);
                }
            ?>
        </div>
        </form>


<div class="divider" style="margin: 20px 10px;"></div>
        <div class="table-responsive row p-0-18" style='width: 300px; margin: 0 auto;'>
            <h2>Arquivos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Ver</th>
                        <th>Baixar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($list)) {
                        foreach ($list as $obj) {
                    ?>
                    <tr>
                        <td><?php
                            $ext = explode('.', $obj->getArquivo());
                            $arrImg = array('png', 'jpg', 'jpeg', 'gif');
                            if(in_array($ext[1], $arrImg)) {
                                echo '<span class="glyphicon glyphicon glyphicon-picture" aria-hidden="true"></span>';
                            } else {
                                echo '<span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span>';
                            }
                         ?></td>
                        <!-- <td><a href="javascript:MyFunction(this, '<?php echo $obj->getArquivo(); ?>', false);" >Ver</a></td> -->
                        <td><a href="..<?php echo $obj->getArquivo();?>" target="_blank">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </a></td>
                        <!-- <td>
                            <a href="javascript:MyFunction(this, '<?php echo $obj->getArquivo(); ?>', true);" >Baixar</a>
                        </td> -->
                        <td><a href="..<?php echo $obj->getArquivo();?>" download>
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                        </a></td>
                        <!-- <td><?php echo dirname(__FILE__) .''. $obj->getArquivo();?></td> -->
                    </tr>
                    <?php
                    }
                }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        var input = document.getElementById('uploadedFile');
        var btnSubmit = document.getElementById('btnUploadFile2');
        input.addEventListener('change', function() {
            if (input.value !== "") {
                btnSubmit.disabled = false;
            } else {
                btnSubmit.disabled = true;
            }
        });
    }
    function MyFunction(ref, url, download)
    {
        var pathName = location.pathname;
        var x = pathName.split('/');
        var path = location.origin +'/'+ x[1];
        var file = path + url;
        if (!download) {
            window.open(file, '_blank');
        } else {
            var _x = url.split('/');
            var a  = document.createElement('a');
            a.href = file;
            a.download = file;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    }
</script>

<?php
include 'footer.php';
} else {
    ?>
<div class="container" onload="redir()">
    <div class="right_col" role="main">
        <span>Entrada inválida!. Você será redirecionado à lista...</span>
    </div>
</div>
<?php
    include 'footer.php';
    ?>
<script>
    jQuery(document).ready(function () {
        window.location.href = "index.php";
    });
</script>

<?php
}
?>