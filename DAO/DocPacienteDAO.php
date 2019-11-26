<?php

require_once '../Config/functions.php';
require_once '../class/DocPaciente.php';

class DocPacienteDAO {
    
    public function save(DocPaciente $obj) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO public.doc_paciente(:id_paciente, :arquivo) VALUES (:id_paciente, :arquivo) ');
            $stmt->bindValue(':id_paciente', $obj->getId_paciente());
            $stmt->bindValue(':arquivo', $obj->getArquivo());
            $stmt->execute();
            if ($stmt->rowCount()) {
                $pdo->commit();
                return true;
            }
            $pdo->rollBack();
            return false;
        } catch (PDOException $e) {
            echo 'Erro ao salvar o documento. <br />. Mensagem: '. $e->getMessage();
            $pdo->rollBack();
            die();
        }
    }
}