<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';
?>



<!-- page content -->
<div class="container">
    <div class="right_col" role="main">
        <div class="container">

            <div class="row">
                <div class="col-md-2 col-md-pull-2"></div>
                <div class="col-md-1 col-md-pull-1 col-xs-3 p-4 w-92">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn btn-info">
                            Hoje
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-1 col-md-pull-1 col-xs-3 p-4 w-110">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn btn-info">
                            Ontem
                            <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-1 col-md-pull-1 col-xs-3 p-4 w-110">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn btn-info">
                            7 Dias
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-1 col-md-pull-1 col-xs-3 p-4 w-110">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn btn-info">
                            30 Dias
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-1 col-md-pull-1 col-xs-3 p-4 w-110">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn btn-info">
                            Todos
                            <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-md-push-2"></div>
        </div>
        
        <div class="table-responsive">
            <table id="studyList" class="table display" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Paciente</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $study = new Study();
                        $studyDAO = new StudyDAO();
                        $study = $studyDAO->getListStudy();
                        foreach ($study as $obj) {
                        ?>
                    <tr>
                        <td><?= $obj->getPk(); ?></td>
                        <td><?= str_replace(["^^^^"], "", $obj->getNomePaciene()); ?></td>
                        <td><span
                                class="hide"><?= $obj->getStudy_datetime() ?></span><?= date('d/m/Y H:i', strtotime($obj->getStudy_datetime())) ?>
                        </td>
                        <td><?= $obj->getStudy_desc() ?></td>
                        <td class="controls">
                            <a href="http://179.124.242.194:8080/weasis-pacs-connector/weasis?accessionNumber=<?= $obj->getAccession_no(); ?>"
                                target="_blank" title="Abrir Weasis"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="http://179.124.242.194:8080/oviyam/oviyam?patientID=*&accessionNumber=<?= $obj->getAccession_no(); ?>"
                                target="_blank" title="Ver imagens"><i class="fa fa-object-group"
                                    aria-hidden="true"></i></a>
                            <a href="upload.php?patNumber=<?= $obj->getPatient_fk() ?>" title="Upload de arquivos"><i
                                    class="fa fa-upload" aria-hidden="true"></i></a>
                            <a href="#" onclick="alert('Em desenvolvimento!')" title="Digitar Laudo"><i
                                    class="fa fa-newspaper-o" aria-hidden="true"></i></a>
                            <a href="#" onclick="alert('Em desenvolvimento!')" title="Gravar áudio"><i
                                    class="fa fa-microphone" aria-hidden="true"></i></a>
                        </td>
                        <?php
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- /page content -->

<?php
include 'footer.php';