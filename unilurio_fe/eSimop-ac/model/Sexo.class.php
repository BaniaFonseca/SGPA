<?php 
    class Sexo{
       private $idSexo;
       private $descricao;
      
       public function setIdSexo($idsexo='')
       {
          $this->idSexo =$idsexo;
       }
       public function getIdSexo()
       {
           return $this->idSexo;
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
		   echo('idSexo: '.$this->getIdSexo());
		    echo('<br>idSexo: '.$this->getDescricao());
		   }
      
    }

?>

