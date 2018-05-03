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
   $db = new mySQLConnection();
   $est_aluno = "";

   $idAluno = $query->getIdEstByNameApelido($_SESSION['nomeC'],"",1);
   $idcurso = $ctr_est->obterIdCursoEstudante($idAluno);

?>


<?php

    $acao = $_POST['acao'];
       switch ($acao) {
        case 1:
                 $ctr = $_POST['ctr'];
                 $discp = $_POST['disp'];
                 $nomeDisp = $pautaFreq->getnomeDisp($discp);
                 $nrmec = $pautaFreq->getMecaEstudante($idAluno);
                 $mediaf = $pautaFreq->obterMediaFrequecia($discp, $idAluno, 2, $idcurso, 0);

                 if ($mediaf > 0){
                     echo '<table data-role="table"  width="95%" id="movie-table-customm" data-mode="reflow" class="movie-list ui-responsive">';

                    echo '<thead>';

                        echo '<tr class="ui-bar-b">';
                            echo'  <th class="menuT1">No.</th>';
                            if ($ctr == 2){
                                echo '<th class="menuT1">Disciplina</th>';
                            }
                            echo' <th class="menuT1">Med. de Freq</th>';
                            echo '<th class="menuT1">Res. Qual.</th>';


                            if ($ctr == 3 || $ctr == 4 ){

                               echo' <th class="menuT1">Av. Exame</th>';
                               echo '<th class="menuT1">Av. Rec.</th>';
                               echo' <th class="menuT1">Av. Final</th>';
                               echo '<th class="menuT1">Res. Qual</th>';
                            }

                        echo '</tr>';

                     echo '</thead>';
                     echo '<tbody align="center">';
                     echo '<tr  class="ui-btn-a" style="padding: 10px">';
                     echo '<td>'.$nrmec.'</td>';

                     if ($ctr == 2){

                        echo '<td>'.$nomeDisp.'</td>';
                     }
                      echo '<td>'.$mediaf.'</td>';

                     if ($mediaf >= 10 && $mediaf < 16){

                         $estado = "Admitido";
                      }

                     if($mediaf < 10){

                        $estado = "Excluido";
                        //echo '<td>'.$est_aluno.'</td>';
                     }

                     if($mediaf >= 16){

                         $estado = "Dispensado";
                          echo '<td>'.$estado.'</td>';
                     }else{

                          echo '<td>'.$estado.'</td>';
                     if ($ctr == 3 || $ctr == 4){

                          $mediaEx = $pautaFreq->getNotaExame($discp, $idAluno, 2,$idcurso, 0); // Obtem notado exeme normal

                          echo '<td>'.$mediaEx.'</td>';

                          if ($mediaEx >= 10){

                             $est_aluno = 'Aprovado';
                             echo '<td style="color:red">--</td>';
                             $mediaG = round(($mediaf*0.50)+($mediaEx*0.50), 2);
                             echo '<td>'.$mediaG.'</td>';

                          }elseif($mediaEx < 10 && $ctr == 3){

                            echo '<td style="color:red">--</td>';
                            echo '<td style="color:red">--</td>';
                            $est_aluno = 'Recorrência';
                          }

                         if ($mediaEx < 10 && $ctr == 4){

                            $mediaRec = $pautaFreq->getNotaExame($discp, $idAluno, 2,$idcurso, 1); //obtem nota do exeme de recorrencia
                            echo '<td style="color:red">'.$mediaRec.'</td>';

                            if ($mediaRec > 10 ){

                               $est_aluno = 'Aprovado';
                               echo '<td style="color:red">'.$mediaRec.'</td>';
                               $mediaG = round(($mediaf*0.75)+($mediaRec*0.25)/2, 2);
                               echo '<td>'.$mediaG.'</td>';

                            }else{
                                 echo '<td style="color:red">--</td>';
                                 $est_aluno = 'Reprovado';
                            }


                         }


                     }
  echo '<td>'.$est_aluno.'</td>';

}


                      if(($mediaf >= 16 ) && ( $ctr == 3 || $ctr == 4)){

                         echo '<td style="color:red">--</td>';
                         echo '<td style="color:red">--</td>';
                         echo '<td style="color:red">'.$mediaf.'</td>';
                         echo  '<td>Aprovado</td>';

                        }
                     echo '</tr>';

                }else{

                     echo '<h3 style="color:red; text-align:center">Nenhuma avaliação publicada<br>Seleccione outra disciplina</h3>';

                }

              echo '</tbody></table>';
        break;

        case 2:

            $estado = "";
            $discp = $_POST['disp'];
            $estado_pn=2;
            $query_res = new QuerySql();

            if ($ctr_est->obterQtdAvaliacaoPub($discp,$estado_pn,$idcurso, 0) >= 2){

                $nrmec = $pautaFreq->getMecaEstudante($idAluno);
                $media = $pautaFreq->obterMediaFrequecia($discp, $idAluno, $estado_pn,$idcurso, 0);

                $nomeDisp = $pautaFreq->getnomeDisp($discp);

                echo '<table data-role="table"  width="90%" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">';

                echo '<thead>';

                $query = $pautaFreq->ordenacaoTestes($discp, $idAluno, $estado_pn,$idcurso, 0);
                $result = mysqli_query($db->openConection(), $query);

                if (mysqli_num_rows($result) > 0){


                    echo '<tr>';
                    echo '<td class="ui-bar-b" style="background:#5a5a5a; color:white;" align="center"> Creditos:  '.$query_res->get_creditos_ano($discp,1).' </td></tr>';

                    echo '<tr  class="ui-bar-b">';
                    echo '<th data-priority="2" class="menuT1">Disciplina</th>';


                    $t=0; $i=0; $k=0;

                    while ($row = mysqli_fetch_assoc($result)) {


                        if ($row['tipo'] == 1){
                            echo '<th data-priority="1" class="menuT1">T - '.++$t.'</th>';
                        }
                        if($row['tipo']== 2){
                            echo '<th data-priority="1" class="menuT1">MT - '.++$i.'</th>';
                        }
                        if($row['tipo'] == 3){
                            echo '<th data-priority="1" class="menuT1">Tr. - '.++$k.'</th>';
                        }
                    }

                    echo '<th data-priority="3" class="menuT1">Media de Freq.</th>';
                    echo '<th data-priority="4" class="menuT1">Res. Qualitativo</th>';
                    echo '</tr>';

                }

                echo '</thead>';

                echo '<tbody>';

                $var =0;

                $query = $pautaFreq->ordenacaoTestes($discp, $idAluno, $estado_pn,$idcurso, 0);
                $result = mysqli_query($db->openConection(), $query);

                if (mysqli_num_rows($result) > 0){

                    echo '<tr style="padding: 2em" align="center">';
                    echo '<td style="" align="center">'.$nomeDisp.'</td>';

                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($row['tipo'] == 1){

                            echo '<td>'.$row['nota'].'</td>';
                        }
                        if($row['tipo']== 2){

                            echo '<td>'.$row['nota'].'</td>';
                        }
                        if($row['tipo'] == 3){

                            echo '<td>'.$row['nota'].'</td>';
                        }

                    }
                    echo '<td>'.$media.'</td>';
                    if ($media >= 10 && $media< 16 ){
                        $estado = "Admitido";
                    }

                    if($media >=16){
                        $estado = "Dispensado";
                    }

                    if($media < 10){
                        $estado = "Excluido";
                    }
                    echo '<td class="ui-bar-b" style="background: #5a5a5a;border: none;
color: #ffffff; " align="center">'.$estado.'</td>';
                }

                $query = $pautaFreq->ordenacaoTestes($discp, $idAluno, $estado_pn,$idcurso, 0);
                $result = mysqli_query($db->openConection(), $query);
                $frm ="";

                $t=0;$i=0; $k=0;

                if (mysqli_num_rows($result) > 0){
                    $frm = 'MediaFreq = ';

                    while ($row = mysqli_fetch_assoc($result)) {
                        $peso = $pautaFreq->returnPesoAvaliacao($discp,$row['tipo']);

                        if ($row['tipo'] == 1 && $t==0){
                            $frm = $frm.'(MedT) * '.$peso/100;
                            $frm = $frm.' + ';

                            $t++;
                        }
                        if($row['tipo']== 2 && $k==0){
                            $frm = $frm.'(MedMT) * '.$peso/100;
                            $frm = $frm.' + ';

                            $k++;
                        }
                        if($row['tipo'] == 3 && $i==0){
                            $frm = $frm.'(Tr) * '.$peso/100;
                            $frm = $frm.' + ';

                            $i++;
                        }

                    }
                    echo '<tbody>';


                }

                echo '</table><br/>';
                echo '<div style="color: blue; font-weight: bold; font-size: 12px" align="center">'.$frm.' </div>';


            }

            break;


           case 3:



                     $db = new mySQLConnection();

                     $query = "SELECT disciplina.idDisciplina, disciplina.descricao FROM disciplina
                                        INNER JOIN docentedisciplina ON disciplina.idDisciplina = docentedisciplina.iddisciplina
                                        WHERE docentedisciplina.idCurso =".$_POST['curso'];
                     $result = mysqli_query($db->openConection(),$query);

                    echo' <select name="pdisciplina" class="drop" id="pdisciplina" style="width:33.5em;margin-top: -1em"  data-theme="c" data-native-menu="true">
                    <option value="" data-placeholder="false" disabled selected >Seleccionar Disciplina</option>
                     ';

                   while ($row= mysqli_fetch_assoc($result)){

echo '<option value="'.$row['idDisciplina'].'" onClick="set_item_curso(this.value)" data-theme="b">'.$row['descricao'].'</option>';
                   }
                    echo'</select>';
	    break;

        default:

              break;
    }


?>