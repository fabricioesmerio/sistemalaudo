<?php
require_once '../Config/functions.php';
require_once '../class/Study.php';


class StudyDAO {
    public function getListStudy() {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT public.study.pk, public.study.patient_fk, public.study.study_datetime, public.study.accession_no, 
            public.study.study_desc, public.study.laudo_audio, public.study.laudo_texto, public.patient.pat_name AS NomePaciente
                FROM public.study, public.patient
                WHERE public.study.patient_fk = public.patient.pk');
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Study();
                $return = array();
                while($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setPk($rs->pk);
                    $obj->setPatient_fk($rs->patient_fk);
                    $obj->setStudy_datetime($rs->study_datetime);
                    $obj->setAccession_no($rs->accession_no);
                    $obj->setStudy_desc($rs->study_desc);
                    $obj->setLaudo_texto($rs->laudo_texto);
                    $obj->setNomePaciente($rs->nomepaciente);
                    $return[] = clone $obj;
                }
                return $return;
            }
            return null;
        } catch (PDOException $e) {
            echo 'Erro ao buscar. <br /> Mensagem: '. $e->getMessage();
            die();
        }
    }
    
    public function getById($id) {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT public.study.pk, public.study.patient_fk, public.study.study_datetime, public.study.accession_no, 
            public.study.study_desc, public.study.laudo_audio, public.study.laudo_texto, public.study.finaliza_laudo, public.patient.pat_name AS NomePaciente
                FROM public.study, public.patient
                WHERE public.study.pk = :id');
            $stm->bindValue(':id', $id);
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Study();
                $return = null;
                while($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setPk($rs->pk);
                    $obj->setPatient_fk($rs->patient_fk);
                    $obj->setStudy_datetime($rs->study_datetime);
                    $obj->setAccession_no($rs->accession_no);
                    $obj->setStudy_desc($rs->study_desc);
                    $obj->setLaudo_texto($rs->laudo_texto);
                    $obj->setLaudo_audio($rs->laudo_audio);
                    $obj->setNomePaciente($rs->nomepaciente);
                    $obj->setFinaliza_laudo($rs->finaliza_laudo);
                    $return = clone $obj;
                }
                return $return;
            }
            return null;
        } catch (PDOException $e) {
            echo 'Erro ao buscar. <br /> Mensagem: '. $e->getMessage();
            die();
        }
    }

    public function save(Study $obj) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('UPDATE public.study SET laudo_audio = :audio, laudo_texto = :laudo WHERE pk = :pk');
            $stmt->bindValue(':pk', $obj->getPk(), PDO::PARAM_INT);
            $stmt->bindValue(':laudo', $obj->getLaudo_texto(), PDO::PARAM_INT);
            $stmt->bindValue(':audio', $obj->getLaudo_audio());
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
    
    public function saveLaudo(Study $obj) {
        $pdo = connectdb();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('UPDATE public.study SET laudo_texto = :laudo, finaliza_laudo = :finLaudo WHERE pk = :pk');
            $stmt->bindValue(':pk', $obj->getPk(), PDO::PARAM_INT);
            $stmt->bindValue(':laudo', $obj->getLaudo_texto());
            $stmt->bindValue(':finLaudo', $obj->getFinaliza_laudo(), PDO::PARAM_BOOL);
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
