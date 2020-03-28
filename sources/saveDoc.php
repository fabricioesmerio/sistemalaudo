<?php

session_start();
require_once '../Config/functions.php';
require_once '../DAO/DocPacienteDAO.php';
require_once '../class/DocPaciente.php';

$id = (isset($_POST['id']) ? addslashes(filter_input(INPUT_POST, 'id')) : '');
$path = (isset($_POST['path']) ? addslashes(filter_input(INPUT_POST, 'path')) : '');

if ($id == '') { return; }
$doc = new DocPaciente();
$docDAO = new DocPacienteDAO();

$doc->setId_paciente($id);
$doc->setArquivo($path);

if ($docDAO->save($doc)) {
    $allDoc = new DocPaciente();
    $allDoc = $docDAO->getById($id);
    echo json_encode($allDoc);

    // $retorno = array('codigo' => 1, 'mensagem' => 'Arquivo salvo com sucesso!', 'data' => $allDoc);
    // $retorno = array();
    // $retorno = $docDAO->getById($id);
    // echo json_encode($retorno);
    exit();
} else {
    $retorno = array('codigo' => 2, 'mensagem' => 'Ocorreu um erro ao salvar o arquivo!');
    echo json_encode($retorno);
    exit();
}


