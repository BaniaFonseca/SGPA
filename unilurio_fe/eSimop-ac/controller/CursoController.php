<?php

    require_once '../functions/Conexao.php';
    require_once '../model/Faculdade.class.php';

?>

<?php

   global $mydb;

   class CursoController{

       public function insert($dir,$nome,$facul,$codigo){

           $mydb = new mySQLConnection();


           $query = "INSERT INTO `curso`( `coordenador`, `descricao`, `idFaculdade`, `codigo`) VALUES (?,?,?,?)";

               $stmt = mysqli_prepare($mydb->openConection(),$query);
               $result = mysqli_stmt_bind_param($stmt,'isii',$dir,$nome,$facul,$codigo);

               if(mysqli_stmt_execute($stmt)){

                    echo 'Curso inserido com sucesso.';

               }else{
                    echo 'Problemas na insercao.';
               }

           $mydb->closeDatabase();

       }



}

?>