<?php


class Tipoavaliacao{
    
    private $idTipoAvaliacao;
    private $descricao;
    private $peso;
 


    public function c_Tipoavaliacao($idTipoAvaliacao, $descricao, $peso) {
        $this->idTipoAvaliacao = $idTipoAvaliacao;
        $this->descricao = $descricao;
        $this->peso = $peso;
    }

    public function getIdTipoAvaliacao() {
        return $this->idTipoAvaliacao;
    }

    public function setIdTipoAvaliacao($idTipoAvaliacao) {
        $this->idTipoAvaliacao = $idTipoAvaliacao;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

  
    public function toString() {
        return "esimop.Tipoavaliacao[ idTipoAvaliacao=" + $this->idTipoAvaliacao + " ]";
    }
    
}
?>

