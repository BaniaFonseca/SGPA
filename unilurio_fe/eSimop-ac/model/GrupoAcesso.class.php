<?php
 
 require_once('Docente.class.php');
 require_once('Estudante.class.php');
  
 class Grupoacesso{
    
    private $idgrupo;
    private $descricao;
    private $estudante;

    public function c_Grupoacesso($idgrupo, $descricao) {
        $this->idgrupo = $idgrupo;
        $this->descricao = $descricao;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getEstudante() {
        return $this->estudante;
    }

    public function setEstudante($estudante) {
        $this->estudante = $estudante;
    }

    public function getDocente() {
        return $this->docente;
    }

    public function setDocente($docente) {
        $this->docente = $docente;
    }

    public function toString() {
        return "esimop.Grupoacesso[ idgrupo=" + $this->idgrupo + " ]";
    }
    
}

?>