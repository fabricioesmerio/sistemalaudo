<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';
require_once '../class/PatientArquivo.php';
require_once '../DAO/PatientArquivoDAO.php';

if(isset($_GET['stuNumber'])) {
    $idStudy = filter_input(INPUT_GET,'stuNumber', FILTER_SANITIZE_NUMBER_INT);

        
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
  

     
            
            if ($patFileDAO->save($name, $type, $data, $size, $study->getPatient_fk()))  {
                $_SESSION['showMessage'] = 'success';
            } else {
                $_SESSION['showMessage'] = 'error';
            }
        }


        $patFile = $patFileDAO->getByPatient($study->getPatient_fk());
        // var_dump($patFile);


?>

<div class="container">
    <div class="right_col" role="main">

        <div class="inline-flex flex flex-column flex-1 w-100-p" style="position: relative">
            <div class="flex box mt-12" style="padding-top: 40px; background-color: #ededed; border: 1px solid #d1d1d1;">
                <div class="box-title">Dados Paciente</div>
                <div class="flex1 flex-w-35p flex mr-8">
                    <div class="flex-1">Paciente: </div>
                    <div class="flex-5 c-field"><?= str_replace(["^^^^"], "", $study->getNomePaciene()); ?></div>
                </div>
                <div class="flex1 flex-w-20p flex mr-8">
                    <div class="flex-1">Exame: </div>
                    <div class="flex-5 c-field"><?= $study->getStudy_desc() ?></div>
                </div>
                <div class="flex1 flex-w-20p flex">
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
        <?php

        // echo $patFile->getId();


        
        
            if ($patFile) {
                foreach ($patFile as $obj) { ?>
                


                <img src="viewImports.php?fileId=<?= $obj->getId(); ?>"/>
                <?php 
                }
            }

        ?>
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
			<?php	break;
			case 'error': ?>
				toastr.error('Ocorreu um erro ao salvar.', 'Ops!');
			<?php	break;
			
			default:
				break;
		}
		unset($_SESSION['showMessage']);
	}
	?>
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
    jQuery(document).ready(function () {
        window.location.href = "index.php";
    });
</script>

<?php
}
?>