<?php

	require_once("../functions/Conexao.php");
	require_once('../model/Estudante.class.php');
	require_once('../model/Docente.class.php');
	require_once('../controller/QueryController.php');

?>

<?php

	$user = $_POST['username'];
	//$pass = $_POST['password'];
	$type = $_POST['acesso'];
	$acao = $_POST['acao'];


	$db = new mySQLConnection();
	$queryCtr = new QuerySql();


	switch($acao){

		case 1:

			if ($user != ""){
			session_start();

			if ($myArray = $queryCtr->decideUserLogin($user,$type) == $user){
				//Acesso estudante
				$_SESSION['username']=  $user;
				//$_SESSION['password'] = $pass;
				$_SESSION['nsessao'] = 'Estudante';
				$_SESSION['nomeC']=  $queryCtr->getNomeCompleto($user,1);

				//echo("<script>window.location ='offlineApp/Estudante_offline.html';</script>");
				return;
				}

				if ($queryCtr->decideUserLogin($user,$type+2)== $user){
						//Acesso coordenador
						$_SESSION['nomeC']=  $queryCtr->getNomeCompleto($user,0);
						$_SESSION['username'] = $user;
						//$_SESSION['password'] = $pass;
						$_SESSION['nsessao'] = 'Coordenador';
						echo("<script>window.location ='Docente_offline.html';</script>");
						return;
				}else{

					if ($queryCtr->decideUserLogin($user,$type+1)== $user){
					//Acesso estudante
						$_SESSION['nomeC']=  $queryCtr->getNomeCompleto($user, 0);
						$_SESSION['username'] = $user;
						//$_SESSION['password'] = $pass;
						$_SESSION['nsessao'] = 'Docente';
						echo("<script>window.location ='Docente_offline.html';</script>");
					return;
					}

					echo "<script>$('#login').panel('open');</script>";
					echo '<div style="font-family:serif;margin-bottom:-.5em; margin-top:-1em">Talvez nome ou senha esteja errado</div>';
				}

			}else{

					echo "<script>$('#login').panel('open');</script>";
					echo 'Todos os Campos sao obrigatorios';

			}
			break;
		case 2:

			if ($user != ""){
	session_start();

	if ($myArray = $queryCtr->decideUserLogin($user,$type) == $user){

		$_SESSION['nsessao'] = 'Estudante';
		//$_SESSION['password'] = $pass;
		$_SESSION['username'] = $user;
		$_SESSION['nomeC']=  $queryCtr->getNomeCompleto($user,1);

		echo("<script>window.location ='view/Estudante_pauta.php';</script>");
		return;
		}

		if ($queryCtr->decideUserLogin($user,$type+2)== $user){
				//Acesso coordenador
				$_SESSION['nomeC']=  $queryCtr->getNomeCompleto($user,0);
				$_SESSION['username'] = $user;
				//$_SESSION['password'] = $pass;
				$_SESSION['nsessao'] = 'Coordenador';
				echo("<script>window.location ='view/Coordenador_curso.php';</script>");
		      return;
		}else{

			if ($queryCtr->decideUserLogin($user,$type+1)== $user){

				$_SESSION['nomeC']=  $queryCtr->getNomeCompleto($user,0);
				$_SESSION['username'] = $user;
				//$_SESSION['password'] = $pass;

				$_SESSION['nsessao'] = 'Docente';
				echo("<script>window.location ='view/Docente_pauta.php';</script>");
			return;

			}

			if($queryCtr->decideUserLogin($user,$type+3)== $user){

                                                  $_SESSION['username']=  $user;
                                                  //$_SESSION['password'] = $pass;
                                                  $_SESSION['nsessao'] = 'Registo Academico';
                                                  $_SESSION['nomeC']=  "Registo Academico";

                                                  echo("<script>window.location ='view/Registo_Academico.php';</script>");
                                        return;
                                  }

			echo '<div style="font-family:serif;margin-bottom:-.5em; margin-top:-1em">Talvez nome ou senha esteja errado <div> ';

		}

	}else{

	echo '<div style="font-family:serif; margin-bottom:-.5em; margin-top:-1em">Digite dados de acesso em todos os campos<div>';

	}
	break;

            case 3:

                session_destroy('nsessao');
                session_destroy('nomeC');
                session_unset();
                session_destroy();
                session_register_shutdown();

                echo("<script>window.location ='../index.html';</script>");

            break;

            case 4:


               break;
	}

?>
