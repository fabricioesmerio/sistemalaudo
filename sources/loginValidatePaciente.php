<?php

require_once '../Config/functions.php';
require_once '../DAO/PatientDAO.php';
require_once '../class/Patient.php';

$login = (isset($_POST['login']) ? addslashes(filter_input(INPUT_POST, 'login')) : '');
$senha = (isset($_POST['senha']) ? addslashes(filter_input(INPUT_POST, 'senha')) : '');

if (empty($login)) {
    $retorno = array('codigo' => 2, 'mensagem' => 'Seu login não deve ficar em branco!');
    echo json_encode($retorno);
    exit();
}

if (empty($senha)) {
    $retorno = array('codigo' => 2, 'mensagem' => 'Sua senha não deve ficar em branco!');
    echo json_encode($retorno);
    exit();
}

$patient = new Patient();
$patientDAO = new PatientDAO();