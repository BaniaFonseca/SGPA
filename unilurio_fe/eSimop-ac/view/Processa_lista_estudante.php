<?php

	session_start();

	require_once("../controller/QueryController.php");
	require_once("../controller/DisciplinaController.php");
	require_once('../functions/Conexao.php');
	require_once("../functions/Conexao.php");
	require_once('../controller/PublicacaoQueryController.php');

          $query = new QuerySql();
          $idDoc = $query->getDoc_id($_SESSION['username']);

      ?>

     <?php

		$acao= $_REQUEST['acao'];

		switch($acao){

	          case 1:

          		$disciplina = $_POST['disp'];
                              $curso = $_POST['curso'];

          		$db = new mySQLConnection();

          		$result = mysqli_query($db->openConection(),$query->obterEstudantesDisciplina($disciplina, $curso));
          		while ($row= mysqli_fetch_assoc($result)){

          		          $vetor[] = array('numero'=>$row['numero'],
                                        'nomeCompleto'=>$row['nomeCompleto'],
                                        'idEstudante'=>$row['idEstudante']);
          		}

	          // Convert the Array to a JSON String and echo it

		 echo json_encode($vetor);
			break;

                      case 3:
          		$disciplina = $_POST['disp'];

                              $db = new mySQLConnection();

                              $query= $query->obterEstudantesDisciplina($disciplina, $curso);

                              $result = mysqli_query($db->openConection(),$query);


                              while ($row = mysqli_fetch_assoc($result)){
                                  echo '<li value="'.$row['numero'].'">'.$row['nomeCompleto'].'</li>';
                              }
                          break;

		case 2:

			$descricao = $_REQUEST['term'];
			$publicacao = new PublicarPauta();
			$db= new mySQLConnection();

			$estudante = $query->getIdEstByNameApelido($_SESSION['username'],2);
			$vetor = $publicacao->listaEstudanteDisp($estudante,$descricao);
			$result = mysqli_query($db->openConection(),$vetor);

			while($row[] = mysqli_fetch_assoc($result)){; }

			echo json_encode($row);

		break;

		case 4:


		$db = new mySQLConnection();
		$filter = '%'.$_REQUEST['keyword'].'%';
                    $disp = $_REQUEST['disp'];

                    $curso = $query->getDisciplinaDocenteIdCurso($disp, $idDoc);
		$result = mysqli_query($db->openConection(),$query->queryAutoComplete($filter,$curso, $disp));

		while ($row = mysqli_fetch_assoc($result)){

	                  $vetor_nrmec[] = Array( 'nrmec'=> $row['numero'],
	                                          'nomeCompleto'=> $row['nomeCompleto']);
	            }
				  // Convert the Array to a JSON String and echo it
		echo json_encode($vetor_nrmec);

	          break;

		case 5:
                              break;



		}

?>


