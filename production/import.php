<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';
require_once '../class/PatientArquivo.php';
require_once '../DAO/PatientArquivoDAO.php';

if (isset($_GET['stuNumber'])) {
    $idStudy = filter_input(INPUT_GET, 'stuNumber', FILTER_SANITIZE_NUMBER_INT);


    $study = new Study();
    $studyDAO = new StudyDAO();
    $study = $studyDAO->getById($idStudy);
    $patFile = new PatientArquivo();
    $patFileDAO = new PatientArquivoDAO();

    if (isset($_POST['save'])) {
        $patFile = new PatientArquivo();
        $name = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];
        $size = $_FILES['file']['size'];
        $data = fopen($_FILES['file']['tmp_name'], 'rb');;


        // $allowExtension = array("image/jpg", "image/gif", "image/png", "application/pdf", "application/vnd.ms-powerpoint");
        $allowExtension = array("jpg", "jpeg", "gif", "png", "pdf", "doc", "docx", "calc", "xls", "xlsx", "odt", "sxw", "rtf");

        if (!in_array(explode('.', $name)[1], $allowExtension)) {
            $_SESSION['showMessage'] = 'deniedExtension';
        } else {
            if ($patFileDAO->save($name, $type, $data, $size, $study->getPatient_fk())) {
                $_SESSION['showMessage'] = 'success';
            } else {
                $_SESSION['showMessage'] = 'error';
            }
        }


    }


    $patFile = $patFileDAO->getByPatient($study->getPatient_fk());


?>

    <div class="container">
        <div class="right_col" role="main">

            <div class="inline-flex flex flex-column flex-1 w-100-p" style="position: relative">
                <div class="row" style="padding-top: 30px; padding-bottom: 10px; background-color: #ededed; border: 1px solid #d1d1d1;">
                    <div class="box-title">Dados Paciente</div>
                    <div class="col-xl-6 col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="flex-1">Paciente: </div>
                        <div class="flex-5 c-field"><?= str_replace(["^^^^"], "", $study->getNomePaciene()); ?></div>
                    </div>
                    <div class="col-xl-3 col-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="flex-1">Exame: </div>
                        <div class="flex-5 c-field"><?= $study->getStudy_desc() ?></div>
                    </div>
                    <div class="col-xl-3 col-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="flex-1">Data: </div>
                        <div class="flex-5 c-field"> <?= date('d/m/Y H:i', strtotime($study->getStudy_datetime())) ?> </div>
                    </div>
                </div>
                <h2>Importar Arquivos</h2>
                <form action="" method="POST" enctype="multipart/form-data">

                    <input type="file" name="file" id="file">
                    <div class="flex justify-end mt-4">
                        <button type="submit" name="save" class="btn btn-primary" style="margin-right: 0px">Salvar</button>
                    </div>
                </form>
                
            </div>
            <div class="table-responsive">
                <table class="table" id="tableFile">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Tamanho</th>
                            <th>Tipo</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($patFile) {
                            $cod = 1;
                            foreach ($patFile as $obj) {
                                echo '<tr>';
                                echo '<td>'. $cod++ .'</td>';
                                echo '<td>'. explode('.', $obj->getNome())[0] .'</td>';
                                echo '<td>'. number_format($obj->getTamanho() / 1024, 2, ',', '') .'kB </td>';
                                echo '<td>'. strtoupper(explode('/', $obj->getMimeType())[1])  .'</td>';
                                echo '<td><a target="_blank"  class="btn btn-info" href="viewImports.php?fileId='. $obj->getId() .'">Ver</a>  
                                <a class="btn btn-danger" onclick="onDelete(this.parentNode.parentNode.rowIndex, '. $obj->getId() .')" href="#">Excluir</a></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?php
    include 'footer.php';

    ?>
    <script>
        <?php
        if (isset($_SESSION['showMessage'])) {
            switch ($_SESSION['showMessage']) {
                case 'success': ?>
                    toastr.success('Registro salvo com sucesso.', 'Sucesso!');
                <?php break;
                case 'error': ?>
                    toastr.error('Ocorreu um erro ao salvar.', 'Ops!');
        <?php break;
                case 'deniedExtension': ?>
                toastr.error('Extensão do arquivo inválido.', 'Ops!');
                <?php 
                default:
                    break;
            }
            unset($_SESSION['showMessage']);
        }
        ?>

    function onDelete(index, idElement) {
        console.log('onDelete:: index', index);
        console.log('onDelete:: idElement',idElement);
        let _r = confirm('Realmente deseja excluir o arquivo?');
        if (!_r) return;
        var form = new FormData();
        form.append('idFile', idElement);
        fetch('deleteFile.php', {
            method: 'POST',
            body: form
        })
        .then(function(response) {
            console.log('response then', response);
            if (response.ok && response.status == 200) {
                toastr.success('Registro excluído com sucesso.', 'Sucesso!');
                deleteRow(index);
            } else {
                toastr.error('Ocorreu um erro ao excluir.', 'Ops!');
            }
        })
        .catch(function (error) {
            toastr.error('Ocorreu um erro ao excluir.', 'Ops!');
        })
    }

    function deleteRow(index) {
        document.getElementById('tableFile').deleteRow(index);
    }
    </script>
<?php
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
        jQuery(document).ready(function() {
            window.location.href = "index.php";
        });
    </script>

<?php
}
?>