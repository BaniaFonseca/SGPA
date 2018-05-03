<?php

	session_start();

	require_once("../controller/QueryController.php");
	require_once("../controller/DisciplinaController.php");
	require_once('../functions/Conexao.php');
	require_once("../functions/Conexao.php");
	require_once('../controller/PublicacaoQueryController.php');

    $query = new QuerySql();
?>

<?php

	
	
        $dados = json_decode(file_get_contents('php://input'),TRUE);
        //$dados = json_decode(stream_get_contents(STDIN));
        
        header('Content-type: application/json');
                    echo json_encode($dados);
        $acao = $dados['tipo'];
        $texto = $dados['texto'];
	
	switch($acao){
	
		case 1:
				   
                    $q= "SELECT docente.idDocente, docente.nomeCompleto
                    FROM docente WHERE docente.nomeCompleto LIKE '$texto'";

                    $db = new mySQLConnection();
                    $result = mysqli_query($db->openConection(), $q);
                    while ($row= mysqli_fetch_assoc($result)) {
                              $vetor[] = array('id'=>$row['idDocente'],
                                               'fullname'=>$row['nomeCompleto']);
                    }
                    
                    header('Content-type: application/json');
                    echo json_encode($vetor);
				
		break;
		
		case 2:
			  
			  return ($_POST['x']+$_POST['y']);
		
		default:
				return 0;
	}
	

?>