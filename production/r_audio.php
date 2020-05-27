<?php
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';

if ($_SESSION['tipo'] != 'Med') {
	session_destroy();
	header('Status: 403 Acesso Proibido', false, 403);
	header('Location: ../index.html');
	exit();
}

if (isset($_GET['stuNumber'])) {
	$idStudy = filter_input(INPUT_GET, 'stuNumber', FILTER_SANITIZE_NUMBER_INT);


	$study = new Study();
	$studyDAO = new StudyDAO();

	// if (isset($_POST['save'])) {
	//     $study->setPk($idStudy);
	//     $study->setLaudo_texto(filter_input(INPUT_POST, 'editorLaudo'));
	//     $finLaudo = (isset($_POST['finaliza_laudo']) && $_POST['finaliza_laudo'] == 'on') ? true : false;
	//     $study->setFinaliza_laudo($finLaudo);

	//     if ($studyDAO->saveLaudo($study)) {
	//         $_SESSION['sucesso'] = '
	//         <div class="alert alert-success alert-dismissible" role="alert">
	//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	//             <strong>Sucesso!</strong> Laudo salvo com sucesso!
	//         </div>
	//         ';
	//     } else {
	//         $_SESSION['erro'] = '
	//         <div class="alert alert-danger alert-dismissible" role="alert">
	//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	//             <strong>Erro!</strong> Ocorreu um erro ao salvar o laudo.
	//         </div>
	//         ';
	//     }
	// }

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
				<div style="margin-top: 12px; width: 300px;">

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
				<h2>Gravar áudio</h2>

				<div id="controls">
					<button id="recordButton">Record</button>
					<button id="pauseButton" disabled>Pause</button>
					<button id="stopButton" disabled>Stop</button>
				</div>

				<h3>Gravação</h3>
				<ol id="recordingsList"></ol>

				<script>
					
				</script>

				<!-- <audio controls id="audio"></audio>
				<div>
					<a class="button recordButton" id="record">Gravar</a>
					<a class="button disabled one" id="pause">Pausar</a>
					<a class="button disabled one" id="stop">Reiniciar</a>
				</div>
				<div data-type="wav">
					<p>WAV Controls:</p>
					<a class="button disabled one" id="play">Escutar</a>
					<a class="button disabled one" id="download">Download</a>
					<a class="button disabled one" id="base64">Base64 URL</a>
					<a class="button disabled one" id="save">Upload to Server</a>
				</div> -->
				<!-- <div class="flex justify-end mt-4">
                    <button type="submit" name="save" class="btn btn-primary" style="margin-right: 0px">Salvar</button>
                </div> -->

			</div>
		</div>
	</div>
	<!-- <style>
		.button {
			display: inline-block;
			vertical-align: middle;
			margin: 0px 5px;
			padding: 5px 12px;
			cursor: pointer;
			outline: none;
			font-size: 13px;
			text-decoration: none !important;
			text-align: center;
			color: #fff;
			background-color: #4D90FE;
			background-image: linear-gradient(top, #4D90FE, #4787ED);
			background-image: -ms-linear-gradient(top, #4D90FE, #4787ED);
			background-image: -o-linear-gradient(top, #4D90FE, #4787ED);
			background-image: linear-gradient(top, #4D90FE, #4787ED);
			border: 1px solid #4787ED;
			box-shadow: 0 1px 3px #BFBFBF;
		}

		a.button {
			color: #fff;
		}

		.button:hover {
			box-shadow: inset 0px 1px 1px #8C8C8C;
		}

		.button.disabled {
			box-shadow: none;
			opacity: 0.7;
		}

		canvas {
			display: block;
		}
	</style> -->
	<!-- <script>
		var player = document.getElementById('player');

		var handleSuccess = function(stream) {
			if (window.URL) {
				player.src = window.URL.createObjectURL(stream);
			} else {
				player.src = stream;
			}
		};

		navigator.mediaDevices.getUserMedia({
				audio: true,
				video: false
			})
			.then(handleSuccess)
	</script> -->






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
		jQuery(document).ready(function() {
			window.location.href = "index.php";
		});
	</script>

<?php
}
?>