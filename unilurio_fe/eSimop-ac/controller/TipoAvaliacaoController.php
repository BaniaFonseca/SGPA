<?php

    require_once '../functions/Conexao.php';

    require_once '../model/Sexo.class.php';
?>

<?php

   global $mydb;

   class TipoAvaliacaoController{


       public function read($id){
           $mydb = new mySQLConnection();
           if ($mydb){

               $query= "SELECT * FROM `docente` WHERE idDocente ={$id}";
               $result_set = mysqli_query($mydb->openConection(),$query);
               $found = mysqli_fetch_assoc($result_set);
           return($found);

           }else{
               return(false);
               }

        $mydb->closeDatabase();
       }

       public function insert($avaliacao,$discp,$qtd){

           $mydb = new mySQLConnection();

           $query = "INSERT INTO `tipoavaliacao`(`idTipoAvaliacao`, `idDisciplina`, `qtdMaxAvaliacao`)
                                VALUES (?,?,?)";

           $stmt = mysqli_prepare($mydb->openConection(),$query);
           $result = mysqli_stmt_bind_param($stmt,'iii',$avaliacao,$discp,$qtd);

           if(mysqli_stmt_execute($stmt)){
                echo('registado com sucesso!<br>');
           }else{
                echo('problemas na insercao!<br>');
           }
           $mydb->closeDatabase();

       }

       public function update($peso, $id){

              $mydb = new mySQLConnection();

               $query = "UPDATE tipoavaliacao SET peso = ? WHERE idTipoAvaliacao = ?";
               $stmt = mysqli_prepare($mydb->openConection(),$query);
               $result = mysqli_stmt_bind_param($stmt,'ii',$peso,$id);

               if(mysqli_stmt_execute($stmt)){
                    echo('Actualizado com Sucesso!<br>');

               }else{
                   echo('Problemas na codigo!<br>');
               }
            $mydb->closeDatabase();
       }

       public function delete($id){

             $mydb = new mySQLConnection();

             $query = "DELETE FROM `tipoavaliacao` WHERE `idTipoAvaliacao`= ?";
             if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'i',$id);
               if(mysqli_stmt_execute($stmt)){
                    echo('Plano removido com sucesso!');
               }else{
                    echo('problemas na remocao!');
               }
            $mydb->closeDatabase();
           }
       }

       public function selectAll(){

           $mydb = new mySQLConnection();
           $query= "SELECT * FROM tipoavaliacao";
           if ($mydb){
              $result_set = mysqli_query($mydb->openConection(),$query);
           }
        return($result_set);

       }
   }

?>

<?php
$plano = new TipoAvaliacaoController();


//$plano->insert($avaliacao, $discp, $qtd)(1, 1, 2);

?>