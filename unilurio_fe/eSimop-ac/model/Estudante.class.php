<?php

require_once ('Curso.class.php');
require_once('Sexo.class.php');

class Estudante {
   
    private $idEstudante;
    private $nrEstudante;
    private $nome;
    private $apelido;
    private $nivelFrequencia;
    private $email;
    private $bolsa;
    private $sexo;
    private $curso;
    private $grupoacesso;

    public function c_Estudante($nrEstudante, $nome, $apelido,$nivelf,$email,$bolsa, $sexo,$curso, $grupo) {
        $this->nrEstudante = $nrEstudante;
    }

    public function getIdEstudante() {
        return $this->idEstudante;
    }

    public function setIdEstudante($idEstudante) {
        $this->idEstudante = $idEstudante;
    }

    public function getNrEstudante() {
        return $this->nrEstudante;
    }

    public function setNrEstudante($nrEstudante) {
        $this->nrEstudante = $nrEstudante;
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

    public function getNivelFrequencia() {
        return $this->nivelFrequencia;
    }

    public function setNivelFrequencia($nivelFrequencia) {
        $this->nivelFrequencia = $nivelFrequencia;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getBolsa() {
        return $this->bolsa;
    }

    public function setBolsa($bolsa) {
        $this->bolsa = $bolsa;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function getGrupoacesso() {
        return $this->grupoacesso;
    }

    public function setGrupoacesso($grupoacesso) {
        $this->grupoacesso = $grupoacesso;
    }

    
    public function toString() {
        return "esimop.Estudante[ idEstudante=" + $this->idEstudante + " ]";
    }
    
}
