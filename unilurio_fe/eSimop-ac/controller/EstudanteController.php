<?php

    require_once '../functions/Conexao.php';
    require_once '../functions/Interface.php';
    require_once '../model/Bolsa.class.php';
    require_once '../model/Sexo.class.php';
?>

<?php

   global $mydb;

   class EstudanteController {

       public function read($id){
           $mydb = new mySQLConnection();
           if ($mydb){

               $query= "SELECT * FROM `estudante` WHERE idEstudante ={$id}";
               $result_set = mysqli_query($mydb->openConection(),$query);
               $found = mysqli_fetch_assoc($result_set);
           return($found);

           }else{
               return(false);
               }

        $mydb->closeDatabase();
       }

       public function insert($util, $nomec,$nrest){

           $mydb = new mySQLConnection();
           $query ="INSERT INTO `estudante`(`idUtilizador`, `nomeCompleto`, `nrEstudante`) VALUES (?,?,?)";

           if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'iss',$util,$nomec,$nrest);

               if(mysqli_stmt_execute($stmt)){
                    echo('Estudante inserido com sucesso!');
               }else{
                    echo('problemas na insercao!');
               }
           $mydb->closeDatabase();

           }
       }

       public function associar_estudante_disp($curso, $disp, $aluno)
       {
            $query ="INSERT INTO `estudante_disciplina`(`idestudante`, `iddisciplina`, `idcurso`, `dataReg`) VALUES (?,?,?,now())" ;

              $mydb = new mySQLConnection();

              if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'iii',$aluno,$disp,$curso);

               if(mysqli_stmt_execute($stmt)){
                    echo('Estudante sssociado com sucesso!');
               }else{
                    echo('Problemas na insercao!');
               }
           $mydb->closeDatabase();
           }

       }

       public function update($object){

           $mydb = new mySQLConnection();




       }

       public function delete($id){

             $mydb = new mySQLConnection();

             $query = "DELETE FROM `estudante` WHERE idCurso = ?";
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
           $query= "SELECT * FROM `estudante`";
           if ($mydb){
              $result_set = mysqli_query($mydb->openConection(),$query);
           }
        return($result_set);

       }
   }

?>