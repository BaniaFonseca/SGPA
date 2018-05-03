<?php

   session_start();

   require_once('../controller/PublicacaoQueryController.php');
   require_once('../functions/Conexao.php');
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/QueryController.php');

   require_once('../controller/QueryControllerEstudante.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/PublicacaoQueryController.php');
   require_once('../controller/CursoController.php');
   require_once('../controller/DocenteController.php');
   require_once('../controller/DisciplinaController.php');
   require_once('../controller/EstudanteController.php');

   $query = new QuerySql();
   $ctr_est = new SqlQueryEstudante();
   $curso_ctr = new CursoController();
   $docente_ctr= new DocenteController();
   $disciplina_ctr= new DisciplinaController();
   $estudante_ctr = new EstudanteController();

   $estado = 2;

?>

<?php

    $acao = $_POST['acao'];

         switch ($acao) {

             case 1:

                    $idDocx = $query->getDoc_id($_POST['fullname']);
                    $curso_ctr->insert($idDocx,$_POST['descricao'],$_POST['facul'],$_POST['codigo']);

                    break;

             case 2:
                       $var = "%".$_POST['texto']."%";
                       $comando = "".$query->getNome_from_ra($var);
                       echo "".$comando;

                  break;

          case 3:
	         $docente_ctr->inserir_utilizador($_POST['ctg'],$_POST['sexo'],$_POST['email'],$_POST['pass']);

	break;

          case 4:
                   $idDoc = $query->getDoc_id_user($_POST['email']);
                   $docente_ctr->insert_docente($_POST['fullname'],$idDoc, $_POST['grau']);

          break;

          case 5:

                    $disciplina_ctr->insert($_POST['nivel'], $_POST['creditos'],
                    $_POST['descricao'],$_POST['codigo']);

                    break;
          case 6:
                    $texto = "%".$_POST['texto']."%";
                    $q= "SELECT docente.idDocente, docente.nomeCompleto
                    FROM docente WHERE docente.nomeCompleto LIKE '$texto'";

                    $db = new mySQLConnection();
                    $result = mysqli_query($db->openConection(), $q);
                    while ($row= mysqli_fetch_assoc($result)) {
                              $vetor[] = array('id'=>$row['idDocente'],
                                               'fullname'=>$row['nomeCompleto']);
                    }
                    echo json_encode($vetor);
                    break;
          case 7:

                    $docente_ctr->associar_doc_disp($_POST['curso'],$_POST['disp'],$_POST['doc']);

          break;

          case 8:
                    $idutil = $query->getDoc_id_user($_POST['email']);
                    $estudante_ctr->insert($idutil, $_POST['fullname'],$_POST['nrmec']);

                    break;
          case 9:


                    $texto = "%".$_POST['texto']."%";
                    $curso = $_POST['curso'];
                    $q= "SELECT DISTINCT estudante.idEstudante, estudante.nomeCompleto
                    FROM estudante INNER JOIN estudante_disciplina
ON estudante.idEstudante= estudante_disciplina.idestudante
 WHERE estudante.nomeCompleto LIKE '$texto' AND estudante_disciplina.idcurso = '$curso'";

                    $db = new mySQLConnection();
                    $result = mysqli_query($db->openConection(), $q);
                    while ($row= mysqli_fetch_assoc($result)) {
                              $vetor[] = array('id'=>$row['idEstudante'],
                                               'fullname'=>$row['nomeCompleto']);
                    }
                    echo json_encode($vetor);
                    break;
          case 10:
                     $estudante_ctr->associar_estudante_disp($_POST['curso'], $_POST['disp'], $_POST['estudante']);
          break;

          case 11:


                $db = new mySQLConnection();
                $aluno = $_POST['nomec'];
                $idAluno =  $query->getIdEstByNameApelido($aluno,1);
                $_SESSION['aluno'] = $idAluno;

                $q = $ctr_est->estudanteRec($idAluno,1);

                $result = mysqli_query($db->openConection(), $q);
                $t=0;

                 while ($row= mysqli_fetch_assoc($result)) {
                        $vetor_x[] = Array('codigo'=>$row['codigo'],
                                        'descricao'=>$row['descricao'],
                                        'nota'=>$row['nota'],
                                        'idnota'=>$row['idNota'],
                                        'idDisp'=>$row['idDisciplina']) ;
                 }
                 echo json_encode($vector_x);

            $db->closeDatabase();

            break;

            default:

                break;
	}

?>