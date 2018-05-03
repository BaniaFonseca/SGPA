<?php

require_once ('Faculdade.class.php');

class Curso {
    
    
    private $idCurso;
    private $codigoCurso;
    private $descricao;
    private $qtdSemestres;
    private $faculdade;
  
    public function c_construtorCurso($codCurso, $descricao, $qtdSemestre, $facul) {
        $this->codigoCurso = $codCurso;
		$this->descricao=$descricao;
		$this->qtdSemestres=$qtdSemestre;
		$this->faculdade=$facul;
    }

    public function getIdCurso() {
        return $this->idCurso;
    }

    public function setIdCurso($idCurso) {
        $this->idCurso = $idCurso;
    }

    public function getCodigoCurso() {
        return $codigoCurso;
    }

    public function setCodigoCurso($codigoCurso) {
        $this->codigoCurso = $codigoCurso;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getQtdSemestres() {
        return $this->qtdSemestres;
    }

    public function setQtdSemestres($qtdSemestres) {
        $this->qtdSemestres = $qtdSemestres;
    }

    public function getFaculdade() {
        return $this->faculdade;
    }

    public function setFaculdade($faculdade) {
        $this->faculdade = $faculdade;
    }

    
    public function toString() {
        return "esimop.Curso[ idCurso=" + $this->idCurso + " ]";
    }
    
}
?>

<?php


?>