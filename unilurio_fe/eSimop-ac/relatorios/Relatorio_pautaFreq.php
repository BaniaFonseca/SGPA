<?php

   require_once('../controller/PublicacaoQueryController.php');
   require_once("../functions/Conexao.php");
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/QueryController.php');

   require_once('../controller/QueryControllerEstudante.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/PublicacaoQueryController.php');
   require_once('../controller/PutaFrequenciaController.php');

require_once '../libs/fpdf/fpdf.php';
require_once '../libs/fpdf/fpdf.css';
define('FPDF_FONTPATH', '../libs/fpdf/font/') ;

   echo '<meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">';

   $ctr_est = new SqlQueryEstudante();
   $link = new mySQLConnection();
   $myvar = new PublicarPauta();
   $pautaFreq = new PautaFrequencia();
   $query = new QuerySql();



?>

<?php

            //Initialize the 3 columns and the total
            $column_nr = "";
            $column_nome = "";
            $column_nota = "";
            $docente ="";
            $scorrente = "";
            $teste ="";
            $curso="";
            $t =0;


                 $ptn = $_GET['ptn'];

                 $nome_disp=$myvar->pautaNormal($ptn, 0);
                 $idDisp=$myvar->pautaNormal($ptn, 1);
                 $idcurso = $myvar->pautaNormal($ptn, 2);
                 $nomeCurso = $myvar->pautaNormal($ptn, 3);
                 $tipo = $myvar->pautaNormal($ptn, 4);

                 $vetor  = $query->listar_tipo_avaliacao($idDisp, $idcurso, $tipo);

                 $t=0;
                 foreach ($vetor as $value) {

                      if ( $value!= null){++$t;

                           if (($value['idNota'] == $ptn)){
                               $var = $t.'º '.$value['descricao'];
                           }
                           if ($tipo > 3){
                               $var = $value['descricao'];
                           }
                     }
                 }

                 $teste = utf8_decode($var);

	       $pdf=new FPDF();

                 $pdf->AddPage();

                 $pdf->SetFont('Arial','B',10);

      $vetor = $ctr_est->novo_modelo_relatorio($ptn,2);
      $result= mysqli_query($link->openConection(),$vetor);
      $number_of_row = mysqli_num_rows($result);
      $i=0; $coluna= 76;



      while($row = mysqli_fetch_assoc($result)){
          if ($i == 0 ){
              $dp = $row['disp'];

          }
      if ($ctr_est->validar_busca_recorrencia($row['idEstudante'], $idDisp, $idcurso, 4) < 10){

           $i++;

                $column_nr = $column_nr.$row["nrmec"]."\n";
                $column_nome = $column_nome.$row["nomeCompleto"]."\n";
                $column_nota= $column_nota.$row["nota"]."\n";
			    if ($i > 1 ){
					  $pdf->SetXY(25,$coluna);
					  $pdf->Cell(165,5,"","B",1,'C');
					  $coluna= $coluna + 6.3;
		        }

             }
        }

              $pdf->Image('../img/unilurio.png',30,15,25);

              $pdf->setXY(25,40);
              $pdf->Cell(50,5,'Universidade Lurio - FE',0,0,'L');

              /*----------------------------------------------------*/

              if (date('m') > 0 &&  date('m') < 7){
                     $s= '1º Semestre';
                 }else{
                     $s =' 2º Semestre';
             }
             $scorrente = utf8_decode($s);

             /*-------------------------------------------*/

              $pdf->SetFont('Arial','',10);
              $anolectivo = date('Y');

              $pdf->setXY(65,25);

              $pdf->Cell(50,5,'Pauta '.$teste,0,0,'C');

              $pdf->setXY(65,30);
              $pdf->Cell(50,5,$scorrente,0,0,'C');

              $pdf->setXY(65,35);
              $pdf->Cell(50,5,'Ano Lectivo de '.$anolectivo,0,0,'C');

              $pdf->setXY(130,20);
              $pdf->Cell(50,5,'Visto',0,0,'C');

              //$pdf->setXY(140,25);
              //$pdf->Cell(50,5,'',0,1,'C');
              $pdf->setXY(130,30);
              $pdf->Line(130, 32, 180,32);


              $pdf->setXY(130,35);
              $pdf->Cell(50,5,$myvar->get_nome_adj(),0,0,'C');

              $pdf->setXY(130,40);
              $pdf->Cell(50,5,'Director Adj. Pedagogico',0,0,'C');

              $pdf->SetFont('Arial','B',12);
              $pdf->setXY(25,50);
              $pdf->Cell(50,5,'Curso: ',0,0,'L');

              $pdf->setXY(25,55);
              $pdf->Cell(50,5,'Disciplina: ',0,0,'L');

              $pdf->setXY(25,60);
              $pdf->Cell(50,5,'Data: ',0,0,'L');

              $pdf->SetFont('Arial','',12);
              $pdf->setXY(50,50);
              $pdf->Cell(50,5,$nomeCurso,0,0,'L');

              $pdf->setXY(50,55);
              $pdf->Cell(50,5,$nome_disp,0,0,'L');

              $data = date('Y-m-d H:i:s');
              $pdf->setXY(50,60);
              $pdf->Cell(50,5,$data,0,0,'L');

              $pdf->SetFillColor(2,23,23);
	    $pdf->SetTextColor(255,  255, 255);
                    //Bold Font for Field Name
              $pdf->SetFont('Arial','B',12);

              $pdf->SetXY(25,70);
              $pdf->Cell(40,6,'Nr.Mec',1,0,'L',1);

              $pdf->SetXY(60,70);
              $pdf->Cell(100,6,'Nome Completo',1,0,'C',1);

              $pdf->SetX(150,70);
              $cl ="Classificação";
              $pdf->Cell(40,6,utf8_decode($cl),1,0,'C',1);
              $pdf->Ln();

              ///Impressao de multiplas linha

                //$pdf->SetFillColor(240,240,240);

              $pdf->SetFont('Arial','',12);
              $pdf->SetTextColor('', '', '');
              $pdf->SetXY(25,76);
              $pdf->MultiCell(35,6,$column_nr,1,'C');


              $pdf->SetXY(60,76);
              $pdf->MultiCell(90,6,$column_nome,1,'L');


              $pdf->SetXY(150,76);
              $pdf->MultiCell(40,6,$column_nota,1,'C');

              $pdf->SetFont('Arial','I',8);
              // Page number
              $pdf->SetY(255);
              $pdf->Cell(0,5,'Docente/s da Disciplina',0,0,'C');
              $pdf->setXY(60,230);

              $pdf->SetXY(60,260);
              $pdf->Cell(85,5,"","B",1,'C');

              $db = new mySQLConnection();
              $dados= $ctr_est->buscarDadosDisciplina($idDisp,$idcurso);
              $result = mysqli_query($db->openConection(), $dados);

              $tt=0; $sexo=""; $doc= "";

              while($row = mysqli_fetch_assoc($result)){
                   $tt++;

              if ($row['idSexo'] == 1 && $row['grauAcademico']!='Msc.' && $row['grauAcademico']!="Ph.D"){

                         $sexo='º';

              }elseif($row['idSexo'] != 1 ){

                         $sexo='ª';
              }

             $doc.=$row['grauAcademico'].''.$sexo.'.  '.$row['nomeCompleto'].' ';

                if ($tt >= 1 && $row['idSexo']!=null){
                   $doc.="  , ";
                }
              }

              $docente = utf8_decode($doc);
              $pdf->Cell(0,10,$docente,0,0,'C');

              ob_clean();
              $pdf->Output($nome_disp.' - '.$teste.'.pdf','D');

              /*}elseif ($_GET['radio']== "on"){

              $nrmec = "";
              $nome ="";
              $mediaf ="";
              $rsQAmissao ="";
              $rsAvExame ="";
              $rsAvRec ="";
              $rsAvFinal ="";
              $rsFinalQual ="";
              $scorrente = "";


              $discp =$_GET['disp'];
              $cr=$_GET['curso'];
              $idcurso = $_GET['curso'];
              $curso = $query->queryMaster($idcurso);
              $disciplina = $pautaFreq->getnomeDisp($discp);

              $i=0;
              $cl=85;

              $pdf = new FPDF();
              $pdf->AddPage();

              $pdf->Image('../img/unilurio.png',80,15,25);

              $pdf->SetFont('Arial','B',10);
              $pdf->setXY(65,40);
              $pdf->Cell(60,10,'Universidade Lurio',0,0,'C');

              $pdf->setXY(64,45);
              $pdf->Cell(60,10,'Faculdade de Engenharia',0,0,'C');

              $pdf->SetFont('Arial','',10);
              $pdf->setXY(48,50);
              $pdf->Cell(100,10,'Campus Universitario Bairro Eduardo Mondlane',0,0,'C');

              $pdf->SetFont('Arial','',10);
              $ano = date('Y');

              /*----------------------------------------------------

              $pdf->setXY(120,65);
              $pdf->Cell(50,5,'Creditos:'.$anolectivo,0,0,'C');

              $pdf->setXY(123,70);
              $pdf->Cell(50,5,'Ano Lectivo:'.$anolectivo,0,0,'C');

              $pdf->setXY(137,75);
              $pdf->Cell(50,5,'Data: ',0,0,'L');

              $creditos = $query->get_creditos_ano($discp, 0);
              $pdf->setXY(155,65);
              $pdf->Cell(50,5,$creditos,0,0,'L');

              $pdf->setXY(160,70);
              $pdf->Cell(50,5,$ano,0,0,'L');

              $data = date('Y-m-d H:i:s');
              $pdf->setXY(147,75);
              $pdf->Cell(50,5,$data,0,0,'L');

              /*-------------------------------------------------

              $pdf->setXY(130,20);
              $pdf->Cell(50,5,'Visto',0,0,'C');

              //$pdf->setXY(140,25);
              //$pdf->Cell(50,5,'',0,1,'C');
              $pdf->setXY(130,30);
              $pdf->Line(130, 32, 180,32);

              $pdf->setXY(130,35);
              $pdf->Cell(50,5,'Director Adj. Pedagogico',0,0,'C');
              $pdf->setXY(130,40);
              $pdf->Cell(50,5,'',0,0,'C');

              /*-------------------------------------------------------

              $pdf->SetFont('Arial','',9);

              $pdf->setXY(25,60);
              $pdf->Cell(50,5,'Curso: ',0,0,'L');

              $pdf->setXY(25,65);
              $pdf->Cell(50,5,'Disciplina: ',0,0,'L');

              $pdf->setXY(25,70);
              $pdf->Cell(50,5,'Ano: ',0,0,'L');

              $pdf->setXY(25,75);
              $pdf->Cell(50,5,'Docente: ',0,0,'L');

              $pdf->setXY(50,60);
              $pdf->Cell(80,5,"Licenciatura em ".$curso,0,0,'L');

              $pdf->setXY(50,65);
              $pdf->Cell(50,5,$disciplina,0,0,'L');

              /*-------------------------------------------------------
              if (date('m') > 0 &&  date('m') < 7){

                     $s= 'º     Semestre:  1º';
                 }else{
                     $s ='º     Semestre:  2º';
               }
               $scorrente = utf8_decode($s);

              $ctr=$ctr_est->buscarDadosDisciplina($discp);
              $db = new mySQLConnection();
              $docente ="";
              $rs = mysqli_query($db->openConection(), $ctr);

              while ($row= mysqli_fetch_assoc($rs)) {
                    $t++;
                    if ($t > 0){
                        echo ' e ';
                    }$docente.= $row['nomeCompleto'];}

             /*-------------------------------------------------------
              $ano = $query->get_creditos_ano($discp, 0);

              $ano= $ano.''.$scorrente;

              $pdf->setXY(50,70);
              $pdf->Cell(50,5,$ano,0,0,'L');

              $pdf->setXY(50,75);
              $pdf->Cell(50,5,$docente,0,0,'L');

              /*--------------------------------------------------------

              $pdf->SetFillColor(0,  0, 0);
              $pdf->SetTextColor(255,  255, 255);

              $pdf->SetFont('Arial','',8);

              $pdf->SetXY(20,$cl);
              $pdf->Cell(15,10,'Nr.Mec',1,0,'L',1);

              $pdf->SetXY(35,$cl);
              $pdf->Cell(30,10,'Nome Completo',1,0,'L',1);

              $pdf->SetX(65,$cl);

              $pdf->Cell(40,7,'Med. Freq',1,0,'L',1);

              $pdf->SetXY(90,$cl);
              $pdf->Cell(30,10,'Resultado Qual.',1 ,0,'L', 1);

              $pdf->SetXY(115,$cl);
              $pdf->Cell(20,10,'Nota Exame',1 ,0,'L', 1);

              $pdf->SetXY(132,$cl);
              $pdf->Cell(25,10,'Recorrencia',1 ,0,'L', 1);

              $pdf->SetXY(150,$cl);
              $pdf->Cell(15,10,'Av.Final',1 ,0,'L', 1);

              $pdf->SetXY(165,$cl);
              $pdf->Cell(25,10,'Res. Final Qual.',1 ,0,'L', 1);

              $link = new mySQLConnection();

              $consulta = "SELECT
                    estudante.nrEstudante,
                    estudante.nome,
                    estudante.apelido,
                    inscricao.idinscricao,
                    inscricao.semestre,
                    estudante.idEstudante,
                    curso.descricao
                    FROM
                    estudante INNER JOIN inscricao ON inscricao.idestudante = estudante.idEstudante
                    INNER JOIN curso ON curso.idCurso = inscricao.cursoCorrente
                    INNER JOIN inscricaodisciplina ON inscricaodisciplina.idinscricao = inscricao.idinscricao
                    WHERE inscricaodisciplina.iddisciplina = '$discp' AND curso.idCurso='$cr'";

                    //$pautaFreq->obterAlunoCurso($_GET['disp'], $_GET['curso']);
              $result = mysqli_query($link->openConection(), $consulta);
              $distCol= 92;

              $t=0;

              while ($row = mysqli_fetch_assoc($result)) {

                 $idAluno = $row['idEstudante'];
                 $nome = $row['nome'].' '.$row['apelido'];
                 $nrmec = $pautaFreq->getMecaEstudante($idAluno);

                 $mediaf =round ($pautaFreq->obterMediaFrequecia($discp, $idAluno, 2, $idcurso,0));  // obtem media do exame frequencia
                 $mymedia = $mediaf;

                 if ($mediaf < 10 ){

                        $rsAvRec= "--";
                        $rsAvFinal= "--";
                        $rsAvExame = "--";
                        $rsQAmissao= "Excluido";
                        $rsFinalQual ="Reprovado";

                     }

                    if ($mediaf >= 10 && $mediaf < 16){

                         $rsQAmissao ="Admitido";
                         $rsAvExame = round($pautaFreq->getNotaExame($discp, $idAluno, 2,$idcurso, 0),1); // obter nota do exame normal

                        if ($rsAvExame >= 10){

                           $rsAvRec= "--";
                           $rsAvFinal = round(($rsAvExame+$mediaf)/2);

                        }else{

                             $rsAvRec = $pautaFreq->getNotaExame($discp, $idAluno, 2,$idcurso, 1); //obtem nota do exeme de recorrencia
                             $rsAvFinal = round(($mediaf+$rsAvRec)/2);
                        }

                     }

                     if($mediaf >= 16){

                        $rsAvRec= "--";
                        $rsAvFinal= $mediaf;
                        $rsAvExame = "--";

                        $rsQAmissao= "Dispensado"; }


                    if ($rsAvExame >= 10 || $rsAvRec >= 10  || $mediaf >=16){

                           $rsFinalQual= 'Aprovado';
                    }elseif($rsAvRec < 10 ){

                           $rsAvFinal= "--";
                           $rsFinalQual= 'Reprovado';
                    }

              //Preechimnto de dados na pauta //

              $pdf->SetFont('Arial','',8);
              $pdf->SetTextColor('',  '', '');
              $pdf->SetFillColor(240,240,240);

              $pdf->SetXY(20,$distCol);
              $pdf->Cell(15,6,$nrmec,1,1,'L',1);

              $pdf->SetXY(35,$distCol);
              $pdf->MultiCell(30,6, $nome,1,1,'L',1);

              $pdf->SetX(65,$distCol);
              $pdf->Cell(25,6,$mediaf,1,1,'C', 1);

              $pdf->SetXY(90,$distCol);
              $pdf->Cell(30,6,$rsQAmissao,1,1,'L', 1);

              $pdf->SetXY(115,$distCol);
              $pdf->Cell(20,6,$rsAvExame,1,1,'C', 1);

              $pdf->SetXY(133,$distCol);
              $pdf->Cell(25,6, $rsAvRec,1,1,'C', 1);

              $pdf->SetXY(150,$distCol);
              $pdf->Cell(15,6,$rsAvFinal,1,1,'C', 1);

              $pdf->SetXY(165,$distCol);
              $pdf->Cell(25,6,$rsFinalQual,1,1,'R', 1);

              $distCol=$distCol+5;

              $pdf->setXY(10,255);
              $pdf->Cell(60,5,'Docente da Disciplina',0,0,'C');

              $pdf->setXY(150,255);
              $pdf->Cell(40,5,'Director do Curso',0,0,'C');

              $pdf->SetXY(25,260);
              $pdf->Cell(80,3,"","B",1,'C');

              $pdf->SetXY(150,260);
              $pdf->Cell(35,3,"","B",1,'C');

              $ctr=$ctr_est->buscarDadosDisciplina($discp);
              $db = new mySQLConnection();

              $rs = mysqli_query($db->openConection(), $ctr);
              $t=0; $cr; $dp;

              while ($row= mysqli_fetch_assoc($rs)) {
                    $t++;

                    if ($t > 0){
                        echo ' e ';
                     }

              $docente= $row['nomeCompleto'];
              $cr= $row['descricao'];

              }

              $pdf->Cell(50,10,$docente,0,0,'C');

             }

             ob_clean();
             $pdf->Output("Pauta Final -".$disciplina.'-'.$cr.'.pdf','D');*/




?>