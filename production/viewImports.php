<?php

require_once '../class/PatientArquivo.php';
require_once '../DAO/PatientArquivoDAO.php';
require_once '../Config/functions.php';

if(isset($_GET['fileId'])) {

    $id = filter_input(INPUT_GET,'fileId', FILTER_SANITIZE_NUMBER_INT);

    // $patFile = new PatientArquivo();
    // $patFileDAO = new PatientArquivoDAO();

    
    // $patFile = $patFileDAO->getById($fileId);
    
    // $stream = $this->pdo->pgsqlLOBOpen($patFile->getConteudo(), 'r');
    
    // header("Content-type: " . $patFile->getMimeType());
    // fpassthru($patFile->getConteudo());
    
    // echo $patFile->getConteudo();
    try {
    $pdo = connectdb();

    $pdo->beginTransaction();

    $stmt = $pdo->prepare('SELECT id, nome, conteudo, tamanho, patient_fk, mime_type
                            FROM public.patient_arquivo
                            WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);;
    $stmt->execute();

    // echo $stmt->rowCount() . '<br />';

    // $stmt->bindColumn('mime_type', \PDO::PARAM_STR);
    // $stmt->bindColumn('nome', \PDO::PARAM_STR);
    // $stmt->bindColumn('tamanho', \PDO::PARAM_INT);
    // $stmt->bindColumn('patient_fk', \PDO::PARAM_INT);
    // $stmt->bindColumn('conteudo', \PDO::PARAM_STR);

    if ($stmt->rowCount()) {
        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
            
            $nome = $rs->nome;
            $fileData = $rs->conteudo;
            $tamanho = $rs->tamanho;
            $patient_fk = $rs->patient_fk;
            $mime_type = $rs->mime_type;
        }
    }

    // var_dump($fileData);

} catch (PDOException $e) {
    echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
    die();
}

    // $stream = $pdo->pgsqlLOBOpen($fileData, 'r');

    header("Content-type: " . $mime_type);
    fpassthru($fileData);


}