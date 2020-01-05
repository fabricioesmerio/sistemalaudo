<?php

//  https://www.youtube.com/watch?v=ut-NcYgFRKI

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

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'docx', 'xlsx');

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
        
            // echo $message;
        } else {
            $retorno = array('codigo' => 0, 'mensagem' => 'Extenção do arquivo não permitida.');
            echo json_encode($retorno);
            exit();
        }
}
