<?php

require_once('TipoAvaliacao.class.php');

class Planoavaliacao {
    
    private  $idPlanoAvalicao;
    private $qtMaxAvaliacao;
    private $tipoavaliacao;

    public function c_Planoavaliacao($idPlanoAvalicao, $qtMaxAvaliacao) {
        $this->idPlanoAvalicao = $idPlanoAvalicao;
        $this->qtMaxAvaliacao = $qtMaxAvaliacao;
    }

    public function getIdPlanoAvalicao() {
        return $this->idPlanoAvalicao;
    }

    public function setIdPlanoAvalicao($idPlanoAvalicao) {
        $this->idPlanoAvalicao = $idPlanoAvalicao;
    }

    public function getQtMaxAvaliacao() {
        return $this->qtMaxAvaliacao;
    }

    public function setQtMaxAvaliacao($qtMaxAvaliacao) {
        $this->qtMaxAvaliacao = $qtMaxAvaliacao;
    }

    public function getTipoavaliacao() {
        return $this->tipoavaliacao;
    }

    public function setTipoavaliacao($tipoavaliacao) {
        $this->tipoavaliacao = $tipoavaliacao;
    }
 
    public function toString() {
        return "esimop.Planoavaliacao[ idPlanoAvalicao=" + $idPlanoAvalicao + " ]";
    }
   }

    ?>
	
    