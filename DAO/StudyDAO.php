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
}
