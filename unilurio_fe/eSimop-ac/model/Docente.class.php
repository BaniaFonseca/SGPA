<?php 

require_once 'GrupoAcesso.class.php';
require_once 'Sexo.class.php';

class Docente{
    
    private $idDocene;
    private $nome;
    private $apelido;
    private $senha;
    private $email;
    private $grupoacesso;
    private $sexo;

    public function c_Docente($idDocene, $nome, $apelido, $senha, $email) {
        $this->idDocene = $idDocene;
        $this->nome = $nome;
        $this->apelido = $apelido;
        $this->senha = $senha;
        $this->email = $email;
    }

    public function getIdDocene() {
        return $this->idDocene;
    }

    public function setIdDocene($idDocene) {
        $this->idDocene = $idDocene;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getApelido() {
        return $this->apelido;
    }

    public function setApelido($apelido) {
        $this->apelido = $apelido;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    

    public function getGrupoacesso() {
        return $this->grupoacesso;
    }

    public function setGrupoacesso($grupoacesso) {
        $this->grupoacesso = $grupoacesso;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
		
        $this->sexo = $sexo;
    }

    public function toString() {
        return "esimop.Docente[ idDocene=" + $this->idDocene + " ]";
    }
    
}
 ?>
 
 
 