<?php

	require_once("../functions/Conexao.php");
	require_once('../model/Estudante.class.php');
	require_once('../model/Docente.class.php');
	require_once('../controller/QueryController.php');

?>

<?php

	$user = $_POST['username'];
	$pass = $_POST['password'];
	$type = intval ($_POST['acesso']);
	$acao = intval ($_POST['acao']);
	$tag = $_POST['tag'];
	
	$db = new mySQLConnection();
	$queryCtr = new QuerySql();
	$response = array();

	switch($acao){
	
	    case 1:

			if ($user != "" && $pass != "" && $tag == "login"){
			
				session_start();
				
				if ($myArray = $queryCtr->decideUserLogin($user,$pass,$type) == $user){

					$response['nsessao'] = 'Estudante';
					$response['password'] = $pass;
					$response['username'] = $user;
					$response['nomeC']=  $queryCtr->getNomeCompleto($user,$pass, 1);
					$response['error'] = FALSE;
					
					print json_encode($response);
					return;
				}else{

				if ($myArray = $queryCtr->decideUserLogin($user,$pass,$type+2)== $user){
						//Acesso coordenador
					
						$response['username'] = $user;
						$response['password'] = $pass;
						$response['nsessao'] = 'Coordenador';
						$response['nomeC']=  $queryCtr->getNomeCompleto($user,$pass, 0);
						$response['error'] = FALSE;
						
						print json_encode($response);
						
					  return;
					  
				}else{

					if ($myArray = $queryCtr->decideUserLogin($user,$pass,$type+1)== $user){

						$response['username'] = $user;
						$response['password'] = $pass;
						$response['nsessao'] = 'Docente';
						$response['nomeC']=  $queryCtr->getNomeCompleto($user,$pass, 0);
						$response['error'] = FALSE;
						
						print json_encode($response);
					return;
				}

				if($queryCtr->decideUserLogin($user,$pass,$type+3)== $user){

				  $response['username']=  $user;
				  $response['password'] = $pass;
				  $response['nsessao'] = 'Registo Academico';
				  $response['nomeC']=  "Registo Academico";
				  $response['error'] = FALSE;
				  print json_encode($response);
				
				 return;
			  
			   }
				 $response['error'] = TRUE;

				$response['error_msg']='Talvez nome ou senha esteja errado';
				print json_encode($response);
			}
		}

		} // fim primeiro if 
			 
		break;
		
		default:
		
			$response['error'] = TRUE;
			$response['error_msg']= 'Nenhum paramentro foi enviado';
			print json_encode($response);
			
		return ;
	}