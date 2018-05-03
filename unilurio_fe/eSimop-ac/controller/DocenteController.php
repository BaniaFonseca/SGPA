<?php

    require_once '../functions/Conexao.php';

    require_once '../model/Sexo.class.php';
?>

<?php

   global $mydb;

   class DocenteController{


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

       public function insert_docente($nomec,$user, $grau){

           $mydb = new mySQLConnection();

           $query = "INSERT INTO `docente`(`idGrauAcademico`, `idUtilizador`, `nomeCompleto`) VALUES (?,?,?)";

           if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'iis',$grau, $user, $nomec);

               if(mysqli_stmt_execute($stmt)){
                    echo('Docente inserido com sucesso !');
               }else{
                    echo('Houve problemas na insercao !');
               }

           $mydb->closeDatabase();

           }

       }

       public function associar_doc_disp($curso,$disp,$doc)
       {
                 $query="INSERT INTO `docentedisciplina`(`idCurso`, `idDisciplina`, `idDocente`, `semestre`) VALUES (?,?,?,?)";
                 $mydb = new mySQLConnection();
               $semestre = "";
               if (date('m') < 7){$semestre = 1;}else{$semestre = 2;}

               if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'iiii',$curso, $disp, $doc, $semestre);

               if(mysqli_stmt_execute($stmt)){
                    echo('Docente associado com sucesso.');
               }else{
                    echo('problemas na insercao!<br>');
               }


           $mydb->closeDatabase();

           }
       }


       public function readDadosDocente($fullname,$email, $ctr)
{

      $db = new mySQLConnection();

      switch ($ctr) {

          case 1:

          $query = "SELECT idDocente FROM docente WHERE docente.nomeCompleto= '$fullname' AND docente.email ='$email'";
          $result = mysqli_query($db->openConection(), $query);

          if ($row = mysqli_fetch_assoc($result))
              return ($row['idDocente']);

          break;

          case 2:
           $query = "SELECT username FROM docente WHERE docente.nomeCompleto= '$fullname' AND docente.email = '$email'";
           $result = mysqli_query($db->openConection(), $query);

         if ($row = mysqli_fetch_assoc($result))
              return ($row['username']);

      break;
          default:
              echo "Os seus dados nao conferem com os do nosso repositorio\n por favor tende de novo ou contacte o Registo Academico";
      }
 }

       public function create_user_rac($nc,$cargo,$user,$pass,$mail)
          {
           $query ="INSERT INTO `userrac`(`fullname`, `categoria`, `username`, `password`, `email`) VALUES (?,?,?,?,?)";
             $mydb = new mySQLConnection();

                       $stmt = mysqli_prepare($mydb->openConection(),$query);
                       $result = mysqli_stmt_bind_param($stmt,'sssss',$nc,$cargo,$user,$pass,$mail);

                       if (mysqli_stmt_execute($stmt)){
                          echo('Utilizador criado com sucesso');
                       }else{
                          echo('Nao foi possivel criar utilizador');
                       }
                     $mydb->closeDatabase();

          }

       public function inserir_utilizador($catg,$sexo,$emal,$pass)
       {
             $mydb = new mySQLConnection();

             $query="INSERT INTO `utilizador`(`categoria`, `idSexo`, `username`, `password`) VALUES (?,?,?,?)";

                       $stmt = mysqli_prepare($mydb->openConection(),$query);
                       $result = mysqli_stmt_bind_param($stmt,'siss',$catg,$sexo,$emal,$pass);

                       if (mysqli_stmt_execute($stmt)){
                          echo('Registado  com sucesso');
                       }else{
                          echo('Nao foi possivel inserir');
                       }


                     $mydb->closeDatabase();

       }
}

?>
