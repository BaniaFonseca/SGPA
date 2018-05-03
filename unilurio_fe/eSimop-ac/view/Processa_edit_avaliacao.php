<?php

	session_start();

	require_once("../controller/QueryController.php");
	require_once("../controller/DisciplinaController.php");
	require_once("../controller/EstudanteNotaController.php");
	require_once("../controller/PautaExameRecController.php");
	require_once("../controller/PautaNormalController.php");
    require_once('../controller/QueryControllerEstudante.php');
    require_once("../functions/Conexao.php");
    require_once('../controller/PublicacaoQueryController.php');
    require_once('../controller/PutaFrequenciaController.php');
    require_once('../libs/PHPMailer/class.phpmailer.php');

    $pautaFreq = new PautaFrequencia();
    $publicar = new PublicarPauta();

    $ctr_est = new SqlQueryEstudante();
	$db = new mySQLConnection();

    $query = new QuerySql();
	$acao = $_POST['acao'];

?>

<?php

	switch($acao){

		case 1:

					$id = $_POST['idNota'];
					$idDisp = $ctr_est->returnTipo($id, 1);
					$idAluno=  $ctr_est->getIdEstudante($_SESSION['username']);

					if (($ctr_est->returnTipo($id, 0) == 5) && ($ctr_est->validarRecorrencia ($idAluno, $idDisp)  == 1)){

					    echo'Taxa de recorrencia não paga';


					}else{

					    echo floatval($query->getEstNota($id));
					    $_SESSION['idNota'] = $id;
					}

					break;

		 case 2:
				    $data = $_POST['curso'];

                    $vetor=$ctr_est->pautaPublicadas(2, $data);

                    foreach ($vetor as $row) {

                        if ($row!=null){

                            $t1= $ctr_est->getCoutEstdPauta($row['idtipo'], 2);
                            $t2 = $ctr_est->getCoutEstdPauta($row['idtipo'], 1);

                            echo '<tr>';
                            echo '<td>'.$row['descricao'].'</td>';
                            echo '<td>'.$row['conta'].'</td>';

                            echo '<td>'.$t1.'</td>';
                            echo '<td>'.$t2.'</td>';
                            echo '</tr>';
                          }
                     }

		break;

		case 3:

			//Actuliza publicco de puta;
			$pauta = $_POST['pauta'];

			$pautaNormal = new PautaNormalController();
			$pautaNormal->update(2, $pauta);

		break;

		case 4:

                 $pauta = $query->obterPautaNormal($_SESSION['idNota']);

                 if ($_POST['ctr'] == 1 && $query->return_dif_data($pauta, 0) > 7){
                              echo 1;
                   return;
                 }

                 if ($_POST['ctr'] == 2 && $query->return_dif_data($pauta, 0) <= 7){

                 $db = new mySQLConnection();

                 $idDisp = $ctr_est->returnTipo($_SESSION['idNota'], 1);

                 $stmt = mysqli_prepare($db->openConection(),"UPDATE estudante_nota SET nota = ? WHERE idNota = ?");
                 $stmt->bind_param('di', $_POST['nota'], $_SESSION['idNota']);

                 if(!$stmt->execute()){

                       echo '<div align="center" style="color:red"><h3>Nao foi possivel alterar a classificação</h3<div>';

                 }else{
                       echo "<h3>Classificação actualizada com sucesso</h3>";

                       $stmt->close();
                }

        }

        break;

        case 5:

                 $query = $ctr_est->getPlanoAvaliacao($_POST['disciplina']);
                 $nomeDisp =  $pautaFreq->getnomeDisp($_POST['disciplina']);
                 $result = mysqli_query($db->openConection(), $query);
                 $t=0;

                 while ($row = mysqli_fetch_assoc($result)) {
                    $peso = $row['peso'];
                     echo '<tr>';

                         echo '<td>'.++$t.'</td>';
                         echo '<td>'.$row['descricao'].'</td>';
                         echo '<td align="center">'.$row['qtd'].'</td>';
                         echo '<td align="center">'.$peso.'</td>';
                         echo '<td align="center">'.date('d-m-Y').'</td>';

                     echo '</tr>';
                 }

                   echo '<tr>';

                         echo '<td>&nbsp;</td>';
                         echo '<td>&nbsp;</td>';

                         echo '<td align="center" style="background:#ff9933; color:blue">'.strtoupper($nomeDisp).'</td>';
                         echo '<td align="center">&nbsp;</td>';
                 echo '</tr>';

                break;



case 6:
	if ($_POST['ctr'] == 2 && $query->return_dif_data($pauta, 0) <= 5){

                 $db = new mySQLConnection();

                 $email= utf8_decode($_POST['email_doc_ass']);
                 $msg =utf8_decode($_POST['txtmotivo']);
                 $user=utf8_decode($_POST['user']);
                 $pass= utf8_decode($_POST['senha_doc']);
                 $idDisp = $ctr_est->returnTipo($_SESSION['idNota'], 1);


                 $stmt = mysqli_prepare($db->openConection(),"UPDATE estudante_nota SET nota = ? WHERE idNota = ?");
                 $stmt->bind_param('di', $_POST['nota'], $_SESSION['idNota']);

                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Mailer = 'smtp';
                    $mail->SMTPAuth = true;
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true);
                    // Autenticacao do gmail

                    $mail->Username = $user;
                    $mail->Password = $pass;

                    $mail->IsHTML(true); // if you are going to send HTML formatted emails
                    $mail->SingleTo = true;
                    //Define o remetente

                    $mail->From = $email;
                    $mail->FromName = $_SESSION['nomeC'];

                    $mail->AddAddress($email,$_SESSION['nomeC']);
                    //$mail->AddAddress($email,$_SESSION['nomeC']);

                    $assunto = "Alteração de nota disciplina: ".$publicar->getNomeDsciplina($idDisp);
                    $message ='Motivo: '.$msg.'<br />Houve alteração de nota para o estudante [ '.$query->mostrar_nome_estudante($_SESSION['idNota']).' ]';

                    //Texto e Assunto
                    $mail->Subject = utf8_decode($assunto);
                    $mail->Body = utf8_decode($message);

                    if(!$mail->Send() && $stmt->execute()){

                       echo '<div align="center" style="color:red"><h3>Nao foi possivel alterar a classificação e ocorrer um erro na <br/> tentativa de estabelecer conexão com servidor de email</h3<div>';

                    }else{
                       echo "Operação efectuada com sucesso";
                       $stmt->close();
                    }
               }
	break;

}

?>
