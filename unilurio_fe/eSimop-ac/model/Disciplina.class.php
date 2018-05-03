<?php 

class Disciplina {
    
    private $idDisciplina;
    private $decricao;
    private $areaCientifica;
    private $nivel;
    private $semestre;
    private $credito;
    private $departamento;
    private $idCurso;

    public function c_Disciplina($idDisciplina, $decricao) {
        $this->idDisciplina = $idDisciplina;
        $this->decricao = $decricao;
    }

    public function getIdDisciplina() {
        return $this->idDisciplina;
    }

    public function setIdDisciplina($idDisciplina) {
        $this->idDisciplina = $idDisciplina;
    }

    public function getDecricao() {
        return $this->decricao;
    }

    public function setDecricao($decricao) {
        $this->decricao = $decricao;
    }

    public function getAreaCientifica() {
        return $this->areaCientifica;
    }

    public function setAreaCientifica($areaCientifica) {
        $this->areaCientifica = $areaCientifica;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    public function getCredito() {
        return credito;
    }

    public function setCredito($credito) {
        $this->credito = $credito;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getIdCurso() {
        return $this->idCurso;
    }

    public function setIdCurso($idCurso) {
        $this->idCurso = $idCurso;
    }

    public function toString() {
        return "esimop.Disciplina[ idDisciplina=" +$this->VidDisciplina + " ]";
    }
 }

 ?>