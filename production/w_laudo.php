<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';

if ($_SESSION['tipo'] != 'Med') {
	session_destroy();
	header('Status: 403 Acesso Proíbido', false, 403);
	header('Location: ../index.html');
	exit();
}

if(isset($_GET['stuNumber'])) {
    $idStudy = filter_input(INPUT_GET,'stuNumber', FILTER_SANITIZE_NUMBER_INT);

        
        $study = new Study();
        $studyDAO = new StudyDAO();

        if (isset($_POST['save'])) {
            $study->setPk($idStudy);
            $study->setLaudo_texto(filter_input(INPUT_POST, 'editorLaudo'));
            $finLaudo = (isset($_POST['finaliza_laudo']) && $_POST['finaliza_laudo'] == 'on') ? true : false;
            $study->setFinaliza_laudo($finLaudo);
           
            if ($studyDAO->saveLaudo($study)) {
				$_SESSION['showMessage'] = 'success';
            } else {
				$_SESSION['showMessage'] = 'error';
            }
        }

        $study = $studyDAO->getById($idStudy);

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
            <h2>Redigir Laudo</h2>
            <form action="w_laudo.php?stuNumber=<?= $idStudy?>" method="POST">
                <textarea name="editorLaudo" id="editorLaudo">
                    <?= $study->getLaudo_texto(); ?>
                </textarea>
                <div class="flex justify-end mt-4">
                    <input type="checkbox" id="finaliza_laudo" name="finaliza_laudo" <?= $study->getFinaliza_laudo() ? 'checked="checked"' : '' ?>>
                    <label for="finaliza_laudo" style="padding: 1px;" >Disponibilizar a Versão em PDF desse laudo para paciente?</label>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" name="save" class="btn btn-primary" style="margin-right: 0px">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
	CKEDITOR.replace( 'editorLaudo' );
	
	
</script>






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