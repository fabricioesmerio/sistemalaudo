<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';

if ($_SESSION['tipo'] != 'Pat') {
    session_destroy();
    header('Status: 403 Acesso Proíbido', false, 403);
    header('Localização: ../index.html');
    exit();
}

$study = new Study();
$studyDAO = new StudyDAO();
$study = $studyDAO->get

?>

<div class="container">
    <div class="right_col" role="main">
        <div class="container">
            <div class="table-responsive">
                <table class="table display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Data</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($study) {

                            foreach ($study as $obj) {
                        ?>
                                <tr>
                                    <td><?= $obj->getPk(); ?></td>
                                    <td><?= str_replace(["^^^^"], "", $obj->getNomePaciene()); ?></td>
                                    <td><span class="hide"><?= $obj->getStudy_datetime() ?></span><?= date('d/m/Y H:i', strtotime($obj->getStudy_datetime())) ?>
                                    </td>
                                    <td><?= $obj->getStudy_desc() ?></td>
                                    <td class="controls">
                                        <a href="http://179.124.242.194:8080/weasis-pacs-connector/weasis?accessionNumber=<?= $obj->getAccession_no(); ?>" target="_blank" title="Abrir Weasis"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="http://179.124.242.194:8080/oviyam/oviyam?patientID=*&accessionNumber=<?= $obj->getAccession_no(); ?>" target="_blank" title="Ver imagens"><i class="fa fa-object-group" aria-hidden="true"></i></a>
                                        <a href="import.php?stuNumber=<?= $obj->getPk() ?>" title="Importar Arquivos"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                        <a href="w_laudo.php?stuNumber=<?= $obj->getPk() ?>" title="Digitar Laudo"><i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
                                        <a href="r_audio.php?stuNumber=<?= $obj->getPk() ?>" title="Gravar áudio"><i class="fa fa-microphone" aria-hidden="true"></i></a>
                                    </td>
                                <?php
                            }
                                ?>
                                </tr>
                    </tbody>
                </table>
            <?php
                        } else {
            ?>
                <!-- <div style="height: 50px; width: 100%; background-color: red;">
					Nenhum registro para mostrar.
				</div> -->
            <?php
                        }
            ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
