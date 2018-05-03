<?php

	require_once '../functions/Conexao.php';

	require_once '../model/PautaNormal.class.php';
	require_once '../model/EstudanteNota.class.php';
    require_once("../controller/QueryController.php");
    $query = new QuerySql();
?>


<?php

   global $mydb;

   class EstudanteNotaController{

       public function read($id){
		   $mydb = new mySQLConnection();
		   if ($mydb){

			   $query= "SELECT * FROM estudante_nota WHERE idPautaNormal={$id}";
			   $result_set = mysqli_query($mydb->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);
		   return(print_r($found));

		   }else{
			   return(false);
			   }

		$mydb->closeDatabase();
       }


	   //In this Place use this form

	    public function insertF1($idp, $nota, $idestd){

		   $mydb = new mySQLConnection();
 		   $query = "INSERT INTO estudante_nota(nota, idPautaNormal, idEstudante) VALUES (?,?,?)";

		   $stmt = mysqli_prepare($mydb->openConection(),$query);
		   mysqli_stmt_bind_param($stmt,'dii',$nota, $idp,$idestd);

    	   if (mysqli_stmt_execute($stmt)){
		   		echo('Nota inserida com sucesso<br>');
		   }else{
			   echo('insucesso na insercao de nota<br>');
			 }
	   }


       /*actualuza nota estudante*/

       public function update($idNota, $nota){

          $mydb = new mySQLConnection();

           $query = "UPDATE estudante_nota SET nota = ? WHERE idNota = ?";
           $stmt = mysqli_prepare($mydb->openConection(),$query);
           $result = mysqli_stmt_bind_param($stmt,'id',$idNota, $nota);
           if (mysqli_stmt_execute($stmt)){

                echo('Nota actualizada com sucesso para ['.$nota.']');
           }else{
               echo('Nao foi possivel publicar a pauta');
             }
         $mydb->closeDatabase();

       }

       public function delete($id){

		   	 $mydb = new mySQLConnection();

		     $query = "DELETE FROM `estudante_nota` WHERE `idPautaNormal`= ?";
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
		   $query= "SELECT * FROM `estudante_nota`";
		   $result_set = mysqli_query($mydb->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){
				echo $row['nota'];
			}

       }
   }

?>

<?php

	 $var = new EstudanteNotaController();
	 //$var->update(83, 19);

?>