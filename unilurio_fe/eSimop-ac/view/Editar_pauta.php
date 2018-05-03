<?php

    session_start();
	if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.html";
    </script>


<?php }
    require_once("../controller/QueryController.php");
    require_once("../controller/DisciplinaController.php");


    $query = new QuerySql();
    $idDoc = $query->getDoc_id($_SESSION['username']);
    $auto = new DisciplinaController();
    $teste = FALSE;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editar Nota</title>


<link href="../../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
<link href="../../_assets/css/jquery.mobile.structure-1.4.3.min.css" rel="stylesheet" type="text/css"/>
<link href="../../_assets/css/jquery.mobile.theme-1.4.3.min.css" rel="stylesheet" type="text/css"/>
<script src="../../_assets/js/jquery-1.11.3.min.js" type="text/javascript"></script>

<script src="../../_assets/js/jquery-1.11.2.min.js"></script>

<script src="../../_assets/js/jquery-1.8.3.min.js"></script>
<script src="../../_assets/js/jquery.mobile-1.4.3.min.js"></script>

<script type="text/javascript" src="../js/js_function.js"></script>
<script type="text/javascript" src="../libs/jqueryAlerts/scripts/jquery.alerts.js"> </script>
<link   type="text/css" href="../libs/jqueryAlerts/css/jquery.alerts.css" rel="stylesheet"/>
<link rel="stylesheet" href="../css/cabecalho.css" type="text/css">
    <link rel="stylesheet" href="../css/edit_pauta_style.css" type="text/css">
    <link rel="stylesheet" href="../css/estudante_style.css" type="text/css">


<style>

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
    .nota{

        padding-bottom: .22em;
    }

    #resultado{

        background:-webkit-linear-gradient(white, #a3ffff , white);
        background:-ms-linear-gradient(white, #a3ffff , white);
        background:-o-linear-gradient(white, #a3ffff , white);
        background: -moz-linear-gradient(white, #a3ffff , white);

    }

    #resultado hover{background: black;}

    .ui-li-static.ui-collapsible > .ui-collapsible-heading {
    margin: 0;
}
.ui-li-static.ui-collapsible {
    padding: 0;
}
.ui-li-static.ui-collapsible > .ui-collapsible-heading > .ui-btn {
    border-top-width: 0;
}
.ui-li-static.ui-collapsible > .ui-collapsible-heading.ui-collapsible-heading-collapsed > .ui-btn,
.ui-li-static.ui-collapsible > .ui-collapsible-content {
    border-bottom-width: 0;
}

.lista_disp{
                    width:360px; margin-right: 1em; float: left;
                    box-shadow: 1px 1px 10px 0 #aaa;
          }

</style>

</head>
<body>

<div data-role="page">

    <div data-role="header" class="config_header" data-position="fixed" data-theme="b">

           <h6>&nbsp;</h6>

         <div style="float: left; margin-left: 1em; margin-top: -2em; margin-bottom: 1em">
             <a href="#pesquisa"><img src="../../_assets/img/icons-png/bars-white.png" width="20px" class="main_menu"></a></div>

         <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
              <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp; <a href="" id="" data-rel="popup" data-transition="slideup">
                        <img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>
     </div>

    <div data-role="content" id="conteudo" align="center">

	<div style="width:92%; margin-top:6em;">


	          <?php if ($_GET['acao'] == 10){?>

	            <div class="ui-bar ui-bar-a ui-corner-all" align="left"><h3>Gestão de Relatórios</h3> <h1 class="nome_e"></h1>

                <div style="float:right; margin-top:-.5em; margin-right: -.5em">


<a href="" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-a pr_normal">Pauta Normal ou Exames</a>
<a href="" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-a pr_final" >Pauta Final</a>
<a href="#" onclick="desativar_Campo();" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-a">Relatório Semestral</a>

               </div>

	          <?php }else{?>

            <div class="ui-bar ui-bar-a ui-corner-all" align="left"><h3>Editar nota estudante </h3> <h1 class="nome_e"></h1>
                <div style="float: right" class="ctr_edit2">
                 <input id="pesquisar_est" data-mini="true" data-inline="true" style="width: 210px"
                 class="ui-body ui-bar-b"  placeholder="Buscar estudante ... nome" data-clear="true" type="search"/>

          </div>

	          <?php }?>


      <div class="ui-body ui-body-a ui-corner-all" style=""><br>

          <ul id="resultados" data-role="listview" data-inset="true" data-theme="b" style="width: 230px;  float:right"></ul>

                    <?php
                            if(($_SESSION['nsessao'] == "Coordenador" && $_GET['acao'] == 10 )){

                                   $teste=TRUE;

                             }else{

                            if ( ($_GET['acao'] == 2 && $_SESSION['nsessao'] != "Coordenador") ||

                                 ($_GET['acao'] == 2 && $_SESSION['nsessao'] == "Coordenador") ){

                                     $teste = FALSE;
                             }}
                    ?>

                    <?php if (($teste === FALSE) && ($_GET['acao'] == 2 || $_GET['acao'] == 10)){?>


          <div style="float:left;margin-top: 2em" class="lista_disp">

          <div align="center" style="margin-top: -.5em; height: 40px;color: green;"><br>

            Disciplinas Associadas ao Docente <?php echo ' - '. $_SESSION['nomeC']?>
          </div><br>
          <hr style="border:2px solid green">

		<ul data-role="listview" style="margin-top: 3em; margin-left: 1.5em; width: 300px;" data-inset="false" class="select_disp">

	              <li class="headers"><h3 style="margin-bottom: -.1em;margin-top: -.1em;color:white; font-family: serif; font-weight: normal">Seleccionar Disciplina</h3></li>

		  <?php

                        $temp = $query->listaCursoDocente($idDoc);

                        foreach($temp as $next){
                            if ($next['nomeC']!= null){

                        $disp = $query->listaDispCursoDocente($next['idC'],$idDoc);

                        foreach($disp as $row){
                            if ($row['nomeD']!= null){ ?>

                              <!--Mostra opcao de impressao  relatorio para um docente normal somente suas disciplinas -->

                         <?php if ($_GET['acao'] == 10 && $_SESSION['nsessao'] != "Coordenador"){?>
                           <li value="<?php echo $row['disp']?>" onclick="mostrar_relatorio(this.value)" id="valor_disp">

                               <input type="hidden" name="curso_hide" value="<?php echo $next['idC']?>" id="curso_hide"/>

                              <a href="#">

                             <?php if (($query->contaDisciplina($row['disp'], $idDoc)) > 1) {
                                    echo '<h3 style="color:green">'.$row['nomeD'].' - '. $next['nomeC'].'</h3>';
                             }else{
                                   echo $row['nomeD'];
                             }
                          ?>

                        </a></li>

                         <?php }else{?>

                              <!-- A lista eh passada o ID da disciplina que sera levado apos o click na linha -->
                               <li value="<?php echo $row['disp']?>" onclick="selecionaDisplina(this.value)">

                               <input type="hidden" name="curso_hide" value="<?php echo $next['idC']?>" id="curso_hide"/>

                                   <?php if (($query->contaDisciplina($row['disp'], $idDoc)) > 1) {
                                    echo '<h3 style="color:green">'.$row['nomeD'].' - '. $next['nomeC'].'</h3>';
                             }else{
                                   echo $row['nomeD'];
                             }?>

                              </li>

                    <?php } } } } }?>
</ul> <br><br>
		</div>



	<?php }elseif($teste === TRUE){?>

                    <div data-role="collapsibleset" data-iconpos="right" data-theme="a"
                     data-content-theme="a" data-mini="true" id="show_report" style="width: 360px; float: left">
               <?php

                        $db = new mySQLConnection();
                        $result = mysqli_query($db->openConection(),"SELECT idCurso, descricao from curso INNER JOIN docente
ON docente.idDocente = curso.coordenador WHERE docente.idDocente = '$idDoc'");
                        $t=0;
                        while ($row = mysqli_fetch_assoc($result)){
                                  $_SESSION['idc']=$row['idCurso'];
                                 ?>
                         <input type="hidden" name="curso_hide" value="<?php echo $row['idCurso']?>" id="curso_hide"/>
                         <div <?php if (mysqli_num_rows($result) > 1){?>

                               data-role="collapsible" data-theme="b" style="width: 350px">

                              <h3 style="width: 350px"><?php echo $row['descricao']?></h3>
                          <?php }?>
                         <ul data-role="listview" data-inset="true" data-theme="c" class="select_disp">

                        <?php
                              if (mysqli_num_rows($result) == 1){?>
                                <li data-theme="b"><?php echo'Disciplinas do curso de '. $row['descricao']?></li>

                         <?php }

                        $rs= mysqli_query($db->openConection(), $query->discplinasCurso($row['idCurso']));

                        while ($rx = mysqli_fetch_assoc($rs)) {?>

                       <li value="<?php echo $rx['disp']?>" onclick="mostrar_relatorio(this.value)" class="valor_disp">
                                 <?php  echo $rx['descricao'] ?> </li>

                        <?php }?>

                         </ul> </div>

                    <?php  } ?>


                    </div>


	          <?php }if ($_GET['acao'] == 10){?>

    <div style="float: right; margin-top: 23em; margin-right: -16em" class="botao_rep">


         <a href="#" id="print_report"  class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b">Mostrar Relatorio</a>


        </div><br>

        <?php } ?>




<div class="editar_nota" style="float:right; margin-top:1em">
<input type="text" value="" style="width:230px" id="nota" data-mini="true" data-inline="true"  placeholder="Atribuir Nova Classificação"/>

<a href="#" data-theme="b" style="font-size: 11px" id="validar_data_alt"
class="ui-btn ui-btn-b ui-corner-all ui-btn-icon-right ui-icon-check ui-shadow ui-btn-inline">Salvar</a>

    </div>
    <div align="center" class="sucesso"></div>

    <div class="ctr_report_final" style="float: right; width: 600px; border: 1px solid #ccc;border-radius:5px; margin-right: -17em">
          <div data-role="header" data-theme="b">

              <h3 style="color:white" class="resumo"></h3>

          </div>

    <div class="ui-content" data-theme="a" align="right">

          <input type="text" name="txtnomedisp" autofocus="true" value="" id="txtnomedisp" placeholder="Nome detalhado da Disciplina ..."/>

         <textarea name="txtmetaplano" id="txtmetaplano" style="padding: 18px" rows="10" cols="40" placeholder="Cumprimento do Plano ..." ></textarea>

         <textarea name="txtdetalhes" id="txtdetalhes" style="padding: 18px" rows="10" cols="40" placeholder="Sobre Avaliações ..." ></textarea>

        <textarea name="txtconstrg"  id="txtconstrg" style="padding: 18px" rows="10" cols="40" placeholder="Constrangimentos na Disciplina ..." ></textarea>
       <textarea name="txtdesafios" id="txtdesafios" style="padding: 18px" rows="10" cols="40" placeholder="Perspectivas ou Desafios ..." ></textarea>
       </div>

       <div data-role="footer" align="right">

        <a href="#" style="font-size:12px; background:#4682B4; color:white; border: none;" class="ui-btn ui-corner-all ui-shadow ui-icon-foward ui-btn-inline ui-btn-b"

                    data-theme="a" data-transition="flow" id = "btnRelatSemestral">Mostrar Relatorio</a>
      </div>


    </div>



</div>

<div class="mostrar_avaliacao" align="center"></div>

   </div>

   </div>

     <div data-role="footer" data-position="fixed" data-theme="a" align="right"">

       <!--a href="" style="float: left" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" onclick="abrir_tela ()">Sessão Anterior</a-->

         <button data-icon="power" style="font-size: 12px; font-family: serif" data-iconpos="right" data-inline="true" data-mini="true" onclick="sair_esimop(this.value)" id="sair">Sair</button>

     </div>

  </div><!-- /popup -->


   <div data-role="popup" id="menu_alterar"  data-dismissible="false" style="width:450px;">

    <div data-role="header" data-theme="c" align="left">

          <h1 style="color:blue">Incluir estudante <br> Efectuar Autenticação - Gmail</h1>
    </div>

    <div class="ui-content" data-theme="a" align="right"><br>

        <input type="text" name="email_doc" value="" id="email_doc" placeholder="Endereço electronico ..."/>
        <input type="password" name="senha_doc" value="" id="senha_doc" placeholder="Palavra passe .."/>
        <textarea height="100" name="txtmotivo" id="txtmotivo" rows="10" cols="40" placeholder="Escreva o motivo da inclusão ..." ></textarea>
        <input type="search" name="email_doc_ass" value="" id="email_doc_ass" placeholder="Email do Docente assoaciado ..."/>

    </div>
	<br><br>

	<div data-role="footer" align="right">

            <button id="btnEnviar"  data-theme="b" data-mini="true" data-inline="true"
			style="background:#4682B4; color:white; border: none;">Enviar</button>

		</div>

    <a href="#" id="close_g1" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>

</div>


<!---------------------------------- Sessao de popup ---------------------------------------->

  <!--inicio sessao de panel-->

        <div data-role="panel" id="pesquisa" data-theme="a" data-dismissible="false"
		class="ui-responsive-panel" data-position-fixed="true" data-position="left"
		data-display="overlay" style="width:22%;margin-top:3.33em">

		 <button style="float:right;font-family:serif;font-size:10px; border:none; color:red;background:white;
                     margin-top:-.2em" class="sair" data-inline="true" data-mini="true">Fechar</button>


                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                   <ul data-role="listview" data-theme="d"  data-inset="true">

                        <li data-theme="b" class="ui-bar ui-bar-a">Selecionar Opção </li>
                        <li data-icon="" class="newP ui-bar ui-bar-a">Menu Principal</li>
		    <li data-icon="" class="editp ui-bar ui-bar-a">Gerir Ausências</li>
		    <li data-icon="" class="np ui-bar ui-bar-a">Pesquisas</li>

                    </ul>
            </div>
     </div>
</body>
</html>

<script type="text/javascript">

var id_disp = 0, nome_completo;

    function autocomplet() {

        var min_length = 0;

         id_disp = $('select#sdisciplina').val();
        var keyword = $('#texto').val();

       if (keyword.length >= min_length) {
        $.ajax({
            url: 'Processa_auto_avaliacao.php',
            type: 'POST',

            data: ({keyword:keyword,disciplina:id_disp, acao:1}),
            success:function(data){

                $('#resultado').show();
                $('#resultado').html(data);
            }
        });

    } else {

        $('#resultado').hide();
    }
}

/**
 *Esta funcao busca a nota do estudante o nome e seu numero mecanografico para edicao
 *  */
function set_item(item) {

    if (item !=null){


        $('#texto').val(item);
        nome_completo = item;

        $('#resultado').hide();
        //$('.nextAction').show()
        $('.n_est').text(item).css('color','#ff9933');
        $('.textoFixo').text('Editar Nota Estudante').css('color','white');
        $('#texto').text('');
        $('.myNotas').show();
        $('#btnSave').hide();

        id_disp = $('select#sdisciplina').val();

        $.ajax({

            url: 'Processa_auto_avaliacao.php',
            type: 'POST',

            data: ({disciplina:id_disp, nomeapelido:nome_completo, acao:2}),
            success:function(data){

                $('.nome_est').html(data);
                $('#btnSave').hide();
            }

        })


    }else{
        $('.myNotas').hide();
    }
}


$(document).ready(function(e) {

      $('#close_resumo').click(function() {
           $('.select_disp').show('slow');
      });

    $('#back').click(function(){
        Javascript:history.go(-1);
    })

      $('.editp').click(function(){
	$('#menu_alterar').popup('open');
	$('#pesquisa').panel('close');
      });

      $('#btnRelatSemestral').click(function() {

              $('.select_disp').show('slow');

              var nomed = $('#txtnomedisp').val();
              var nd=nomed.toUpperCase();

              var disp = $('.select_disp li.current').val();
              var c = $('#curso_hide').val();
              var dsf = $('#txtdesafios').val();
              var ctrg= $('#txtconstrg').val();
              var av = $('#txtdetalhes').val();
              var cpl=  $('#txtmetaplano').val();

              $.ajax({

                      url: "../relatorios/Relatorio_semestral.php",
                      data:{nomedisp:nd, av:av, curso:c,disp:disp, cplano:cpl, constrag:ctrg, desafios:dsf, ctr:1},
                      success:function(rs){

                          window.location ='../relatorios/Relatorio_semestral.php?ctr=2';
                      }
              })

      });

      $('#sair').on('click', function(){

        $ajax({

            url:"User_login.php",
            type: "POST",
            data: {acao:3},
            success:function (result){
                window.location = "../index.html";
            }
        })
          });


          $('.sair').click(function(){
                    $('#pesquisa').panel('close');
          })


     $('#popupMenu').on('click','li', function(){

          $('#popupMenu li.current').removeClass('current').css({'background':'white', 'color':'black'});
          $(this).closest('li').addClass('current').css({'background':'#365775', 'color':'white'});

     });



     $('.select_disp').on('click','li', function(){

          $('.select_disp li.current').removeClass('current').css({'background':'white', 'color':'black'});
          $(this).closest('li').addClass('current').css({'background':'rgba(230,240,250,255)', 'color':'blue'});

          $('.sucesso').html('Buscar estudante ... nome').css('color','blue').hide(6000);


     });

    //id_disp = $('select#sdisciplina').val();

    $('#texto').on('keyup', function (){
        $('.n_est').text($(this).val()).css('color', 'blue');
    })

    $('select#sdisciplina').on('change', function (){

        $('.input_container').show();
    })

    $('select#sdisciplina').on('click', function (){

        id_disp = $(this).val();

    })
    $('#a_nota').on('change', function(){
        $('#btnSave').show();
    })

    $('.newP').on('click', function(){
        window.location="Docente_pauta.php";
    })

    $('.back').click(function() {
          $('#savaliacao').show('slow');
    });

    $('.myNotas').hide();
    $('.editar_nota').hide();
    $('#btnSave').hide();
    $('#a_nota').hide();
    $('#print_report').hide();
    $('.ctr_report_final').hide();

    //$('#savaliacao').hide();

          $('#resultados').click(function(){

             var campo = $('#resultados li a');

             for (var i = 0; i< campo.length; i++ ){
                    var nodo = campo[i];
                    $('.nome_e').html(' '+nodo.innerText).css({'color':'red','font':'serif','font-size':'15px'});
             }

          });

          $('#btnSave_nota').click(function(){

                    var un = $('#email_doc').val();
                    var pn = $('#senha_doc').val();
                    var dest= $('#email_doc_ass').val();
                    var msg =$('#txtmotivo').val();

                        var notas = parseFloat($('#nota').val());
                        $.ajax({
                              url:"Processa_edit_avaliacao.php",
                              type:"POST",
                              data:{nota:notas,email_doc_ass:dest,txtmotivo:msg,user:un, senha_doc:pn, acao:4, ctr:2},
                              success:function(result){

                              $('.sucesso').show();
                            $('.sucesso').html(result)
                            .css({'color':'red','font-size':'15px'}).fadeOut(12000);
                              $('#menu_editar').popup('close');

                              },
                        });
          });



          $('#validar_data_alt').click(function() {
                    $('.sucesso').show();

                $.ajax({

                    url:"Processa_edit_avaliacao.php",
                    type:"POST",
                    data:{acao:4, ctr:1},
                    success:function(result){
                     if (parseInt(result) == 1){

                jAlert ('\nA pauta ja foi publicada e o sistema nao permite\n'+
                'alterar classificações de pautas publicadas.\n','Atenção');

                     }else{


                        var notas = parseFloat($('#nota').val());
                      $.ajax({
                              url:"Processa_edit_avaliacao.php",
                              type:"POST",
                              data:{nota:notas, acao:4, ctr:2},
                              success:function(result){

                                $('.sucesso').html(result)
                            .css({'color':'green','font-size':'18px'}).fadeOut(12000);

                              },
                      });  //fim ajax1.

                 }

                 }, // fim sucesso

               });  //fim acao botao

           });
 });
//Busca estudante a editar nota

function selecionaDisplina(item){

      var c =$('#curso_hide').val();

       $('#pesquisar_est').keyup(function() {

	var min_length = 1;
	var keyword = $(this).val();

	$('#resultados').html("");

	        if (keyword.length >= min_length ) {

                         $('.editar_nota').hide();
		     sessionStorage.setItem('disp',item);


		     $('#resultados').html('<li data-theme="b"><div class="ui-loader"><span class="ui-icon ui-icon-loading"></span></div></li>');

                         $('#resultados').listview("refresh");
			   var row = "";
			    $.ajax({

				url : "Processa_lista_estudante.php",
				type:  "POST",
				dataType:"json",

				data: {keyword:keyword, curso:c, acao:4, disp:item},
				success : function(result){

                                        for (var i=0;  i < result.length ; i++){
                                           row += '<li value="'+result[i].nrmec+'" onClick="obter_estudante(this.value);" data-theme="b"><a>'+result[i].nomeCompleto + '</a></li>';

                    }

						$('#resultados').show();
						$('#resultados').html(row);
                        $('#resultados').listview( "refresh" );
                        $('#resultados').trigger( "updatelayout");
					}
				})

			}
       })


}

/*-----------Busca dados de estudante nome e numero mecnografico ---------------*/
function obter_estudante(item) {

    $('#pesquisar_est').val(item);

	$('#resultados').hide();
	var html = "", i;

	var c =  sessionStorage.getItem('disp');

	$.ajax({

		url : "Processa_auto_avaliacao.php",
		type:  "POST",
		data: {nrmec:item, disciplina:c, acao:2,ctr:1},

		success : function(result){

		      $('.sucesso').show();
		      $('.mostrar_avaliacao').html(result);
		      $('.sucesso').html('Seleccionar tipo de avaliação').css('color','green').hide(12000);
		}
	})
}


function desativar_Campo(){

         var campo = $('.select_disp li.current');

          for (var i = 0; i< campo.length; i++ ){
                    var nodo = campo[i];
                    $('.resumo').html('Relatorio Semestral  _'+nodo.innerText);
                    sessionStorage.setItem('ndisp',nodo.innerText);

          }

          if (campo.length > 0){
              ///$('.select_disp').hide();
            $('#print_report').hide();
            $('.ctr_report_final').fadeIn('slow');
          }else{
                    jAlert('Deve seleccionar a disciplina para mostrar o relatorio ','Caro utilizador', function (){
                              $('#menu_editar').popup('close');
                    });
          }



}

function get_list_avaliacao() {

       var c= $('#curso_hide').val();
       var disp = sessionStorage.getItem("disp");
       $.ajax({

                    url : "Processa_auto_avaliacao.php",
                    type:  "POST",
                    data: {curso:c, disciplina:disp, acao:2, ctr:2},

                    success : function(result){

                          $('.sucesso').show();
                          $('.mostrar_avaliacao').html(result);
                          $('.sucesso').html('Seleccionar tipo de avaliação').css('color','green').hide(12000);
                    }
          })
}

function mostrar_relatorio(item){


    // $('#menu_report').popup('open');
      $('.sucesso').html('Seleccionar o tipo de Relatorio').css('color','green').hide(9000);

     var c= $('#curso_hide').val();

      $('.pr_final').click(function(){

           window.location ="../relatorios/Pauta_final_excel.php?disp="+item+"&curso="+c;
      });

      $('.pr_normal').click(function() {


        $.ajax({

                    url : "Processa_auto_avaliacao.php",
                    type:  "POST",
                    data: {curso:c, disciplina:item, acao:2, ctr:2},

                    success : function(result){

                          $('.sucesso').show();
                          $('.mostrar_avaliacao').html(result);
                          $('.sucesso').html('Seleccionar tipo de avaliação').css('color','green').hide(12000);
                          //$('#menu_report').popup('close');

                    }
          })
    });

    $('.report_s').click(function() {

           //$('#menu_editar').show();


    });

    $('#report_f').click(function(){

        $('.select_disp').hide();
    })

}



 function obter_tipo_av(item) {

	$.ajax({

		url:"Processa_docente.php",
		type:"POST",
		data:{ptn:item, acao:6},
		success:function (rs){
		var x = parseInt(rs);

			if (x == 2){ // a pauta ja foi publicada

			    $('#print_report').show('slow');
			    $('.ctr_report_final').hide();

				$('#print_report').click(function() {

		window.location ="../relatorios/Relatorio_pautaFreq.php?ptn="+item;

				});

			}else{

				jAlert("Avaliação seleccionada ainda nao foi publicada!","Atenção");
			}

		}

	});

}

</script>
