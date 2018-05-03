<?php
require_once ('Date.php');
require_once ('String.php');
require_once ('PautaNormal.class.php');

class Avaliacaofrequencia{
    
    private $idPautaNormal;
    private $mediaFrequencia;
    private $dataReg;
    private $resultadoQualitativo;
    private $pautanormal;

   

    public function c_Avaliacaofrequencia($idPautaNormal, $mediaFrequencia, $dataReg, $resultadoQualitativo) {
        $this->idPautaNormal = $idPautaNormal;
        $this->mediaFrequencia = $mediaFrequencia;
        $this->dataReg = $dataReg;
        $this->resultadoQualitativo = $resultadoQualitativo;
    }

    public function getIdPautaNormal() {
        return $this->idPautaNormal;
    }

    public function setIdPautaNormal($idPautaNormal) {
        $this->idPautaNormal = $idPautaNormal;
    }

    public function getMediaFrequencia() {
        return $this->mediaFrequencia;
    }

    public function setMediaFrequencia($mediaFrequencia) {
        $this->mediaFrequencia = $mediaFrequencia;
    }

    public function getDataReg() {
        return $this->dataReg;
    }

    public function setDataReg($dataReg) {
        $this->dataReg = $dataReg;
    }

    public function getResultadoQualitativo() {
        return $this->resultadoQualitativo;
    }

    public function setResultadoQualitativo($resultadoQualitativo) {
        $this->resultadoQualitativo = $resultadoQualitativo;
    }

    public function getPautanormal() {
        return $this->pautanormal;
    }

    public function setPautanormal($pautanormal) {
        $this->pautanormal = $pautanormal;
    }

    public function toString() {
        return "esimop.Avaliacaofrequencia[ idPautaNormal=" + $this->idPautaNormal + " ]";
    }
}
    
?>