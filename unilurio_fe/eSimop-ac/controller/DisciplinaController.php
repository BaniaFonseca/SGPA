<?php

    require_once '../functions/Conexao.php';

    require_once '../model/Faculdade.class.php';
?>

<?php

   class DisciplinaController{


       public function read($id){
           $mydb = new mySQLConnection();
           if ($mydb){

               $query= "SELECT * FROM `disciplina` WHERE idDisciplina ={$id}";
               $result_set = mysqli_query($mydb->openConection(),$query);
               $found = mysqli_fetch_assoc($result_set);
           return($found);

           }else{
               return(false);
               }

        $mydb->closeDatabase();
       }

       // insere nova disciplina

       public function insert($nivel, $cred,$nomed,$cod){

              $mydb = new mySQLConnection();

               $query = "INSERT INTO `disciplina`(`ano`, `creditos`, `descricao`, `codigo`) VALUES (?,?,?,?)";
               $stmt = mysqli_prepare($mydb->openConection(),$query);
               $result = mysqli_stmt_bind_param($stmt,'iisi', $nivel, $cred, $nomed,$cod);

               if(mysqli_stmt_execute($stmt)){

                    echo('Disciplina inserida com sucesso!<br>');
               }else{
                    echo('problemas na insercao!<br>');
               }

       $mydb->closeDatabase();
      }


       public function delete($id){

             $mydb = new mySQLConnection();

             $query = "DELETE FROM `curso` WHERE idCurso = ?";
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
           $query= "SELECT * FROM `disciplina`";
           if ($mydb){
              $result_set = mysqli_query($mydb->openConection(),$query);
           }
        return($result_set);

       }


   }

?>