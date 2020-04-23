<?php

require_once '../Config/functions.php';
require_once '../class/PatientArquivo.php';

class PatientArquivoDAO {

    public function save($nome, $mime, $conteudo, $tamanho, $patient) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO public.patient_arquivo(nome, conteudo, tamanho, patient_fk, mime_type) VALUES (:nome, :conteudo, :tamanho, :patient_fk, :mime_type) ');
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':conteudo', $conteudo, PDO::PARAM_LOB);
            $stmt->bindValue(':tamanho', $tamanho);
            $stmt->bindValue(':patient_fk', $patient, PDO::PARAM_INT);
            $stmt->bindValue(':mime_type', $mime);
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
    
    public function getById($id)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT id, nome, conteudo, tamanho, patient_fk, mime_type
                                    FROM public.patient_arquivo
                                    WHERE id = :id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new PatientArquivo();
                $return = null;
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->id);
                    $obj->setNome($rs->nome);
                    $obj->setConteudo($rs->conteudo);
                    $obj->setTamanho($rs->tamanho);
                    $obj->setPatientFk($rs->patient_fk);
                    $obj->setMimeType($rs->mime_type);
                    $return = clone $obj;
                }
                return $return;
            }
            return null;
        } catch (PDOException $e) {
            echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
            die();
        }
    }
    
    public function getByPatient($pat)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT id, nome, conteudo, tamanho, patient_fk, mime_type
                                    FROM public.patient_arquivo
                                    WHERE patient_fk = :id');
            $stm->bindValue(':id', $pat, PDO::PARAM_INT);
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new PatientArquivo();
                $return = array();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setId($rs->id);
                    $obj->setNome($rs->nome);
                    $obj->setConteudo($rs->conteudo);
                    $obj->setTamanho($rs->tamanho);
                    $obj->setPatientFk($rs->patient_fk);
                    $obj->setMimeType($rs->mime_type);
                    $return[] = clone $obj;
                }
                return $return;
            }
            return null;
        } catch (PDOException $e) {
            echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
            die();
        }
    }
}