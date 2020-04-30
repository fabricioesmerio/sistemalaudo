<?php
require_once '../Config/functions.php';
require_once '../class/Study.php';

class StudyDAO
{
    public function getListStudy($term, $limit, $offset)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT public.study.pk, public.study.patient_fk, public.study.study_datetime, public.study.accession_no,
            public.study.study_desc, public.study.laudo_audio, public.study.laudo_texto, public.patient.pat_name AS NomePaciente
                FROM public.study
                JOIN public.patient ON public.patient.pk = public.study.patient_fk
                ORDER BY public.study.study_datetime DESC
				LIMIT :limit OFFSET :offset');
            $stm->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
            // SELECT * FROM tabela Where data_entrevista::date >= CURRENT_DATE
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Study();
                $return = array();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
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
            echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
            die();
        }
    }

    public function getListStudyTerm($term, $limit, $offset)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare("SELECT public.study.pk, public.study.patient_fk, public.study.study_datetime, public.study.accession_no,
            public.study.study_desc, public.study.laudo_audio, public.study.laudo_texto, public.patient.pat_name AS NomePaciente
                FROM public.study
                JOIN public.patient ON public.patient.pk = public.study.patient_fk
				WHERE public.patient.pat_name ilike :term
                	OR public.study.pk::text ilike :term
                	OR public.study.study_desc ilike :term
				ORDER BY public.study.study_datetime DESC");
            $stm->bindValue(':term', '%' . $term . '%');
            // $stm->bindValue(':limit', $limit, PDO::PARAM_INT);
            // $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
            // SELECT * FROM tabela Where data_entrevista::date >= CURRENT_DATE
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Study();
                $return = array();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
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
            echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
            die();
        }
    }

    public function getListStudyByDate($date)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare("SELECT public.study.pk, public.study.patient_fk, public.study.study_datetime, public.study.accession_no,
            public.study.study_desc, public.study.laudo_audio, public.study.laudo_texto, public.patient.pat_name AS NomePaciente
                FROM public.study
                JOIN public.patient ON public.patient.pk = public.study.patient_fk
				WHERE public.study.study_datetime::text >= :date
				ORDER BY public.study.study_datetime DESC");
            $stm->bindValue(':date', $date);
            // $stm->bindValue(':limit', $limit, PDO::PARAM_INT);
            // $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
            // SELECT * FROM tabela Where data_entrevista::date >= CURRENT_DATE
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Study();
                $return = array();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
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
            echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
            die();
        }
    }

    public function getCountTotal()
    {
        $pdo = connectdb();
        try {
            $stmt = $pdo->prepare('SELECT COUNT(pk) AS TOTAL FROM public.study');
            $stmt->execute();
            $count = 0;
            if ($stmt->rowCount()) {
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $count = $rs->total;
                }
            }
            return $count;
        } catch (PDOException $e) {
            echo 'Erro ao buscar o contador. <br /> Mensagem: ' . $e->getMessage();
        }
    }

    /**
     * COUNT BY TERM
     *
     *
     * select count(public.study.pk)
     * from public.study
     * JOIN public.patient ON public.patient.pk = public.study.patient_fk
     * where public.study.study_desc ilike '%320%'
     * or public.study.pk::text ilike '%320%'
     * or public.patient.pat_name ilike '%320%';
     */

	 
    /**
     * COUNT BY DATE
     *
     *
     * select count(public.study.pk) 
	 * from public.study
	 * JOIN public.patient ON public.patient.pk = public.study.patient_fk
	 * WHERE public.study.study_datetime::text >= '2020-01-01';
     */

    public function getById($id)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT st.pk, st.patient_fk, st.study_datetime, st.accession_no,
            st.study_desc, st.laudo_audio, st.laudo_texto, st.finaliza_laudo, pt.pat_name AS NomePaciente
                FROM public.study st
                JOIN public.patient pt
                ON st.patient_fk = pt.pk
                WHERE st.pk = :id');
            $stm->bindValue(':id', $id);
            $stm->execute();
            if ($stm->rowCount() >= 1) {
                $obj = new Study();
                $return = null;
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
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
            echo 'Erro ao buscar. <br /> Mensagem: ' . $e->getMessage();
            die();
        }
    }
    
    
    public function getByPatient($id)
    {
        $pdo = connectdb();
        try {
            $stm = $pdo->prepare('SELECT st.pk, st.patient_fk, st.study_datetime, st.accession_no,
            st.study_desc, st.laudo_audio, st.laudo_texto, st.finaliza_laudo, pt.pat_name AS NomePaciente
                FROM public.study st, st.patient_fk
                WHERE st.patient_fk = :id');
            $stm->bindValue(':id', $id);
            $stm->execute();
            if ($stm->rowCount()) {
                $obj = new Study();
                $return = array();
                while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                    $obj->setPk($rs->pk);
                    $obj->setPatient_fk($rs->patient_fk);
                    $obj->setStudy_datetime($rs->study_datetime);
                    $obj->setAccession_no($rs->accession_no);
                    $obj->setStudy_desc($rs->study_desc);
                    $obj->setLaudo_texto($rs->laudo_texto);
                    $obj->setLaudo_audio($rs->laudo_audio);
                    $obj->setNomePaciente($rs->nomepaciente);
                    $obj->setFinaliza_laudo($rs->finaliza_laudo);
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

    public function save(Study $obj)
    {
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
            echo 'Erro ao salvar o documento. <br />. Mensagem: ' . $e->getMessage();
            $pdo->rollBack();
            die();
        }
    }

    public function saveLaudo(Study $obj)
    {
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
            echo 'Erro ao salvar o documento. <br />. Mensagem: ' . $e->getMessage();
            $pdo->rollBack();
            die();
        }
    }
}
