<?php

   session_start();

   require_once('../controller/PublicacaoQueryController.php');
   require_once("../functions/Conexao.php");
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/QueryController.php');

   require_once('../controller/QueryControllerEstudante.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/PublicacaoQueryController.php');
   require_once('../controller/PutaFrequenciaController.php');


   $query = new QuerySql();
   $ctr_est = new SqlQueryEstudante();
   $pautaFreq = new PautaFrequencia();
   $pauta_normal = new PautaNormalController();


?>

<?php

    $acao = $_POST['acao'];
    //$user= $_SESSION['username'];

    switch ($acao) {

	case 1:


		$db = new mySQLConnection();
        $idDoc = $query->getDoc_id($_SESSION['username']);


                    if ($_SESSION['nsessao'] == "Estudante"){

                     $result= mysqli_query($db->openConection(), get_query($idDoc));

                    while ($row = mysqli_fetch_assoc($result)){
                           $vetor_nrmec[] = Array('nome' => $row['nomeCompleto'],

                                                  'numero'=>$row['nrEstudante'],

                                                  'id'=>$row['idEstudante'],
                                                  'email'=>$row['username'],
                                                  'utilizador'=>$_SESSION['nsessao']);
                    }

                    echo json_encode($vetor_nrmec);

                    }

                    if($_SESSION['nsessao'] == "Docente" || $_SESSION['nsessao'] == "Coordenador"){

                              $consuta= "SELECT * FROM docente INNER JOIN utilizador
ON utilizador.id = docente.idUtilizador AND docente.idDocente = '$idDoc'";

                              $result = mysqli_query($db->openConection(),$consuta);
                              while ($row = mysqli_fetch_assoc($result)){
                                     $vetor[] = Array('username'=> $row['username'],
                                                      'password'=> $row['password'],
                                                      'fullname'=> $row['nomeCompleto'],
                                                      'id'=> $row['idDocente'],
                                                      'utilizador'=>$_SESSION['nsessao']);
                             }

                             echo json_encode($vetor);
                    }

                   break;
          case 2:

                    break;
$database = new SQLite3('esimop_off.db');

          $table_nota = 'CREATE TABLE `estudante_nota` (
                    `idnota`  int NOT NULL INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                    `nota`  double NULL ,
                    `avaliacao`  varchar(255) NULL )';

 $table_estudante='  CREATE TABLE `estudante_disciplina` (
                   `idestudante`  int NOT NULL INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                    `nrestudante`  int NOT NULL ,
                    `nomecompleto`  varchar(255) NULL ,
                    `disciplina`  varchar(255) NULL ,
                    `dataReg`  datetime NULL ,
                    `idnota`  int NULL ,

                    FOREIGN KEY (`idnota`) REFERENCES `estudante_nota` (`idnota`))';

  //$database->queryExec($table_nota);
  //$database->queryExec($table_estudante);

  echo "tableas cridas com sucesso";

  break;

          case 3:

                    $db = new mySQLConnection();
              $idDoc = $query->getDoc_id($_SESSION['username']);

                    $result= mysqli_query($db->openConection(), get_query($idDoc));

                    while ($row = mysqli_fetch_assoc($result)){
                           $vetor_nrmec[] = Array('fullname' => $row['nomeCompleto'],
                                                  'nrmec'=>$row['nrEstudante'],
                                                  'id'=>$row['idEstudante'],
                                                  'email'=>$row['username'],
                                                  'curso' =>$row['idCurso'],
                                                  'curso_des'=>$row['descricao']);
                    }

                    echo json_encode($vetor_nrmec);

               break;

                    case 4:
                    $db = new mySQLConnection();
                    //$docente = $query->getDoc_id($user,$pass);

                    $result = mysqli_query($db->openConection(),"SELECT * from curso");
                    while($row= mysqli_fetch_assoc($result)){

                      $vetor_nrmec[] = Array('id'=>$row['idCurso'],
                                              'descricao'=>$row['descricao']);

                    }

                    echo json_encode($vetor_nrmec);

	break;

               case 5:
                    $db = new mySQLConnection();
                   $idDoc = $query->getDoc_id($_SESSION['username']);

                    $variable="SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao,disciplina.codigo, disciplina.ano
FROM disciplina INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
INNER JOIN docente ON docente.idDocente = docentedisciplina.idDocente
WHERE docente.idDocente =".$idDoc;

                    $result = mysqli_query($db->openConection(),$variable);
                    while($row= mysqli_fetch_assoc($result)){

                      $vetor_nrmec[] = Array('id'=>$row['idDisciplina'],
                                              'descricao'=>$row['descricao'],
                                              'codigo'=>$row['codigo'],
                                              'ano'=>$row['ano']);

                    }

                    echo json_encode($vetor_nrmec);

          break;

        case 6:

            $avaliacao = utf8_decode($_POST['avaliacao']);
            $disciplina = utf8_decode( $_POST['disciplina']);
            $curso = utf8_decode($_POST['curso']);
            $estado= utf8_decode($_POST['estado']);

            /*$q = "INSERT INTO `pautanormal`(`idcurso`, `idDisciplina`, `idTipoAvaliacao`,`estado`, `dataReg`)
            VALUES (1,6,1,1,CURRENT_DATE)";

            $db = new mySQLConnection();
            if ($result =  mysqli_query($db->openConection(),$q))
            echo $result; else echo ' insucesso '.error_reporting();*/

            $pauta_normal->insert($disciplina,$avaliacao,2,$estado);

            /*$stmt = mysqli_prepare($db->openConection(), $q);
            $rs= mysqli_stmt_bind_param($stmt,'iiii',$curso, $disciplina, $avaliacao,$estado);

            if (mysqli_stmt_execute($stmt)){
               echo "sucess";

            }else{echo "unsuccess";}*/

            break;

 default:

          break;
}

?>

<?php

          function get_query($idDoc)
          {
                return ("SELECT DISTINCT estudante.nomeCompleto, curso.descricao, curso.idCurso,  estudante.nrEstudante, estudante.idEstudante,utilizador.username FROM estudante
INNER JOIN estudante_disciplina ON estudante.idEstudante = estudante_disciplina.idestudante
INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
INNER JOIN utilizador ON utilizador.id= estudante.idUtilizador
INNER JOIN disciplina ON disciplina.idDisciplina = estudante_disciplina.iddisciplina
INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
WHERE docentedisciplina.idDocente = '$idDoc'");
          }
?>