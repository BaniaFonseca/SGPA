<?php


class Examerecorrencia {
    
    private $idExameRec;
    private $notaFinal;
    private $notaRec;
    

    public function c_Examerecorrencia($idExameRec, $notaFinal, $notaRec, $estado) {
        $this->idExameRec = $idExameRec;
        $this->notaFinal = $notaFinal;
        $this->notaRec = $notaRec;
        $this->estado = $estado;
    }

    public function getIdExameRec() {
        return $this->idExameRec;
    }

    public function setIdExameRec($idExameRec) {
        $this->idExameRec = $idExameRec;
    }

    public function getNotaFinal() {
        return $this->notaFinal;
    }

    public function setNotaFinal($notaFinal) {
        $this->notaFinal = $notaFinal;
    }

    public function getNotaRec() {
        return $this->notaRec;
    }

    public function setNotaRec($notaRec) {
        $this->notaRec = $notaRec;
    }

    public function getEstado() {
        return $estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }


    public function toString() {
        return "esimop.Examerecorrencia[ idExameRec=" + $this->idExameRec + " ]";
    }
    
}

?>