<?php

class DocPaciente {
    private $id;
    private $id_paciente;
    private $arquivo;


    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getId_paciente(){
		return $this->id_paciente;
	}

	public function setId_paciente($id_paciente){
		$this->id_paciente = $id_paciente;
	}

	public function getArquivo(){
		return $this->arquivo;
	}

	public function setArquivo($arquivo){
		$this->arquivo = $arquivo;
	}

}