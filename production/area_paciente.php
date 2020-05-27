<?php
session_start();
if ($_SESSION['tipo'] != "Pat") {
	session_destroy();
	header('Status: 403 Acesso Proibido', false, 403);
	header('Location: ../erro403.html');
	exit();
}
require_once 'header.php';
require_once 'sidebar.php';
require_once 'navigation.php';
require_once '../class/Study.php';
require_once '../DAO/StudyDAO.php';


$study = new Study();
$studyDAO = new StudyDAO();
$study = $studyDAO->getByPatient($_SESSION['id']);

?>

<div class="container">
	<div class="right_col" role="main">



		<!-- <div class="container">
			

		</div> -->


		<div class="clearfix"></div>

		<div class="x_panel">
			<div class="x_title">
				<h2>Dados</h2>
				<div class="clearfix"></div>
				<div class="x_content">
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
											<td class="controls" style="padding: 0px">
												<?php
												if ($obj->getFinaliza_laudo()) { ?>
													<a class="btn btn-primary" href="tmpl_laudo.html">
														Laudo
													</a>
												<?php	}
												?>
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




			<!-- <div class="container">
				<div class="table-responsive">

					<table class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">First</th>
								<th scope="col">Last</th>
								<th scope="col">Handle</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Larry</td>
								<td>the Bird</td>
								<td>@twitter</td>
							</tr>
						</tbody>
					</table>




				</div>
			</div> -->
		</div>
	</div>

	<?php
	include 'footer.php';
