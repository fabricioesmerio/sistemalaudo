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
            <div class="row section-search">
                <!-- <div style="display: flex; flex-direction: column; flex: 1;"> -->
                <form action="" method="GET">

                    <input type="text" name="term" placeholder="Pesquisar">
                    <button type="submit">
                        Pesquisar
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>

                <!-- </div> -->
            </div>

            <div class="row filter-date">


                <div class="btn-group" role="group">
                    <button type="button" onclick="filterDate('today')" class="btn btn btn-info">
                        Hoje
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    </button>
                </div>


                <div class="btn-group" role="group">
                    <button type="button" class="btn btn btn-info" onclick="filterDate('yesterday')">
                        Ontem
                        <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn btn-info" onclick="filterDate('lastWeek')">
                        7 Dias
                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn btn-info" onclick="filterDate('lastMonth')">
                        30 Dias
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn btn-info">
                        Todos
                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                    </button>
                </div>
            </div>


            <!-- <div class="row">
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
            </div> -->
            <div class="col-md-2 col-md-push-2"></div>
        </div>

        <div class="table-responsive">
            <table class="table display" style="width:100%">
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
                        $limit = 10;
                        $study = new Study();
                        $studyDAO = new StudyDAO();
                        $total = $studyDAO->getCountTotal();
                        $pagination = 1;
                        $adjacents = 2;
                        if ($total) {
                            $pagination = ceil($total/$limit);
                        }

                        if(isset($_GET['page']) && $_GET['page'] != "") {
                            $page = $_GET['page'];
                            $offset = $limit * ($page-1);
                        } else {
                            $page = 1;
                            $offset = 0;
                        }

                        if($total <= (1+($adjacents * 2))) {
                            $start = 1;
                            $end   = $total;
                        } else {
                            if(($page - $adjacents) > 1) { 
                                if(($page + $adjacents) < $total) { 
                                    $start = ($page - $adjacents);            
                                    $end   = ($page + $adjacents);         
                                } else {             
                                    $start = ($total - (1+($adjacents*2)));  
                                    $end   = $total;               
                                }
                            } else {               
                                $start = 1;                                
                                $end   = (1+($adjacents * 2));             
                            }
                        }

                        $study = $studyDAO->getListStudy(null, $limit, null);
                        foreach ($study as $obj) {
                        ?>
                    <tr>
                        <td><?= $obj->getPk(); ?> <?= $total; ?></td>
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
                            <a href="w_laudo.php?stuNumber=<?= $obj->getPk() ?>" title="Digitar Laudo"><i
                                    class="fa fa-newspaper-o" aria-hidden="true"></i></a>
                            <a href="r_audio.php?stuNumber=<?= $obj->getPk() ?>" title="Gravar áudio"><i
                                    class="fa fa-microphone" aria-hidden="true"></i></a>
                        </td>
                        <?php
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Navegação dos registros">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="index.php?page=1">Início</a></li>
                    <?php
                        for($i=$start; $i<=$end; $i++) { ?>
                            <li class="page-item"><a class="page-link" href="#"><?= $i; ?></a></li>
                        <?php }
                     ?>                    
                    <li class="page-item"><a class="page-link" href="index.php?page=<?= $pagination?>">Fim</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- /page content -->

<?php
include 'footer.php';