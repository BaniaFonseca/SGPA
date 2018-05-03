<?php

require_once ('Curso.class.php');
require_once ('TipoAvaliacao.class.php');

class Pautanormal {
   
    private $idPautaNormal;
    private $classificacao;
    private $estado;
    private $dataReg;
    private $avaliacaofrequencia;
    private $tipoavaliacao;
    private $curso;


    public function c_Pautanormal($idPautaNormal, $classificacao, $estado, $dataReg) {
        $this->idPautaNormal = $idPautaNormal;
        $this->classificacao = $classificacao;
        $this->estado = $estado;
        $this->dataReg = $dataReg;
    }

    public function getIdPautaNormal() {
        return $this->idPautaNormal;
    }

    public function setIdPautaNormal($idPautaNormal) {
        $this->idPautaNormal = $idPautaNormal;
    }

    public  function getClassificacao() {
        return $this->classificacao;
    }

    public function setClassificacao($classificacao) {
        $this->classificacao = $classificacao;
    }

    public function getEstado() {
        return $this->estado;
    }

    public  function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getDataReg() {
        return $this->dataReg;
    }

    public function setDataReg($dataReg) {
        $this->dataReg = $dataReg;
    }

    public function getAvaliacaofrequencia() {
        return $this->avaliacaofrequencia;
    }

    public function setAvaliacaofrequencia($avaliacaofrequencia) {
        $this->avaliacaofrequencia = $avaliacaofrequencia;
    }

    public  function getTipoavaliacao() {
        return $this->tipoavaliacao;
    }

    public function setTipoavaliacao($tipoavaliacao) {
        $this->tipoavaliacao = $tipoavaliacao;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }


    public function toString() {
        return "esimop.Pautanormal[ idPautaNormal=" + $this->idPautaNormal + " ]";
    }
    
}
?>