<?php

	session_start();

	require_once('../functions/Conexao.php');
	require_once('../controller/EstudanteNotaController.php');
	require_once('../controller/PautaNormalController.php');
	require_once('../controller/QueryController.php');
	require_once("../controller/PautaExameRecController.php");
          require_once '../controller/PlanoAvaliacaoController.php';
	require_once ('../controller/TipoAvaliacaoController.php');
    require_once('../controller/QueryControllerEstudante.php');
     require_once('../controller/PublicacaoQueryController.php');


 $ctrConsulta = new QuerySql();

 $est_ctr = new SqlQueryEstudante();
 $db = new mySQLConnection();
 $estd = new EstudanteNotaController();
 $idPautaNormal = new PautaNormalController();
 $exameRec = new PautaExameRecorrenciaController();
 $tipoplano = new TipoAvaliacaoController();
 $plano = new PlanoAvaliacaoController();
 $myvar = new PublicarPauta();
 $estado = 1;

 //$idDoc = $query->getDoc_id($_SESSION['username']);

?>

<?php

		$ctr =  $_POST['acesso'];

		switch($ctr){

			case 1:
		                 // insere inicialmente a pauta normal

                                        $avaliacao = $_POST['avaliacao'];
                                        $disciplina = $_POST['disciplina'];
                                        $curso = $_POST['curso'];
                                        $idPautaNormal->insert($disciplina,$avaliacao,$curso,$estado);

                              break;

                              case 2:

                               $idEst = $ctrConsulta->getIdEstudante($_POST['nraluno']);
                               $idpauta = $idPautaNormal->getMaxRowValue();

                               $estd->insertF1($idpauta,$_POST['nota'], $idEst);

                              if ($_SESSION['avaliacao'] == 4 && $nota < 10){
                                  $db = new mySQLConnection();

                                  $result = mysqli_query($db->openConection(),
                                  "SELECT MAX(estudante_nota.idNota) as max FROM estudante_nota");
                                  $row= mysqli_fetch_assoc($result);
                                  $exameRec->insertRec($row['max'], $nota, $estado);
                              }
                              $db->closeDatabase();
                              break;

			case 3:

                    		$avaliacao = $_POST['avaliacao'];
                                        $disciplina = $_POST['disp'];
                                        $qtd = $_POST['qt'];
                    	          $peso = $_POST['peso'];
                                        $plano->insert($avaliacao,$disciplina,$qtd, $peso);

                              break;

                                 case 10:
                                       $plano->insert_data_avaliacao($_POST['disp'],$_POST['data'], $_POST['tipo']);
                                 break;

                            case 8:

                                    if (isset($_POST['p1'])!=""){

                                       $plano->update_peso($_POST['disp'], $_POST['p1'], 1);
                                     }

                                     if (isset($_POST['p2'])!=""){

                                        $plano->update_peso($_POST['disp'], $_POST['p2'], 2);
                                     }

                                     if (isset($_POST['p3'])!=""){

                                        $plano->update_peso($_POST['disp'], $_POST['p3'], 3);
                                     }

                                break;
                 case 4:

                      $t=0;
                      $db = new mySQLConnection();

                      $consulta = $ctrConsulta->listarPlanoActual($_SESSION['max']);
                      $result = mysqli_query($db->openConection(), $consulta);

                      while ($row = mysqli_fetch_assoc($result)) {
		        $vdp= $row['idDisciplina'];
                            $tipo= $row['av'];
                            $_SESSION['disp']= $row['av'];
                            echo '<tr class="ui-bar-d">';
                                    echo '<th align="left" >'.++$t.'</th>';
                                    echo '<td>'.$row['descricao'].'</td>';
                                    echo '<td>'.$row['tipo'].'</td>';
                                    echo '<td align="center" >'.$row['qtd'].'</td>';
                                    echo '<td align="center">

                 <button  value="'.$tipo.'" onclick="edit_qtd (this.value)" class="emails"
                 id="edit_qtd" >Editar Qtd.</button></td> </tr>';

                      }

                break;

               case 5:

                       $tipoplano->update($_POST['peso'], $_POST['avaliacao']);

                   break;

               case 6:

                    $max = $ctrConsulta->seletMaxIndex();
                    $_SESSION['max']= $max;
                    echo $max;

                   break;

             case 7:

                     $db = new mySQLConnection();

                     $_SESSION['nome_disp'] = $myvar->getNomeDsciplina($_POST['disp']);
                     $_SESSION['idDisp'] = $_POST['disp'];

                     $consulta = $est_ctr->getPlanoAvaliacao($_POST['disp']);
                     $vdp = (int)($_POST['disp']);
		 $ctr= $_POST['ctr'];

                      $result = mysqli_query($db->openConection(), $consulta);
                      $t=0;
                      $dp ="";
                      while ($row = mysqli_fetch_assoc($result)) {

                            $dp = $row['disp'];

                            echo '<tr class="ui-bar-d">';

                                    echo '<th align="left">'.$row['descricao'].'</th>';
                                    echo '<th align="center">'.$row['peso'].'</th>';
                                    echo '<th align="center">'.$row['qtd'].'</th>';


                            echo '</tr>';

                      }


                	break;

                    case 9:

                      $db = new mySQLConnection();
                      $t1=0; $mt=0; $otv=0;
                      $disp = $_POST['disp'];

                            $q = $myvar->mostra_datas_plano($disp);

                            $result = mysqli_query($db->openConection(), $q);

                            while ($row = mysqli_fetch_assoc($result)) {
                                       echo '<tr class="ui-bar-d">';

                                       if ($row['idavaliacao'] == 1){
                                         $t1++;
                                       echo '<th align="center"> T-'.$t1.'  ,  '.$row['dataRealizacao'].'</th>';
                                       }else{echo '<td>&nbsp;</td>';}

                                       if ($row['idavaliacao'] == 2){ $mt++;
                                       echo '<th align="center"> MT-'.$mt.'  ,  '.$row['dataRealizacao'].'</th>';
                                       }else{echo '<td>&nbsp;</td>';}

                                       if ($row['idavaliacao'] == 3){ $otv++;
                                       echo '<th align="center"> Tr-'.$otv.'  ,  '.$row['dataRealizacao'].'</th>';
                                       }else{echo '<td>&nbsp;</td>';}

                               echo' </tr>';
                            }

                    break;

					case 11:

						$disp = $_POST['disp'];
                        $nome_disp = $myvar->getNomeDsciplina($disp);
						$_SESSION['nome_disp'] = $nome_disp;
						echo '<div align="right"><h3>Disciplina a Notificar _'.$nome_disp.'</h3></div>';


                        $t=0; $doc="";
                        $v = new QuerySql();
                        $proc = $v->listaDocentesDisciplina($disp);
                        $db = new mySQLConnection();
                        $result = mysqli_query($db->openConection(), $proc);

                        while ($row = mysqli_fetch_assoc($result)){

						if ($t > 1)
						    echo " e "; $t++;
                         $doc.= $row['nomeCompleto'];
                        }

						echo '<div style="color:blue">Docente/s da disciplina  [ '.$doc.'  ]<div>';

					break;
		default:


			echo('Nenhum parametro enviado!<br>');
		}
	?>

