<?php

   session_start();
   if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.html";
    </script>


<?php }

   require_once('../controller/PublicacaoQueryController.php');
   require_once('../functions/Conexao.php');
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');

   $pautaControlle = new PublicarPauta();
   $idptn= $_GET['disciplina'];
   $idDisp = $pautaControlle->pautaNormal($idptn, 1);

// alterado o parametro passado no get pauta normal nao disciplina
    $db = new mySQLConnection();
    $nome =$pautaControlle->pautaNormal($idptn, 0); // retorna o nome da disciplina
    $curso = $pautaControlle->pautaNormal($idptn, 2); // o identificado do curso
    $idDisp = $pautaControlle->pautaNormal($idptn, 1); // retorna o id da disciplina


?>

<!DOCTYPE html><html>
<head>
<meta charset="utf-8">
<title>Publicacao Pauta</title>


    <link href="../css/table_style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../css/edit_pauta_style.css" type="text/css">
    <link rel="stylesheet" href="../css/table_style.css" type="text/css">
    <link rel="stylesheet" href="../css/estudante_style.css" type="text/css">
    <link rel="stylesheet" href="../css/cabecalho.css" type="text/css">

    <link href="../../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_assets/css/jquery.mobile.structure-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_assets/css/jquery.mobile.theme-1.4.3.min.css" rel="stylesheet" type="text/css"/>

    <script src="../../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../../_assets/js/jquery.mobile-1.4.3.min.js"></script>
    <script type="text/javascript" src="../js/js_function.js"></script>
    <script src="../js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>
    <script type="text/javascript" src="../libs/jqueryAlerts/scripts/jquery.alerts.js"> </script>
    <link   type="text/css" href="../libs/jqueryAlerts/css/jquery.alerts.css" rel="stylesheet"/>

    <style type="text/css" media="screen">
        body{
            font-size: 13px;
            font-family: serif;
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

    </style>

 <script type="text/javascript">

    $(document).ready(function(e) {

    $('#cl_publicar').on('click',function (){

        Javascript:history.go(-1);
    })
	$('#back').click(function(){
	   Javascript:history.go(-1);
	})

    $('#sair').click(function(){
	window.location="../index.html";
    });

        // esta funcao remove a pauta da lista de publicacoes

    $('#btn_publicar').on('click', function (){

            var radios = $('btn_publicar')[0];

        for (var i = 0; i< radios.length; i++){

            if (radios[i].value != 0){

                $('.av_lista ul').fadeOut('slow');

                $.ajax({

                    url:"Processa_edit_avaliacao.php",
                    type:"POST",
                    data:{acao:6, pauta:radios[i].value},
                    success: function(data){
                         location.reload(1).fadeIn(20000);
                    }

                    }); // Termina a primeira requisicao ajax;*/
                }

              }

            });
       });

 function publicar(item)  {

     $.ajax({

        url:"Processa_edit_avaliacao.php",
        type:"POST",
        data:{acao:3, pauta:item},
        success: function(data){

             $('.av_lista li h5').html(data).css('color','red');
             $('.av_lista ul').fadeOut('slow');
             location.reload(1).fadeIn('slow');
        }
    });
 }

</script>

    </head>
<body>


      <div data-role="page" id="page2" data-transition="pop">

        <div data-role="header" class="config_header" data-position="fixed" data-theme="b">
               <h3>&nbsp; </h3>
			   
			   <div style="float: left;  margin-top: -2.5em; margin-left: 1em">

            <button style="float: left" id="back" data-icon="home" data-rel="back" data-iconpos="notext" value="Icon only" type="button"/>
                </div>

         <div style="float: right; margin-right: 1em; margin-top: -1.5em; color:yellow">
              <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp;<a href="#"><img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>

        </div>

        <div data-role="content" align="center">

            <div class="ui-bar ui-bar-a headers" style=" background: none; width: 88.5%; border:none;border-bottom:5px solid #ff9933 ">

                <div style=" margin-top: 4em;">

                    <h3 style="float: left; margin-left: -.8em; color:green; font-size: 16px; margin-bottom: -1em">Avaliações a Publicar na Disciplina de <?php echo strtoupper($nome)?> </h3>

                    <button style="float:right; margin-right: -1em" data-theme="b" data-icon="gear" data-iconpos="right"
                            data-mini="true" data-inline="true" style="font-size: 8px; padding: 8px 50px">Buscar Ajuda</button> </h3>

                </div>

            </div>

            <div data-role="collapsibleset" data-iconpos="left" data-theme="a"
                 data-content-theme="a" data-mini="true" style="width: 90%; margin-top: 2em">

               <?php

                $nota = '';

                $listaAvliacao = $pautaControlle->listaAvaliacaoDisciplina(1,$idDisp, $curso);
                $result = mysqli_query($db->openConection(),$listaAvliacao);

                if (mysqli_num_rows($result) <= 0){

                    echo("<script>window.location ='Coordenador_curso.php#pagina';</script>");
                }else{
                $k= 0;$t=0; $t1=0; $t2=0; $t3=0;

                while ($mylista = mysqli_fetch_assoc($result)){

                     $tipo = $mylista['avaliacao'];

                    if ($mylista['tipo'] == 1){$t = ++$t1;}

                    if ($mylista['tipo'] == 2){$t = ++$t2;}

                    if ($mylista['tipo'] == 3){$t = ++$t3;}

                    if ($mylista['tipo'] == 4 || $mylista['tipo'] == 5){$t="";}

                    ?>


                    <div  data-role="collapsible" data-theme="a" style="">



                        <h3 style=" font-size: 13px; font-family: Consolas;">
                            <?php echo  $mylista['avaliacao']. '-' .$t?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php echo ' Data de Registo:  '. $mylista['dataReg'] ?></h3>

                        <ul data-role="listview" data-count-theme="b"  data-inset="true" class="lista_view">

                            <li data-theme="a" class="ui-bar-b"><div align="right">Classificação obtida por Estudante</div></li>
                            <?php

                            $listaNota = $pautaControlle->listaNotaEstudante($idDisp,$mylista['ptn'],$mylista['idcurso'],1);

                            foreach($listaNota as $myNota){

                                if ($myNota!= null){ ?>

                                    <li data-theme="a" value="<?php echo  $myNota['idNota'] ?> " >
                                        <img src="../../_assets/img/icons-png/check-black.png "  class="ui-li-icon ui-corner-none" style="margin-bottom: -1em">
                                        <?php echo  $myNota['nomeCompleto']?>
                                        <span class="ui-li-count"><?php echo  $myNota['nota'] ?> </span></li>

                                <?php } } ?>


                            <li>
                                <button data-mini="true"data-theme="b" value="<?php echo $mylista['ptn']?>" id="btn_publicar" onclick="publicar(this.value)"
                                        data-inline="true" style="font-size: 12px; background: #4682B4;border:none; padding: 8px 30px">Publicar</button>


                            </li>

                        </ul>



                    </div>

            <?php  }?>
            </div>



    </div> <!--- end of content--->

    <div data-role="footer" data-position="fixed"  align="right">

       <a href="Coordenador_curso.php#pageM?disp=<?php echo $idptn ?>" data-icon="" data-iconpos="right" id="sv_publica"
          data-rel="dialog" data-theme="a" style="margin-right: 1em" >Notificar Docente</a>

    </div>

          <?php } ?>

</div>

<!--?php }?>

<!---------------------------------Pagina de Notificacao  ------------------------------->
    <div data-role="page" id="pageM">

        <div data-role="header" data-position="fixed" data-theme="b" align="center">
<h3>Disciplina a Notificar - <?php echo $pautaControlle->getNomeDsciplina($idDisp)?> </h3>

        </div>

        <div data-role="content" align="center">

            <label style="color:red">___Docente/s da disciplina___</label><br>

              <?php
                        $t=0;
                        $v = new QuerySql();
                        $proc = $v->listaDocentesDisciplina($idDisp);
                        $db = new mySQLConnection();
                        $result = mysqli_query($db->openConection(), $proc);

                        while ($row = mysqli_fetch_assoc($result)){ if ($t > 1){echo " e ";} $t++?>

                            <?php echo ' '.$row['nomeCompleto']?>

                        <?php }?><br>

                       <input type="email" data-theme="a" class="inpute ui-bar-b" name="txtemail"
                   placeholder="Endereco electronico ..." value="" id="txtemail"/>

                  <input type="password" data-theme="a" class="inpute ui-bar-b" name="txtsenha"
                   placeholder="Palavra passe ..." value="" id="txtsenha"/>

            <textarea data-mini="true" style="height:100px" data-theme="a" class="texta"
            placeholder="A mensagem a enviar..." name="txtarea" id="txtarea"></textarea><br>

                <div id="resultados"></div>

          </div>

      <div data-role="footer" align="right">

      <button data-mini="true" onclick="send_email(<?php echo $_GET['disciplina']?>)"
     data-theme="b" data-inline="true">Enviar Mensagem</button>

     </div>

</div>

</body>
</html>