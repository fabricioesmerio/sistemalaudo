<?php

require_once '../Config/functions.php';
require_once '../class/DocPaciente.php';

class DocPacienteDAO {
    
    public function save(DocPaciente $obj) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO public.doc_paciente(id_paciente, arquivo) VALUES (:id_paciente, :arquivo) ');
            $stmt->bindValue(':id_paciente', $obj->getId_paciente(), PDO::PARAM_INT);
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
    
    public function save2(DocPaciente $obj) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO public.doc_paciente(id_paciente, arquivo) VALUES (:id_paciente, :arquivo) ');
            $stmt->bindValue(':id_paciente', $obj->getId_paciente(), PDO::PARAM_INT);
            $stmt->bindValue(':arquivo', $obj->getArquivo(), PDO::PARAM_LOB);
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

    public function getAll() {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stm = $pdo->prepare('SELECT * FROM public.doc_paciente');
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new DocPaciente();
                $return = array();
                while($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->id);
                    $obj->setId_paciente($rs->id_paciente);
                    $obj->setArquivo($rs->arquivo);
                    $return[] = clone $obj;
                }
                return $return;
            }
            return null;
        } catch (PDOException $e) {
            echo 'Erro ao buscar os documentos. <br />. Mensagem: '. $e->getMessage();
            die();
        }
    }
    
    
    public function getById($id) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stm = $pdo->prepare('SELECT * FROM public.doc_paciente WHERE id_paciente = :id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new DocPaciente();
                $return = array();
                while($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->id);
                    $obj->setId_paciente($rs->id_paciente);
                    $obj->setArquivo($rs->arquivo);
                    $return[] = clone $obj;
                }
                return $return;
            }
            return [];
        } catch (PDOException $e) {
            echo 'Erro ao buscar os documentos. <br />. Mensagem: '. $e->getMessage();
            die();
        }
    }


}