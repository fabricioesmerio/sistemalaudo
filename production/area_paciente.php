<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';

if ($_SESSION['tipo'] != "Pat") {
    session_destroy();
    header('Status: 403 Acesso Proíbido', false, 403);
    header('Location: ../index.html');
    exit();
}

$study = new Study();
$studyDAO = new StudyDAO();
$study = $studyDAO->getByPatient($_SESSION['id']);

?>

<div class="container">
    <div class="right_col" role="main">
        <div class="container">
            <div class="table-responsive">
                <table class="table display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Data</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        if ($study) {

                            foreach ($study as $obj) {
                        ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $obj->getStudy_desc() ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($obj->getStudy_datetime())) ?>
                                    </td>
                                    <td class="controls">
                                        
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
