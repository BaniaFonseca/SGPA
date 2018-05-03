<?php 
    class EstudanteNota{
		
		
       private $iDputaNormal;
       private $nota;
      
	  public function init($idpn='', $nota=''){
			$this->iDputaNormal =$idpn;
			$this->iDputaNormal =$nota;
		}
		
       public function setIdSexo($idpn='')
       {
          $this->iDputaNormal =$idpn;
       }
	   
       public function getIDpautaNormal()
       {
           return $this->iDputaNormal;
       }
       
       public function setNota($nota='')
       {
          $this->iDputaNormal =$nota;
       }
	   
       public function getNota()
       {
           return $this->nota;
       }
	   
	   public function toString(){
		   echo('idSexo: '.$this->getIDpautaNormal());
		    echo('<br>idSexo: '.$this->getNota());
		   }
      
    }

?>

