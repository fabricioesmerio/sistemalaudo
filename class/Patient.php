<?php

class Patient {
    private $pk;
    private $pat_name;
    private $pat_birthdate;
    private $pat_sex;
    private $passwor_web;
    private $registro;

    public function getPk(){
		return $this->pk;
	}

	public function setPk($pk){
		$this->pk = $pk;
	}

	public function getPat_nome(){
		return $this->pat_nome;
	}

	public function setPat_nome($pat_nome){
		$this->pat_nome = $pat_nome;
	}

	public function getPat_birthdate(){
		return $this->pat_birthdate;
	}

	public function setPat_birthdate($pat_birthdate){
		$this->pat_birthdate = $pat_birthdate;
	}

	public function getPat_sex(){
		return $this->pat_sex;
	}

	public function setPat_sex($pat_sex){
		$this->pat_sex = $pat_sex;
	}

	public function getPasswor_web(){
		return $this->passwor_web;
	}

	public function setPasswor_web($passwor_web){
		$this->passwor_web = $passwor_web;
	}

	public function getRegistro(){
		return $this->registro;
	}

	public function setRegistro($registro){
		$this->registro = $registro;
	}
}