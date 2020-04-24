<?php

class PatientArquivo {
    private $id;
    private $nome;
    private $conteudo;
    private $tamanho;
    private $patient_fk;
    private $mime_type;

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
    }
    
    public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}
    public function getConteudo(){
		return $this->conteudo;
	}

	public function setConteudo($conteudo){
		$this->conteudo = $conteudo;
	}
    public function getTamanho(){
		return $this->tamanho;
	}

	public function setTamanho($tamanho){
		$this->tamanho = $tamanho;
	}
    public function getPatientFk(){
		return $this->patient_fk;
	}

	public function setPatientFk($patient_fk){
		$this->patient_fk = $patient_fk;
	}
    public function getMimeType(){
		return $this->mime_type;
	}

	public function setMimeType($mime_type){
		$this->mime_type = $mime_type;
	}
}