<?php 

class Faculdade {
	
	private $idFacul;
    private $descricao;
    
    public function setIdFacul($idfacul='')
       {
          $this->idFacul =$idfacul;
       }
       public function getIdFacul()
       {
           return $this->idFacul;
       }
       
       public function setDescricao($descricao='')
       {
          $this->descricao =$descricao;
       }
       public function getDescricao()
       {
           return $this->descricao;
       }
       
       public function toString(){
           echo('idFacul: '.$this->getIdeFacul);
            echo('<br>Nome: '.$this->getDescricao());
           }
    }

 ?>