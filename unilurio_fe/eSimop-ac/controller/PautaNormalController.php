<?php

	require_once '../functions/Conexao.php';

	require_once '../model/PautaNormal.class.php';
?>

<?php

   global $mydb;

   class PautaNormalController{


       public function read($id){
		   $mydb = new mySQLConnection();
		   if ($mydb){

			   $query= "SELECT * FROM pautaNormal WHERE idpautaNormal ={$id}";
			   $result_set = mysqli_query($mydb->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);
		   return($found);

		   }else{
			   return(false);
			   }

		$mydb->closeDatabase();
       }

       public function insert($idDisp,$avaliacao, $curso,$estado){

             $mydb = new mySQLConnection();

             $query = "INSERT INTO `pautanormal`(`idDisciplina`, `idTipoAvaliacao`, `idcurso`, `estado`, `dataReg`) VALUES (?,?,?,?, now())";

             $stmt = mysqli_prepare($mydb->openConection(),$query);
             $result = mysqli_stmt_bind_param($stmt,'iiii',$idDisp,$avaliacao,$curso, $estado);

            if ( mysqli_stmt_execute($stmt)){

                echo 'Sucesso primeira insert de pauta';

             }else{
                   echo 'Problemas no insert de pauta';


             }
             $mydb->closeDatabase();
       }

       public function update($estado, $idpauta){

		   $mydb = new mySQLConnection();
		   $query = "UPDATE `pautanormal` SET `estado`= ?,`dataPub`= now() WHERE `idPautaNormal`= ?";

		   $stmt = mysqli_prepare($mydb->openConection(),$query);
		   $result = mysqli_stmt_bind_param($stmt,'ii',$estado, $idpauta);
		   if (mysqli_stmt_execute($stmt)){
		   		echo('Pauta publicada com sucesso');
		   }else{
			   echo('Nao foi possivel publicar a pauta');
			 }
		 $mydb->closeDatabase();

       }

       public function delete($id){

		   	 $mydb = new mySQLConnection();

		     $query = "DELETE FROM `pautanormal` WHERE `idPautaNormal`= ?";
		     if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
			   $result = mysqli_stmt_bind_param($stmt,'i',$id);
			   if(mysqli_stmt_execute($stmt)){
					echo('removido com sucesso!');
		  	   }else{
			   		echo('problemas na remocao!');
			   }
		    $mydb->closeDatabase();
           }
       }

       public function selectAll(){

		   $mydb = new mySQLConnection();
		   $query= "SELECT * FROM pautaNormal";
		   $result_set = mysqli_query($mydb->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){

				echo $row['classificacao'];
			}

       }
       public function getMaxRowValue(){
		   $mydb = new mySQLConnection();
		   $query = "SELECT MAX(pautanormal.idPautaNormal) as contador FROM pautanormal;";

		   $result_set = mysqli_query($mydb->openConection(),$query);
		   if ($row = mysqli_fetch_assoc($result_set)){

	                   return  $row['contador'];
	              }
		$mydb->closeDatabase();
	}

   }

?>

<?php
	$var = new  PautaNormalController();
	//$var->update(2,40);

?>
