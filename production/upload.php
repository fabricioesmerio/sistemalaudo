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

?>

<div class="container">
    <div class="right_col" role="main">
    <!-- <form method="POST" action="upload.php" id="formUploadFile" enctype="multipart/form-data"> -->
    <div>
      <span>Upload a File:</span>
      <input type="file" id="uploadedFile" name="uploadedFile" />
      <input type="hidden" name="patNumber" value="<?= $idPatient?>">
    </div>
 
    <button type="submit" name="uploadBtn" id="btnUploadFile" >Upload</button>
  <!-- </form> -->

  <?php

// if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
//     $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
//     $fileName = $_FILES['uploadedFile']['name'];
//     $fileSize = $_FILES['uploadedFile']['size'];
//     $fileType = $_FILES['uploadedFile']['type'];
//     $fileNameCmps = explode(".", $fileName);
//     $fileExtension = strtolower(end($fileNameCmps));

//     $idPat = $_POST['patNumber'];

//     $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

//     $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
//     if (in_array($fileExtension, $allowedfileExtensions)) {
//         $uploadFileDir = '../uploads/';
//         $dest_path = $uploadFileDir . $newFileName;
        
//         if(move_uploaded_file($fileTmpPath, $dest_path))
//         {
//             $doc = new DocPaciente();
//             $docDAO = new DocPacienteDAO();
//             $doc->setId_paciente($idPat);
//             $doc->setArquivo($dest_path);
//             if ($docDAO->save($doc)) {
//                 $message ='File is successfully uploaded.'. $idPat;
//             } else {
//                 $message = 'Salvou caralho!';
//             }
//         }
//         else
//         {
//             $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
//         }

//         echo $message;
//         echo '<br />';
//         echo 'destino:: '. $dest_path;
//     }
// }

?>

    </div>
</div>

<?php
} else {
    ?>
<div class="container">
    <div class="right_col" role="main">
        <span>Entrada inválida!. Volte para a lista e selecione um registro.</span>
    </div>
</div>
    <?php
}

?>

<?php
include 'footer.php';

