<?php

require_once '../DAO/PatientArquivoDAO.php';

if (isset($_POST['idFile'])) {
    $id = filter_input(INPUT_POST, 'idFile', FILTER_SANITIZE_NUMBER_INT);

    $dao = new PatientArquivoDAO();
    if ($dao->delete($id)) {
        $retorno = array('codigo' => 200, 'mensagem' => 'Registro excluído com sucesso!');
        echo json_encode($retorno);
        exit();
    } else {
        $retorno = array('codigo' => 400, 'mensagem' => 'Ocorreu um erro ao excluir!');
        echo json_encode($retorno);
        exit();
    }
}
