<?php
require_once ('Date.php');
require_once ('String.php');
require_once ('PautaNormal.class.php');
require_once ('ExameRecorrencia.php');
require_once ('AvaliacaoFrequencia.class.php');

class Avaliacaoexame {
    
    private $notaExame;
    private $notafinal;
    private $dataReg;
    private $resultadoQualit;
    private $examerecorrencia;
    private $avaliacaofrequencia;

    function __construct($notaExame, $notafinal, $dataReg, $resultadoQualit, $examerecorrencia, $avaliacaofrequencia)
    {
        $this->notaExame = $notaExame;
        $this->notafinal = $notafinal;
        $this->dataReg = $dataReg;
        $this->resultadoQualit = $resultadoQualit;
        $this->examerecorrencia = $examerecorrencia;
        $this->avaliacaofrequencia = $avaliacaofrequencia;
    }


    public function c_Avaliacaoexame($avaliacaoexamePK, $notaExame, $notafinal, $dataReg, $resultadoQualit) {
        $this->avaliacaoexamePK = $avaliacaoexamePK;
        $this->notaExame = $notaExame;
        $this->notafinal = $notafinal;
        $this->dataReg = $dataReg;
        $this->resultadoQualit = $resultadoQualit;
    }

    public function getNotaExame() {
        return $this->notaExame;
    }

    public function setNotaExame($notaExame) {
        $this->notaExame = $notaExame;
    }

    public function getNotafinal() {
        return $this->notafinal;
    }

    public function setNotafinal($notafinal) {
        $this->notafinal = $notafinal;
    }

    public function getDataReg() {
        return $this->dataReg;
    }

    public function setDataReg($dataReg) {
        $this->dataReg = $dataReg;
    }

    public function getResultadoQualit() {
        return $this->resultadoQualit;
    }

    public function setResultadoQualit($resultadoQualit) {
        $this->resultadoQualit = $resultadoQualit;
    }

    public function getExamerecorrencia() {
        return $this->examerecorrencia;
    }

    public function setExamerecorrencia($examerecorrencia) {
        $this->examerecorrencia = $examerecorrencia;
    }

    public function getAvaliacaofrequencia() {
        return $this->avaliacaofrequencia;
    }

    public function setAvaliacaofrequencia($avaliacaofrequencia) {
        $this->avaliacaofrequencia = $avaliacaofrequencia;
    }

    public function toString() {
        return "esimop.Avaliacaoexame[ avaliacaoexamePK=" + $this->avaliacaoexamePK + " ]";
    }
    
}
?>