<?php

require_once '../DAO/DocPacienteDAO.php';
require_once '../class/DocPaciente.php';


if (0 < $_FILES['file']['error']) {
    $retorno = array('codigo' => 0, 'mensagem' => 'Deu erro.');
    echo json_encode($message);
    exit();
} else {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');

    if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = '../uploads/';
            $dest_path = $uploadFileDir . $newFileName;
                
            if(move_uploaded_file($fileTmpPath, $dest_path))
            {
                $retorno = array('codigo' => 1, 'mensagem' => 'File is successfully uploaded.', 'path' => $dest_path);
                echo json_encode($retorno);
                exit();
            }
            else
            {
                $retorno = array('codigo' => 0, 'mensagem' => 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.');
                echo json_encode($retorno);
                exit();
            }
        
            echo $message;
        }
}

// if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
//     $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
//     $fileName = $_FILES['uploadedFile']['name'];
//     $fileSize = $_FILES['uploadedFile']['size'];
//     $fileType = $_FILES['uploadedFile']['type'];
//     $fileNameCmps = explode(".", $fileName);
//     $fileExtension = strtolower(end($fileNameCmps));

//     $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

//     $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
//     if (in_array($fileExtension, $allowedfileExtensions)) {
//         $uploadFileDir = '../uploads/';
//         $dest_path = $uploadFileDir . $newFileName;
        
//         if(move_uploaded_file($fileTmpPath, $dest_path))
//         {
//             $retorno = array('codigo' => 0, 'mensagem' => 'File is successfully uploaded.');
//             echo json_encode($message);
//             exit();
//         }
//         else
//         {
//             $retorno = array('codigo' => 0, 'mensagem' => 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.');
//             echo json_encode($retorno);
//             exit();
//         }

//         echo $message;
//     }
// }