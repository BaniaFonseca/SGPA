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


   $query = new QuerySql();
   $ctr_est = new SqlQueryEstudante();
   $estado = 2;

   $idaluno= $ctr_est->getIdEstudante($_SESSION['username']);
   $idDoc = $query->getDoc_id($_SESSION['username']);
   $idcurso = $ctr_est->obterIdCursoEstudante($idaluno);

?>

<?php

    $acao = $_POST['acao'];

    switch ($acao) {
        case 1:

                   $disp= $_POST['disp'];

                   $q=$ctr_est->getpautaDate($disp,$idaluno,2,$idcurso);
                   $validarRec = $ctr_est->estudanteRec($idaluno, 1);
                   $db = new mySQLConnection();
                   $result = mysqli_query($db->openConection(), $q);

                   $t = 0; $t1=0; $t2=0; $t3=0;

                   while ($row = mysqli_fetch_assoc($result)) {

							echo '<tr>';

                            if ($row['tipo'] == 1){
                                $k = ++$t1;
                            }
                             if ($row['tipo'] == 2){
                                $k = ++$t2;
                            }
                             if ($row['tipo'] == 3){
                                $k = ++$t3;
                            }

                            if ($row['tipo'] <= 3){
                            echo '<td>'.$row['descricao'].'-'.$k.'</td>';
                            }else{
                               echo '<td>'.$row['descricao'].'</td>';
                            }

							$id = $idDisp = $ctr_est->returnTipo($row['idNota'], 1);

					        if (($row['tipo'] == 5) && ($ctr_est->validarRecorrencia($idaluno, $id)  == 1)){
								echo '<td>Nota oculta</td>';

							}else{
							   echo '<td>'.$row['nota'].'</td>';

							}

                            echo '<td align="center">'.$row['dataReg'].'</td>';
                            echo '<td align="center">'.$row['dataPub'].'</td>';

                            /*if ($row['nota'] >= 19 && $row['nota'] <= 20){
                                $estado= 'Excelente';
                            }
                            if ($row['nota'] >= 17 && $row['nota'] <= 18){
                                $estado= 'Muito Bom';
                            }
                            if ($row['nota'] >= 14 && $row['nota'] <= 16){
                                $estado= 'Bom';
                            }
                            if ($row['nota'] >= 10 && $row['nota'] <= 13){
                                $estado= 'Suficiente';
                            }
                            if ($row['nota'] >= 0 && $row['nota'] <= 9){
                                $estado= 'Insuficiente';
                            }

                            if (($row['tipo'] == 5) && ($ctr_est->validarRecorrencia($idaluno, $id)  == 1)){
                               $estado= 'Sem detalhes';
                            }
                            echo '<td>'.$estado.'</td>';*/
                    echo '</tr>';

				}
                    break;
            case 2:


                $db = new mySQLConnection();

	            $keyword = '%'.$_POST['disp'].'%';
                $query=$ctr_est->estudanteDisciplina($idaluno,$keyword,1);

                $result = mysqli_query($db->openConection(), $query);

                    while ($row = mysqli_fetch_assoc($result)){

                        $vetor[] = array('id'=>$row['idDisciplina'],
                                         'descricao'=>$row['descricao']);

                     }
                    echo json_encode($vetor);
            break;

            case 3:
                $myvar = new PublicarPauta();
                echo json_encode(strtoupper($myvar->getNomeDsciplina($_POST['disp'])));

                break;
            case 4:
                $db = new mySQLConnection();

                 $idDisp = $_POST['disp'];
                $query = $ctr_est->buscarDadosDisciplina($idDisp,$query->getDocenteIdCurso($idDisp, $idDoc));

                $result = mysqli_query($db->openConection(), $query);
                $t=0; $curso; $semestre;

                echo '<h3>Docente da Disciplina </h3>';

                echo '<h5 style="color:red">';
                while ($row= mysqli_fetch_assoc($result)) {

                    if ($t > 0){
                        echo ' e ';
                    }$t++;

                        echo $row['nomeCompleto'];

                        $curso = $row['descricao'];
                        $semestre = $row['semestre'];
                  }
                  echo '</h5>';

                    echo '<br>Curso:&nbsp;&nbsp;&nbsp;&nbsp;'.$curso;

                    echo '<br> Semestre:&nbsp;&nbsp;&nbsp;&nbsp;';
                    if ($semestre == 1){
                           echo ' 1º - Semestre <br>';
                     }else{
                          echo ' 2º - Semestre <br>';
                }

                break;

           case 5:
                    $db = new mySQLConnection();

                    $idDoc = $query->idDocenteNome($_POST['nomec']);
                    $lista = $query->listDisciplinasDoente($idDoc);
                    $result = mysqli_query($db->openConection(), $lista);
                    while ($row= mysqli_fetch_assoc($result)) {

                        echo '<li value="'.$row['idDisplina'].'">'.$row['descricao'].'</li>';
                    }
        	    break;

               case 6:

                    echo $query->contarAvaliacoesRealizadas($_POST['tipo'], $_POST['disp'],$_POST['curso'], $idDoc) ;

                break;

              case 7:

                    echo $query->allAvaliacaoDocenteDisp($idDoc, $_POST['disp']);

                 break;

              case 8 :

		if ($_POST['ctr'] == 1){

			echo $query->checkExameNormalRec($_POST['tipo'], $_POST['disp'], 0);

		}else{

			echo $query->checkExameNormalRec($_POST['tipo'], $_POST['disp'], 1);
		}

                break;

        case 9:
            $myarray = $ctr_est->obterQtdAvaliacaoPub($_POST['disp'],2,$idcurso, 1);
            $disp =$_POST['disp'];
            $db = new mySQLConnection();

            foreach ($myarray as $value) {
            if ($value != null){
            $tipo = $value['tipo'];

            switch($tipo){

                case 1:

                    $t=0;
                    $result = mysqli_query($db->openConection(),$ctr_est->listaNotaTesteAluno($idaluno,$disp, $tipo,$idcurso));
                    while ($myvar = mysqli_fetch_assoc($result)) {?>

                        <li class="ui-body-a ui-bar-a"  value="<?php echo $myvar['idNota'] ?>" onClick="getNota_item(this.value)">
                            <?php echo  $myvar['descricao']   . ' - ' . ++$t?></li>

                    <?php } break;

                case 2:

                    $t=0;
                    $result = mysqli_query($db->openConection(),$ctr_est->listaNotaTesteAluno($idaluno,$disp, $tipo, $idcurso));
                    while ($myvar = mysqli_fetch_assoc($result)) {?>

                    <li class="ui-body-a ui-bar-a"  value="<?php echo $myvar['idNota'] ?>" onClick="getNota_item(this.value)">
                        <?php echo  $myvar['descricao'] . ' - ' . ++$t?></li>

                <?php } break;

                 case 3:

                    $t=0;
                    $result = mysqli_query($db->openConection(),$ctr_est->listaNotaTesteAluno($idaluno,$disp, $tipo, $idcurso));

                    while ($myvar = mysqli_fetch_assoc($result)) {?>

                        <li class="ui-body-a ui-bar-a"  value="<?php echo $myvar['idNota'] ?>" onClick="getNota_item(this.value)">
                            <?php echo  $myvar['descricao']   . ' - ' . ++$t?></li>

                    <?php } break;

                 case 4:

                    $result = mysqli_query($db->openConection(),$ctr_est->listaNotaTesteAluno($idaluno,$disp, $tipo,$idcurso));

                    while ($myvar = mysqli_fetch_assoc($result)) {  ?>

                        <li class="ui-body-a ui-bar-a"  value="<?php echo $myvar['idNota'] ?>" onClick="getNota_item(this.value)">
                            <?php echo  $myvar['descricao']?></li>

                    <?php } break;

                case 5:

                    $result = mysqli_query($db->openConection(),$ctr_est->listaNotaTesteAluno($idaluno,$disp, $tipo, $idcurso));
                    while ($myvar = mysqli_fetch_assoc($result)) { ?>

                        <li class="ui-body-a ui-bar-a"  value="<?php echo $myvar['idNota'] ?>" onClick="getNota_item(this.value)">
                            <?php echo  $myvar['descricao']?></li>

                    <?php }   break;

            default: break; } } } break; }?>