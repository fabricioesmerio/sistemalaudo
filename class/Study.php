<?php

class Study {
    private $pk;
    private $patient_fk;
    private $study_datetime;
    private $accession_no;
    private $study_desc;
    private $mods_in_study;
    private $laudo_audio;
    private $laudo_texto;
    private $nomepaciente; /** guarda o nome do paciente nas consultas */

    public function getPk(){
		return $this->pk;
	}

	public function setPk($pk){
		$this->pk = $pk;
	}

	public function getPatient_fk(){
		return $this->patient_fk;
	}

	public function setPatient_fk($patient_fk){
		$this->patient_fk = $patient_fk;
	}

	public function getStudy_datetime(){
		return $this->study_datetime;
	}

	public function setStudy_datetime($study_datetime){
		$this->study_datetime = $study_datetime;
	}

	public function getAccession_no(){
		return $this->accession_no;
	}

	public function setAccession_no($accession_no){
		$this->accession_no = $accession_no;
	}

	public function getStudy_desc(){
		return $this->study_desc;
	}

	public function setStudy_desc($study_desc){
		$this->study_desc = $study_desc;
	}

	public function getMods_in_study(){
		return $this->mods_in_study;
	}

	public function setMods_in_study($mods_in_study){
		$this->mods_in_study = $mods_in_study;
	}

	public function getLaudo_audio(){
		return $this->laudo_audio;
	}

	public function setLaudo_audio($laudo_audio){
		$this->laudo_audio = $laudo_audio;
	}

	public function getLaudo_texto(){
		return $this->laudo_texto;
	}

	public function setLaudo_texto($laudo_texto){
		$this->laudo_texto = $laudo_texto;
	}
	
	public function getNomePaciene(){
		return $this->nomepaciente;
	}

	public function setNomePaciente($nomePaciente){
		$this->nomepaciente = $nomePaciente;
	}
}