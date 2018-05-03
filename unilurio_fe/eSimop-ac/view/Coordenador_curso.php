<?php
   session_start();
   
   if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.html";
    </script>


<?php }

   require_once('../controller/PublicacaoQueryController.php');
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
   $idDoc = $query->getDoc_id($_SESSION['username']);
   $pautaControlle = new PublicarPauta();
   $myvar = 0;
?>


<!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">

<meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">
<title>Coordenador_curso</title>

    <link href="../libs/jquery-mobile/jquery.mobile-1.0.min.css" rel="stylesheet" type="text/css"/>
    <script src="../libs/jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="../libs/jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
    <script src="../libs/jcanvas.min.js"></script>
    <script src="../../_assets/js/jquery-1.7.1.min.js"></script>
    <script src="../../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../../_assets/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="../../_assets/js/jquery-1.11.2.min.js"></script>

    <script type="text/javascript" src="../libs/jqueryAlerts/scripts/jquery.alerts.js"> </script>
    <link type="text/css" href="../libs/jqueryAlerts/css/jquery.alerts.css" rel="stylesheet"/>
    <script type="text/javascript" src="../js/js_function.js"></script>
    <link rel="stylesheet" href="../css/cabecalho.css" type="text/css">
    <!----------------------------------------------------------My libs --------------------------->

    <link rel="stylesheet" href="../css/button_style.css" type="text/css">


    <!-------------------------------------------- fim -------------------------------------------->

<style>
            body {
                  font-family: serif;
                  font-size: 13px;
              }

            .movie-list thead th,
            .movie-list tbody tr:last-child {
                border-bottom: 1px solid #d6d6d6; /* non-RGBA fallback */
                border-bottom: 1px solid rgba(0,0,0,.1);
            }
            .movie-list tbody th,
            .movie-list tbody td {
                border-bottom: 1px solid #e6e6e6; /* non-RGBA fallback  */
                border-bottom: 1px solid rgba(0,0,0,.05);
            }
            .movie-list tbody tr:last-child th,
            .movie-list tbody tr:last-child td {
                border-bottom: 0;
            }
            .movie-list tbody tr:nth-child(odd) td,
            .movie-list tbody tr:nth-child(odd) th {
                background-color: #eeeeee; /* non-RGBA fallback  */
                background-color: rgba(0,0,0,.04);
            }

            .custom-corners .ui-bar {
              -webkit-border-top-left-radius: inherit;
              border-top-left-radius: inherit;
              -webkit-border-top-right-radius: inherit;
              border-top-right-radius: inherit;
            }
            .custom-corners .ui-body {
              border-top-width: 0;
              -webkit-border-bottom-left-radius: inherit;
              border-bottom-left-radius: inherit;
              -webkit-border-bottom-right-radius: inherit;
              border-bottom-right-radius: inherit;
            }

            .controlgroup-textinput{
                padding-top:.22em;
                padding-bottom:.22em;
            }

            #inputs:input{
                   padding:0 30px;
                   font-size: 10px;
            }
            #resultados li a{text-decoration: none;}

           .sl{


          padding: 5px 15px;
          background:#193742;
          border: none;
          border-radius:2px;
          color:white;

          }

          .texta{
                    width: 70%;
                    padding:25px;
                    border-radius: 5px;
                    font: serif;
                    font-size:13px;
                    border: 1.5px solid black;

          }
          .inpute{

               width: 70%;
               border-radius: 5px;
               padding: 5px;
               border: 1.5px solid black;
          };

          .marge{
               font-weight: normal; font-family: serif; font-size: 13px;

               width: 320px;
          }




</style>



</head>
<body>


<div data-role="page" id="pagina">

    <div data-role="header" style="border-bottom: none;" data-theme="b" data-position="fixed" data-fullscreen="false">
        <h3>&nbsp;</h3>
        <!---   style="background:#006099"-->

        <div style="float: left; margin-left: 1em; margin-top: -2em; margin-bottom: 1em">
            <a href="#search"><img src="../../_assets/img/icons-png/bars-white.png" width="20px" class="main_menu"></a></div>
        <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
            <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp; <a href="">
                <img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>

    </div>


     <div data-role="content" style="margin-top: 3em" align="center">
              <div class="ui-corner-all custom-corners" style="width: 96%;" >

                  <div class="ui-bar ui-bar-a" style="border:none; border-bottom: 4px solid #ff9933; background: #ccc; ">

                      <h3 style="float:left; font-family:serif"><br>

                          <a href="" class="sv" id="reg_plano" style="font-family: serif; color:white;">Plano de Avaliação</a>
                          <a  href="" class="sv" id="relatorios" style="font-family: serif; color:white;">Relatórios</a>
                          <a  href="" class="sv" id="reg_pauta" style="font-family: serif; color:white;">Nova Pauta</a>
                          <!--hr style="border: 2px solid #ff9933"--->

                      </h3>

                  </div>

    <div class="ui-body ui-body-c"> <br><br>

         <div style="width: 90%; margin-top: 1em">

        <ul data-role="listview" data-filter="true" data-filter-placeholder="Buscar disciplina... nome" data-inset="true" class="pauta1">
            <li data-theme="b"><h3 align="center">Disciplinas Submetidas</h3>
  </li>

     <?php

        $var =0;
        $qtd=0;
        $listaCurso = $pautaControlle->listapautaCurso(1, $idDoc);
        $anolectivo = date('Y');
              if (date('m') > 0 &&  date('m') < 7){
                     $s= '1º Semestre';
                 }else{
                     $s =' 2º Semestre';
             }
             $scorrente = $s.' de '. $anolectivo;

             /*-------------------------------------------*/

        foreach($listaCurso as $linha) {

            if ($linha != null && $pautaControlle->qtdAvaliacaoPublicada(1, $linha['idcurso']) > 0 ){
                      $var ++ ;
                      $qtd = $pautaControlle->qtdAvaliacaoPublicada(1, $linha['idcurso']);
                ?>
           
        <li value="<?php echo $linha['idcurso'] ?>" data-role="list-divider" data-theme="d" class="cursos"><div style="color:green">
        <?php echo $linha['curso'] ?></div> <span class="ui-li-count" data-theme="b"><?php echo $scorrente; ?>
             </span> </li>

        <?php

            $listaDisp = $pautaControlle->listaDisciplinaCurso(1,$linha['idcurso']);

            foreach($listaDisp as $disp){
                if ($disp!= null){?>

         <li value="<?php echo  $disp['ptn'] ?>" class="disciplina">

            <a href="#" > <img src="../../_assets/img/icons-png/eye-black.png" class="ui-li-icon ui-corner-none">
                <p><h6 style="font-size:12px; margin-left:2em"><?php echo  $disp['descricao'] ?></h6> <div style="font-size:10px;">
                <?php echo '[ '.  $disp['qtd']. ']  - ' ?>Avaliação</div> </p>
            </a>
         </li>

        <?php } } } } ?>
        <li data-theme="e"><div align="center">Total de disciplinas  <span style="color:blue"> <?php  echo $qtd?></span> </div></li>
     </ul>

    </div>
 </div>

 </div>

     </div> <!--------- fim content------->

     <div data-role="footer" data-position="fixed" data-theme="c" align="right"><br>

         <a href="#" style="margin-right: 1em " data-icon="plus" class="sair" data-iconpos="right">Sair</a><br>
    </div>

</div>


</body>
</html>


<script type="text/javascript" charset="utf-8">

$(document).ready(function(e) {


    $('#reg_plano').click(function(){
        window.location= "Plano_avaliacao.php";
    })

    $('#relatorios').click(function(){
        window.location= "Editar_pauta.php?acao=10";
    });


 $('.resultados').on('click','li ', function(){

         $('.resultados li.current ').removeClass('current').css({'background':'white', 'color':'black'});
         $(this).closest('li').addClass('current');
         $(this).closest('li ').css({'background':'rgba(220,220,250,255)', 'color':'blue'});

    })

   $('#reg_pauta').click(function(){
      window.location ='Docente_pauta.php';
   });

    $('.cadastro_pauta').click(function (){

        window.location ='Docente_pauta.php';
    })

    $('.back_esimop').click(function() {
         window.location = "../index.html";
    });

    $('.main_menu').click(function (){

        window.location = "Coordenador_curso.php#pagina";
    });

    $('.refresh_home').click(function (){
         location.reload(1).show('slow');
    });

	//Evento clique sobre a linha da disciplina a publicar

    $('.pauta1 li').click(function (){

        var s = $(this).val();

        if (s > 0){

            window.location ='Processa_publicacao_pauta.php?disciplina='+s;

            localStorage.setItem("envio", s);
        }
    });

    $('.anterior').click(function (){

        Javascript:history.go(-1);
    })


    /*-------------------------- salva plano e tratamento de datas --------------------------------------*/
    $('.opercao').click(function() {
          $('.botons').show('slow');
       });

   $('.sair').click(function(){
        window.location="../index.html";
    });



        /*

         * Novo codigo ------------------------------------------------------------------------------------
         * */


          $('.goIndex').click (function (){
              window.location = "../index.html";
          })


          $('.qtd_avaliacao').click(function (){
          	 $('.with_botton').hide('slow');
          	 $('#inputs').show('slow');
          	 $('.visualizar_plano').hide('slow');

          })



  $('.home').click(function (){
	window.location="Docente_pauta.php";
  });

   });


 function logout()  {
    window.location="../index.html";
}


</script>
