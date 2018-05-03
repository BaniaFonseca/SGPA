<?php

    require_once '../functions/Conexao.php';
    require_once '../model/Sexo.class.php';
?>

<?php

   global $mydb;

   class PlanoAvaliacaoController{


       public function read($id){
           $mydb = new mySQLConnection();

        $mydb->closeDatabase();
       }

       public function insert($avaliacao,$discp,$qtd, $ps){

           $mydb = new mySQLConnection();

           $query ='INSERT INTO `planoavaliacao`(`idDisciplina`, `idTipoAvaliacao`, `qtdMaxAvaliacao`, `peso`) VALUES (?,?,?,?)';

           $stmt = mysqli_prepare($mydb->openConection(),$query);
           $result = mysqli_stmt_bind_param($stmt,'iiid', $discp, $avaliacao, $qtd, $ps);

           if(mysqli_stmt_execute($stmt)){

                  echo('Plano registado com sucesso!<br>');

               }else{
                   echo('Problemas na insercao do plano!<br>');
             }


       $mydb->closeDatabase();

       }

       public function insert_data_avaliacao($idDisp, $datar, $av){

              $mydb = new mySQLConnection();

              $q = "INSERT INTO `data_avaliacao`(`idDisciplina`, `idavaliacao`, `dataRealizacao`) VALUES (?,?,?)";
              $stmt = mysqli_prepare($mydb->openConection(),$q);
              $result = mysqli_stmt_bind_param($stmt,'iis',$idDisp, $av,$datar);

              if(mysqli_stmt_execute($stmt)){

                  echo('Plano registado com sucesso!<br>');

               }else{
                   echo('Problemas na insercao de datas!<br>');
             }
       }


       public function update_peso($discp, $peso, $av)
       {
              $q="UPDATE `planoavaliacao` SET `peso`= ? WHERE `idDisciplina`= ? AND `idTipoAvaliacao`= ?";

              $mydb = new mySQLConnection();

              $stmt = mysqli_prepare($mydb->openConection(),$q);
              $result = mysqli_stmt_bind_param($stmt,'dii', $peso, $discp, $av);

              if(mysqli_stmt_execute($stmt)){

                  echo('Registado com sucessox!<br>');

               }else{
                   echo('Ocorreu um problema!<br>');
             }
       }

       public function update($object){

           $mydb = new mySQLConnection();
           $object = new PautaNormal();

           $nota = $object->getNota();
           $teste = $object->getIdTeste();
           $tipo = $object->getTipoAvaliacao();
           $idpauta = $object->getIdPauta();

           $query = "UPDATE `docente` SET `nome`=?,
                    `apelido`= ?,`sexo`= ?,
                    `senha`= ?,`email`=? WHERE `idDocente`=?";

           if ($stmt = mysqli_prepare($mydb->openConection(),$query)){

               $result = mysqli_stmt_bind_param($stmt,'diii',$nota,$teste,$tipo, $idpauta);
                mysqli_stmt_execute($stmt);
               if(mysqli_stmt_execute($stmt)){
                    echo('actualizado com sucesso!<br>');

               }else{
                   echo('problemas na actualizacao!<br>');
               }
            $mydb->closeDatabase();

           }

       }

       public function delete($id){

             $mydb = new mySQLConnection();

             $query = "DELETE FROM `planoavaliacao` WHERE `idPlanoAaliacao`= ?";
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
           $query= "SELECT * FROM planoavaliacao";
           if ($mydb){
              $result_set = mysqli_query($mydb->openConection(),$query);
           }
        return($result_set);

       }
   }

?>

<?php
$plano = new PlanoAvaliacaoController();
//$plano->insert($avaliacao, $discp, $qtd)(1, 1, 2);

?>