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

require_once '../libs/fpdf/fpdf.php';
require_once '../libs/fpdf/fpdf.css';
define('FPDF_FONTPATH', '../libs/fpdf/font/') ;

define('FPDF_FONTPATH', '../fpdf/font/') ;

$ctr_est = new SqlQueryEstudante();
$link = new mySQLConnection();
$myvar = new PublicarPauta();
$pautaFreq = new PautaFrequencia();
$query_ctr = new QuerySql();

$idAluno=$ctr_est->getIdEstudante($_SESSION['username']);
$idc = $ctr_est->obterIdCursoEstudante($idAluno);


?>

<?php

//Initialize the 3 columns and the total
$column_tipo = "";
$column_nota = "";
$column_real = "";

$t =0;

if ($_GET['radio'] == "off"){

    $disp = $_GET['disp']; // obtemos o nome da disciplina
    $ptn = get_creditos_ano($disp, 2); // obtemos o id da disciplina

    $nome_disp=$myvar->pautaNormal($ptn, 0);
    $idDisp=$myvar->pautaNormal($ptn, 1);
    $idcurso = $idc; //$myvar->pautaNormal($ptn, 2);
    $nomeCurso = $myvar->pautaNormal($ptn, 3);
    $tipo = $myvar->pautaNormal($ptn, 4);

    $pdf=new FPDF();

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    $pdf->Image('../img/unilurio.png',92,15,20);

    $pdf->setXY(0,0);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetTextColor(255,255,255);

    $pdf->SetFont('arial','I',12);
    $pdf->cell(0,12,'eSimop-ac',1,$idc,'L',true);
    $pdf->SetTextColor('');

    /*----------------------------------------------------*/
    if (date('m') > 0 &&  date('m') < 7){

        $s= '1º Semestre ';
    }else{
        $s =' 2º Semestre ';
    }


    $s= $s.' / '.date('Y');
    $scorrente = utf8_decode($s);

    $pdf->SetXY(0,40);
    //$pdf->SetFillColor(14,128,23);
    $pdf->SetFont('arial','i',18);
    $pdf->SetTextColor(2,64,128);
    $pdf->SetFillColor('');


    $var = utf8_decode("Relatório das Avaliações - ");

    $pdf->Cell(0,10,$var.' '.$_SESSION['nomeC'],0,0,'C');
    $pdf->ln();
    $pdf->Cell(0,10,$scorrente,0,1,'C');

    $pdf->SetTextColor('');
    $pdf->SetFont('arial','I',13);
    $posX = 20;
    $posY = 40;

    $tipo=30;
    $nota=80;
    $data=130;

    $disciplinas = $ctr_est->estudanteDisciplina($idAluno, "", 0);

    foreach ($disciplinas as $row) {

        if ($row!= null && $ctr_est->obterQtdAvaliacaoPub($row['idDisciplina'],2,$idcurso, 0) > 0 ){

            $pdf->SetFillColor(2,23,23);
            $pdf->SetFont('Arial','',12);

            $pdf->SetXY($tipo,$posY-8.3);
            $pdf->Cell(50,8,''.$row['descricao'],1,1,'L');

            $pdf->SetTextColor(255,  255, 255);
            $pdf->SetXY($tipo,$posY);
            $pdf->Cell(50,10, utf8_decode('Tipo de Avaliação'),1,0,'C',1);

            $pdf->SetXY($nota,$posY);
            $cl ="Classificação";
            $pdf->Cell(60,10,utf8_decode($cl),1,0,'C',1);

            $pdf->SetXY($data,$posY);
            $pdf->Cell(50,10,utf8_decode('Data de Realização'),1,0,'C',1);

            //$idcurso = $query_ctr->obterCursoEstudante($_SESSION['username']);

            $query=$ctr_est->getpautaDate($row['idDisciplina'], $idAluno, 2, $idcurso);
            $validarRec = $ctr_est->estudanteRec($idAluno, 1);
            $pdf->SetTextColor(0,0,0);

            $db = new mySQLConnection();
            $result = mysqli_query($db->openConection(), $query);

            $t = 0; $t1=0; $t2=0; $t3=0;
            $number_of_row = mysqli_num_rows($result);

            $i=0;
            $validar_rec= $ctr_est->validar_busca_recorrencia($idAluno, $row['idDisciplina'], $idcurso, 5);

            if ($number_of_row > 0){
                while($rs = mysqli_fetch_assoc($result)){

                    if ($pdf->GetY() > 250){

                        $pdf->AddPage();
                        $pdf->SetFont('Arial','B',10);
                    }

                    if ($rs['tipo'] == 1){
                        $k = ++$t1;
                    }
                    if ($rs['tipo'] == 2){
                        $k = ++$t2;
                    }
                    if ($rs['tipo'] == 3){
                        $k = ++$t3;
                    }

                    $pdf->SetFont('Arial','',12);
                    $pdf->SetXY($posX+10.2,$posY+10);

                    if ($rs['tipo'] <= 3){

                        $pdf->Cell(50,8,$rs['descricao'].'-'.$k,1,'C');
                    }else{
                        $pdf->Cell(50,8,$rs['descricao'],1,'C');
                    }

                    $pdf->SetXY($posX+60.3,$posY+10);

                    $id = $idDisp = $ctr_est->returnTipo($rs['idNota'], 1);
                    if (($rs['tipo'] == 5) && ($ctr_est->validarRecorrencia($idAluno, $id)  == 1)){
                        $pdf->MultiCell(50,8,$rs['nota'],1,'C');
                    }else{
                        $pdf->MultiCell(50,8,$rs['nota'],1,'C');
                    }

                    $pdf->SetXY($posX+110.2,$posY+10);
                    $pdf->MultiCell(49.7,8,$rs['dataReg'],1,'C');

                    $posY=$posY+8;

                }

            }
        }

        $posY=$posY+30;

    }
    ob_clean();
    $pdf->Output("Pauta_".$_SESSION['nomeC']."/Ano-".date('Y')."/Resultados.pdf","i");

}elseif ($_GET['radio']== "on"){


    $pdf=new FPDF();

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    $pdf->Image('../img/unilurio.png',92,15,20);

    $pdf->setXY(0,0);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetTextColor(255,255,255);

    $pdf->SetFont('arial','I',12);
    $pdf->cell(0,12,'eSimop-ac',1,$idcurso,'L',true);
    $pdf->SetTextColor('');

    $pdf->setXY(80,80);
    $pdf->Cell(50,10,utf8_decode('Sem implementação'),0,0,'C');

    ob_clean();
    $pdf->Output('Pauta Final.pdf','I');


    /*$nrmec = "";
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
    $pdf->setXY(130,30);
    $pdf->Line(130, 32, 180,32);

    $pdf->setXY(130,35);
    $pdf->Cell(50,5,'Director Adj. Pedagogico',0,0,'C');

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
    $ano = get_creditos_ano($discp, 0);

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



   ob_clean();
   $pdf->Output("Pauta Final -".$disciplina.'-'.$cr.'.pdf','D');

   }*/
}

?>


<?php

function get_creditos_ano($disp, $ctr) {

    if($ctr == 0){
        $teste = "SELECT ano as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
    }
    if ($ctr == 1){
        $teste = "SELECT creditos as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
    }

    if ($ctr == 2){
        $teste = "SELECT idDisciplina as valor FROM disciplina WHERE disciplina.descricao = '$disp'";

    }

    $link = new mySQLConnection();
    $result= mysqli_query($link->openConection(), $teste);

    if ($row = mysqli_fetch_assoc($result)){

        return ($row['valor']);
    }


}


function obterIdCursoEstudante($e){

    $query ="SELECT DISTINCT estudante_disciplina.idcurso FROM estudante_disciplina
                              WHERE estudante_disciplina.idestudante = '$disp'";

    $db = new mySQLConnection();

    $result = mysqli_query($db->openConection(), $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['idCurso'];
    }
}

?>