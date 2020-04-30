<?php
session_start();
require_once '../Config/functions.php';
require_once '../DAO/UsuarioDAO.php';
require_once '../class/Usuario.php';

// sleep(2);

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

$user = new Usuario();
$userDAO = new UsuarioDAO();
$user = $userDAO->signIn($login, $senha);
// $user = $userDAO->signIn($login, md5($senha));
if ($user != NULL) {
    // if ($user->getStatus() != 1) {
    //     $retorno = array('codigo' => 0, 'mensagem' => 'Usuário sem permissão para acessar o sistema!');
    //     echo json_encode($retorno);
    //     exit();
    // }
    $_SESSION['id'] = $user->getId();
    $_SESSION['nomeUsuario'] = $user->getLogin();
    $_SESSION['tipo'] = "Med";
    $_SESSION['logado'] = TRUE;
    
    $retorno = array('codigo' => 1, 'mensagem' => 'Login efetuado com sucesso!');
        echo json_encode($retorno);
        exit();

} else {
    $retorno = array('codigo' => 0, 'mensagem' => 'O login falhou, verifique os dados e tente novamente!');
    echo json_encode($retorno);
    exit();
}