<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.html";
    </script>


<?php }

require_once('../functions/Conexao.php');
require_once('../model/Curso.class.php');
require_once('../controller/QueryController.php');

require_once('../controller/SexoController.php');
require_once('../controller/QueryController.php');
require_once('../controller/QueryControllerEstudante.php');

require_once('../controller/PublicacaoQueryController.php');

$db = new mySQLConnection();
$ctr_est = new SqlQueryEstudante();
$query = new QuerySql();
$idDoc = $query->getDoc_id($_SESSION['username']);

$arrayCurso;
$arrayDisciplina;
$currentDisp = "";
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">

    <title>Cadastro pauta</title>




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


    <style type="text/css">

        body{
            font-size:13px;
            text-align:center;
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

        #disp, #avaliacao,#avaliacoPeso{
            margin-top:5em;
        }

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

        #nota{padding:3px;}


    </style>


</head>
<body>

<!-- inicio da pagina principal-->

<div data-role="page" id="pagina">

    <div data-role="header" data-position="fixed" style="border-bottom: none;" data-theme="b" class="config_header">
        <h3 style="padding: 10px">&nbsp;</h3>
        <!---   style="background:#006099"-->

        <div style="float: left; margin-left: 1em; margin-top: -2em; margin-bottom: 1em">
            <a href="#search"><img src="../../_assets/img/icons-png/bars-white.png" width="20px" class="main_menu"></a></div>
        <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
            <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp; <a href="">
                <img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>

    </div>

    <div data-role="content" id="conteudo" align="center">

        <div class="ui-corner-all custom-corners nova_pauta" style=" width: 90%; margin-top:7em">

            <div class="ui-bar ui-bar-b" style="background:#00516e; border:none;  border-bottom: 4px solid #ff9933;">
                <br><h3 >Disciplinas Associadas ao Docente <?php echo $_SESSION['nomeC']?> </h3><br>

            </div>

            <div class="ui-body ui-body-a" style="">

                <ul data-role="listview" data-inset="true"
                    style="margin-top:4em" class="docente_disp">

                    <li data-theme="a" class="" style="">

                        <h3> Selecionar Disciplina </h3></li>

                    <?php

                    $db = new mySQLConnection();
                    $query = new QuerySql();

                    $arrayCurso = $query->listaCursoDocente($idDoc);

                    $result = mysqli_query($db->openConection(),$query->listaDisciplina($idDoc, 0));

                    while ($row= mysqli_fetch_assoc($result)){?>


                        <li style="padding:-30em; background:white" value="<?php echo $row['idDisciplina']?>" onclick="buscar_disp(this.value)">

                            <a href="#"><img src="../../_assets/img/icons-png/check-black.png" style="padding:-20em">

                                <h1 style=" margin-bottom:-5em; color:blue;">
                                    <?php echo $row['descricao']?>

                                    <div style="color:#996633">
                                        <?php echo  $query->datalhes_disciplina($row['idDisciplina'], $idDoc)?> </div></h1>

                            </a>

                        </li>  <?php }?>

                </ul>

                <fieldset class="radioTipoAvaliacao no_div">

                    <select name="select-curso" data-mini="true" data-inline="true" id="select-curso" data-theme="a"
                            data-overlay-theme="c" data-native-menu="false">

                        <?php
                        $link = new mySQLConnection();
                        $consulta= $query->docenteCursoDisciplina($idDoc);
                        $result = mysqli_query($link->openConection(), $consulta);
                        while ($row = mysqli_fetch_assoc($result)) {?>
                            <option value="<?php echo $row['idCurso']?>"><?php echo $row['descricao']?></option>

                        <?php } ?>

                    </select>

                    <select name="select-tipo-avaliacao" data-mini="true" data-inline="true" id="select-tipo-avaliacao" data-theme="a"
                            data-overlay-theme="c" data-native-menu="false">

                        <option value="" data-theme="a" data-pleceholder="true" desable="desable">Seleccionar Tipo Avaliação</option> 
                                <option value="1">Teste</option>
                                <option value="2">Mini-Teste</option>
                        <option value="3">Trabalho</option>
                                
                        <option value="4">Exame-Normal</option>
                                <option value="5">Exame-Recorrencia</option>


                    </select>


                    <a href="#menu_enviar_pauta" data-position-to="window" data-rel="popup"
                       class="ui-btn ui-btn-a ui-corner-all ui-shadow ui-btn-inline
				ui-btn-icon-right ui-body-b ui-btn-a ui-icon-carat-r get_estudante"
                       data-transition="pop" >Buscar Estudantes</a>
                </fieldset>


            </div> <!-- end --><br>
            <div class="show" align="center"> </div>
        </div>


    </div> <!-- END TAB AVALICAO -->

    <!--Fim main content-->


    <div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer" align="right">

        <a href="#" style="border: none" class="ui-btn ui-corner-all ui-btn-inline ui-mini
            footer-button-left ui-btn-icon-right ui-body-b ui-btn-b ui-icon-power headers" onclick="sair_esimop(this.value)" id="sair">Sair</a>
    </div> <!-- end main footer-->


    <!----------------------------  SESSAO DE POPUP ------------------------------->


    <div data-role="popup" id="menu_enviar_pauta"  data-dismissible="false" style="width:700px;">

        <div  data-theme="a" style="border:none">

            <h3 style="color:darkgreen" class="resumo"></h3>

        </div>

        <hr style="border: 1.5px solid red">

        <div data-role="content" align="center">
            <h3 class="valida_nota"></h3>

            <table border="0" width="118%">
                <tr>
                    <td><input type="search" style="font: serif; font-size: 13px;" class="ui-bar-b"
                               placeholder="Filtrar estudante ... numero " id="search_est" name="search_est"/>
                    </td>
                    <td><button data-inline="true" data-theme="b" style=" background:forestgreen; color:white; border: none;
                margin-left: .5em; font: serif; font-size: 11px;" data-mini="true" id="btn_search_est"
                                onclick="search_est()">Buscar</button></td>
                </tr>
            </table>


            <table data-role="table"  id="table-custom-2" class="ui-body-d ui-shadow table-stripe ui-responsive">
                <thead>

                <tr class="ui-bar-b" style="background:#22aadd; border: none; color:white;font-size: 13px">
                    <th>&nbsp;</th>
                    <th align="center">Numero</th>
                    <th>&nbsp;</th>
                    <th align="center">Nome Completo</th>
                    <th align="center">Classificação</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody class="table_visualizar" style="font-size: 13px">

                </tbody>
            </table>

        </div><br>

        <div data-role="footer" align="right">

            <div class="ctr_disp"></div>

            <button data-theme="b" data-mini="true" data-inline="true" style="background:#007FFF; color:white; border: none;" class="add_pauta">Adicionar</button>

            <button data-theme="b" data-mini="true" data-inline="true" style="background: #4682B4; border: none" class="enviar_pauta">Enviar Pauta</button>
        </div>

        <a href="#" id="close_f" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-left" data-transition="flip">Close</a>

    </div>



    <!---------------------------- FIM POPUPS  E COMEC SESSAO DE PANEL------------------------------->

    <div data-role="panel"  id="search"  data-theme="a" data-dismissible="false"
         class="ui-responsive-panel" data-position-fixed="true" data-position="left"
         data-display="overlay" style="width:22.5%;margin-top:3.33em">


        <div style="float:right">

            <input data-icon="delete" class="sair" data-iconpos="notext" value="Icon only" type="button">

        </div>

        <br>
        <br>
        <br>
        <br>




        <ul data-role="listview" data-theme="d" class="tela_menu"  data-inset="true" style="margin-top: 6em">

            <li data-theme="b" class="ui-bar ui-bar-a">Selecionar Opção </li>

            <?php if ($_SESSION['nsessao'] == "Coordenador"){?>

                <li class="tela_pub ui-bar ui-bar-a">Publicação de Pauta</li>

            <?php }?>
            <li data-icon="" class="ui-bar ui-bar-a" id="editp">Alterar Dados de Pauta</li>
            <li data-icon="" class="ui-bar ui-bar-a" id="avafreq" value="10">Relatorios de Pauta</li>
            <li data-icon="" class="ui-bar ui-bar-a" id="plano_av">Plano de Avaliação</li>

        </ul>
    </div>

</div>  <!-- End min page -->

</body>
</html>

<script type="text/javascript">


    var nr =0,vez =0, tipo, idDisp = 0, ctr=0;
    var html = "";

    var vetor_nota=[], vetor_nmec=[], vetor_nome=[];

    var acesso = 0;
    var temp = false;
    var t1 = false, t2 = false;

    $(document).ready(function(e) {


        $('.sair').click(function(){
            $('#search').panel('close');
        });

        $('#close_f').click(function(){
            $('#menu_enviar_pauta').popup('close');
        })

        $('.cancelar_pauta:hover').mouseover(function(){
            $(this).css('background', '#8C1717');
        })

        if (localStorage.getItem('myval') == 3){

            $("#search").panel('open');
            localStorage.removeItem('myval');
        }

        $('.tela_pub').click(function() {

            window.location ="Coordenador_curso.php#pagina";
        });

        $('#pesq_est').keyup(function() {

            $.ajax({

                url : "Processa_lista_estudante.php",
                type:  "POST",

                data: {disp: 1, acao:3},
                success : function(result){
                    $('#conteudo_pesq').html(result);

                }
            });

        });

        $('.regplano').click(function() {

            window.location= "Coordenador_curso.php#page5";
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
        })


        $(document).on('swipeleft', function (event,ui){
            $("#lista").panel('open');
        })
        $(document).on('swiperight', function (event,ui){
            $("#search").panel('open');
        })

        $(document).on('swiperight', function (event,ui){
            $("#lista").panel('close');
        })
        $(document).on('swipeleft', function (event,ui){
            $("#search").panel('close');
        })

        $('#close_f').click(function(){
            location.reload(1);
        })

        $('.avafreq').click(function() {

            $("#lista").panel('close');
            $("#search").panel('close');
        });


        $('#editp').on('click', function (){

            window.location ='Editar_pauta.php?acao=2';
        })
        $('.newP').on('click', function (){
            $('#disp').show();
            $('#avaliacao').hide();
        });
        $('#nextPage').click(function(){
            window.location = "Plano_avaliacao.php";
        });

        $('.verPlano').on('click', function (){
            //$('#avaliacoPeso').show();
            $('#avaliacao').hide().fadeOut(1200);
        })

        $('#confimaDisp').on('click', function(){

            $('#avaliacao').show();
            $('#disp').hide().fadeOut(5000);

        })
        $('.myCurso').on('click', function (){
            $('#popupPauta').show();
        })

        /*----------------- fim Contolo de navegacao      ------------------------*/
        $('#popupMenu').on('click','li', function(){

            $('#popupMenu li.current').removeClass('current').css({'background':'white', 'color':'black'});
            $(this).closest('li').addClass('current').css({'background':'#365775', 'color':'white'});

        });

        $('.tela_menu').on('click','li', function(){
            $('.av_freq li.current').removeClass('current').css({'background':'white', 'color':'black'});
            $(this).closest('li').addClass('current').css({'background':'#365775', 'color':'white'});
        });


        $('.cl_back').click(function() {

            location.reload(1);
        });

        $('.docente_disp').on('click','li a', function(){

            $('.docente_disp li.current a').removeClass('current').css({'background':'#E8E8E8', 'color':'black'});
            $(this).closest('li').addClass('current');
            $(this).closest('li a').css({'background':'#E6E8FA', 'color':'blue'});


            if ($('select#select-tipo-avaliacao').val() == 0){

                $('.show').text("Seleccionar o tipo de avaliação/curso").css({'color':'green','font-size':'15px'});
            }

        });

        $('select#pcurso').change(function() {
            var dip = $('select#pcurso').val();

            $.ajax({
                url:"Processa_pauta_freq.php",
                type:"POST",
                data:{curso:dip, acao:3},
                success:function (result){

                    $('#p_disp').html(result);
                }

            })
        });

        $('#plano_av').click(function() {

            window.location= "Plano_avaliacao.php";
        });

        /*
         Funcao adicionar avaliacao ou classificacao num disciplina
         * */

        $('.add_pauta').click(function (){
            jConfirm('\nPretende Adicionar outra avaliação ou Classicação\n aos estudantes da Disciplina de '+sessionStorage.getItem('disciplina')+' \n\n', 'Confirmação', function(r){

                if (r){

                    $('.add_pauta').before($('#select-tipo-avaliacao').show());
                    $('#select-tipo-avaliacao').css({'padding':'7.8px','margin-right':'10px', 'background':'#4682B4'})
                    $('.add_pauta').css({'background':'#4682B4'});
                    $('.enviar_pauta').css({'background':'#007FFF'})

                    temp = false;
                }
            });
        });


        /*
         pesquisa o nome completo do estudante na insercao do nota
         */

        $('#search_est').keyup(function(){

            var size_t = 2;


            var content= $(this).val();

            if (content.length > size_t){
                $('.valida_nota').show();
                $.ajax({

                    url:"Processa_docente.php",
                    type:"POST",
                    data:{acao:10, nrmec:content},
                    success:function (result){

                        $('.valida_nota').html ('Estudante a pesquisar _'+result).css({'color':'green', 'margin-lef':'-5em'});

                    }
                })
            }

        })

    });

    $(document).ready(function(e) {

        $('#popTeste').hide();

        $('#operacao').hide();
        $('.frmcontrol').hide();
        $('#autocont').hide();
        $('#avaliacao').hide();
        $('#avaliacoPeso').hide();
        $('#visualizar').hide();
        $('.pesquisa_fim').hide();
        $('#ctrPoup').hide();
        $('.movie-list').hide();
        $('.get_estudante').hide();
        $('.cl_back').hide();
        $('#terminar_reg').hide();
        $('select#pptipo').hide();

    });


    function validarQtdAvaliacao (nr,idDisp) {

        $.ajax({

            url:"Processa_nota.php",
            type:"POST",

            data:{disp:idDisp, acao:7},
            success: function(result){

                if (result < 3){

                    jAlert ("\nRegiste no  minimo 3 tipos de avaliações na disciplina seleccionada.\n\n", "Atenção",function(r){if (r) return;});


                }else{

                    jAlert ("\nCarro Docente: \n"+
                    "\nO registo da avaliação de Exame Normal ou de Recorencia eh feita\n uma vez por Semestre,"+
                    "certifique se que ainda nao teve registado.\n\n","Atenção");

                    $('#get_estudante').show('slow');
                    $('.cl_back').hide();

                }

            } // fim sucesso ajax

        });
    }



    function buscar_disp(item) {

        sessionStorage.setItem('disp', item);
        var disp =item;

        $('select#select-tipo-avaliacao').change(function(){

            var c = $('select#select-curso').val();

            var desc= $('#select-tipo-avaliacao > option:selected').html();

            var tipo_av = $('#select-tipo-avaliacao').val();
            $('.resumo').show();

            $.ajax({

                url:"Processa_nota.php",
                type:"POST",
                data:{disp:item, acao:3},
                success:function (result){

                    var texto= jQuery.parseJSON(result)
                    sessionStorage.setItem('disciplina',texto);

                    $('.resumo').html('Disiciplina de  '+texto+' - '+desc);
                }
            });

            /*--------------------------------------------------------------------------------------------
             Faz valiadacao de docente se esta ou nao associado ao curso e disciplina seleccionada
             * */

            $.ajax({

                url:"Processa_docente.php",
                type:"POST",
                data:{curso:c,disp:item,acao:9},
                success: function(rs){
                    var result = parseInt(rs);

                    var curso = $('#select-curso > option:selected').html();
                    if (result == 0){

                        jAlert('O Docente não esta associado a disciplina\n'+
                        'seleccionada ao curso de '+curso,'Atenção', function(r){
                            if (r){return;}
                        });

                    }else{

                        $('.get_estudante').show('slow');
                    }

                }// fim sucesso
            }); // fim ajax;

            $.ajax({

                url:"Processa_nota.php",
                type:"POST",

                data:{tipo:tipo_av, disp:item,curso:c, acao:6},

                success: function(dados){

                    if (tipo_av >= 4){

                        $.ajax({

                            url:"Processa_nota.php",
                            type :"POST",
                            data:{tipo:tipo_av,disp:item, acao:8, ctr:1},
                            success: function (rs){

                                var result = parseInt(rs);
                                if (tipo_av == 4 ){
                                    if (result == 1){

                                        jAlert ('O Exame Normal ja foi registado e não deve ser repetido'+
                                        '\n','Atenção', function (r){if(r) return;});

                                    }else{validarQtdAvaliacao(nr, item);}
                                }

                                if (tp == 5){if (result == 1){

                                    jAlert ('O Exame de Recorrencia ja foi registado e não deve ser repetido\n'+
                                    '\n','Atenção', function (r){if(r) return;});


                                }else{

                                    $.ajax({

                                        url:"Processa_nota.php",
                                        type :"POST",
                                        data:{tipo:tipo_av, disp:item, acao:8, ctr:2},
                                        success: function (rs){

                                            $('.nome_e').html(rs);
                                            var rt = parseInt(rs);

                                            if (rt == 0 && result == 1){

                                                jAlert ("Deve registar primeiro a Avaliação do Exame Normal\n","Atenção", function (r){if(r) return;});

                                            }else{

                                                $('.get_estudante').show('slow');
                                                $('.cl_back').hide();
                                            }
                                        }// end sucess function
                                    })}}
                            } //end sucess
                        })

                    }else{
                        if (dados != 0){

                        }else{jAlert ("A quantidade maxima de "+desc+"s previstas no plano da disciplina\n Ja foram registas pelo que, nao pode ser efectuado mais registo\n","Caro Docente", function (r){if(r) return;});
                        }

                    }

                }  // fim sucesso ajax

            }); // fim requisicao ajax;

            /*--------------------------------------------------------------------------------------------------------*
             *
             */
            $('.get_estudante').click(function() {

                var html = '';

                $.ajax({

                    url : "Processa_lista_estudante.php",
                    type:  "POST",
                    dataType : "json",

                    data: {disp: disp,curso:c, acao:1},
                    success : function(result){

                        for(var i = 0 ; i < result.length; i++){

                            vetor_nmec.push(result[i].numero);

                            html+='<tr class="remove_tr"><td>&nbsp;</td><td class="nrmec">'+result[i].numero+'</td> <td>&nbsp;</td>';
                            html+='<td>'+result[i].nomeCompleto +'</td>';
                            html+='<td><input id="nota" onchange="validar_nota(this.value)" class="ui-bar ui-bar-d"' +
                            ' placeholder="Atribuir classificação"/>';
                            html+='<input id="nome_hide" value="'+result[i].nomeCompleto+'" name="nome_hide" type="hidden" /></td>';
                            html+='<td class="nrmec"><input type="hidden" id="btn_nrmec" value="'+result[i].numero+'"/> </td></tr>';
                        }

                        $('.table_visualizar').html(html).fadeIn('slow');

                    }

                })
            });

            /*----------------------------------------------------------------------------------

             * Insere primeiro a puata normal e depois segue a insercao da nota
             * A insercao da pauta normal eh feita por um requisicao sincrona
             * */


            $('.enviar_pauta').on('click', function(){

                $('.valida_nota').show();
                var notas = $('.remove_tr td #nota'); // vetor de notas em javascript
                var nrmec  = $('.remove_tr td #btn_nrmec'); // vetor de numeros mecanograficos
                var tipo_av = $('#select-tipo-avaliacao').val();

                if (temp == false && nrmec.length > 0 && notas.length > 0)  {

                    temp = true;

                    $.ajax({

                        url: "Processa_cadastro_pauta.php",
                        type:"POST",

                        data:{disciplina:disp, avaliacao:tipo_av, curso:c, acesso:1},
                        error: function(){jAlert("Nao foi possivel registar a pauta: ","Atenção");},
                        sucesss:function (result){} //fim success ajax primeiro;

                    }); //Termina primeira requisicao ajax ;

                    if (temp == true  && nrmec.length > 0 && notas.length > 0){
                        var t = 0;
                        for (var i =0; i< nrmec.length; i++){

                            if (notas[i].value >= 0 &&  notas[i].value!=""){

                                $.ajax({

                                    url: "Processa_cadastro_pauta.php",
                                    type:"POST",
                                    data:{nota:notas[i].value, nraluno:nrmec[i].value, acesso:2},

                                    success: function(dados){

                                        t++;
                                        $('.valida_nota').html('Pauta enviada com sucesso_   '+t+'#    estudante(s).')
                                            .css({'color': 'green','font-size':'16.5px'}).fadeOut(9000);
                                    }

                                });
                            } // fim primeiro if

                        } // fim ciclo for*/
                    }// fim primeiro if

                } // fim validacao do if


            }); // fim acao


        }); // fim acao select tipo avavaliacao

    } // fim funcao ctr disciplina

    function excluir_estudante(item){

        jConfirm('Excluir o estudante de numero [ '+item+']\n', 'Confirmação', function(r){
            if (r){
                $('.valida_nota').html('Excluido da lista').css({'color': 'green','font-size':'15px'}) ;

                /*$('.remove_tr tr.current').removeClass('current');
                 $('.remove_tr').remove('tr').fadeOut('slow');*/

            }else{
                $('.valida_nota').html('Nao foi excluido da lista').css({'color': '#996633','font-size':'15px'});
            }
        })
    }

    /*

     * fucao filtrar estudante no registo de pauta
     * */

    function  search_est(){

        var texto_fild = $('#search_est').val();
        var nomes  = $('.remove_tr td #nome_hide');
        var nrmec = $('.remove_tr td #btn_nrmec');


        for (var i = 0 ; i< nrmec.length; i++){

            if (nrmec[i].value == texto_fild){}
            $(function(){
                var search = texto_fild;
                $("table tr td").filter(function() {
                    return $(this).text() == search;
                }).parent('tr').css({'color':'blue', 'background':'#E0FFFF'});


                sortData(nomes[i].value);

            });

        }
    }

    //ordena elementos em ordem a primeira coluna
    function sortData(nomes){
        var tableData = document.getElementById('table-custom-2').getElementsByTagName('tbody').item(0);
        var rowData = tableData.getElementsByTagName('tr');
        var temp="";
        for(var i = 0; i < rowData.length - 1; i++){
            for(var j = 0; j < rowData.length - (i + 1); j++){
                if(parseInt(rowData.item(j).getElementsByTagName('td').item(0).innerHTML) > parseInt(rowData.item(j+1).getElementsByTagName('td').item(0).innerHTML)){

                    tableData.insertBefore(rowData.item(j+1),rowData.item(j));
                }else{
                    SortTable($('#table-custom-2'),'desc', nomes);

                }
            }
        }
    }

    // ordena em ordem crescente e decrescente
    function SortTable(table, order, texto) {
        var asc = order === 'asc',
            tbody = table.find('tbody');

        tbody.find('tr').sort(function (a, b) {
            if ($('td:nth-child(2)', a).text() == texto) return $('td:nth-child(2)', a).text();
            else if (asc) {
                return $('td:nth-child(2)', a).text().localeCompare($('td:nth-child(2)', b).text());
            } else {
                return $('td:nth-child(2)', b).text().localeCompare($('td:nth-child(2)', a).text());
            }
        }).appendTo(tbody);
    }

    function set_item_curso(item) {
        $('#ctrPoup').show();
    }

    function set_item_curso(item) {

        var s = item;

        $.ajax({
            url:"Processa_edit_avaliacao.php",
            data:{curso:s, acao:2},
            type:"POST",
            success:function(result){
                $('.movie-list').fadeIn(2000);
                $('.tabela').html(result);
                //$('.ctrpub').fadeIn();
            }
        })
    }

    function sair_esimop(item) {
        window.location="../index.html?acao="+item;
    }

    // controla insercao de registos

    function validar_nota(item){

        if (item < 0 || item > 20){

            jAlert('Inserir nota no intervalo de [0 a 20]','Caro Docente!');
            return;
        }
    }


    $(document).ready(function() {

        $('select#getAvaliacao').on('change', function (event){

            tipoavaliacao = $(this).val();

            $.ajax({

                url:"Processa_edit_avaliacao.php",
                data:({idNota:tipoavaliacao, acao:1}),
                type:"POST",
                success: function(result){

                    $('#btnSave').show();
                    $('#a_nota').show();
                    $('#a_nota').val(result);

                },

                error: function(){
                    jAlert ('Nao foi possivel registar!','Atenção');
                }
            })
            //return false;
        })

        /*--------------------Busca estdante na insersaco de notas ------------------------*/

        $('#avafreq').click(function() {

            var acao= $('#avafreq').val();
            window.location="Editar_pauta.php?acao=10";

        });

        $('#sair').click(function(){
            window.location="../index.html";
        });

        $('#pesquisar_est').keyup(function() {

            var min_length = 3;
            var keyword = $(this).val();
            $('#resultado').html("");

            var disp = $('.docente_disp li.current').val();
            var c =  $('select#select-curso').val();

            //var disp = sessionStorage.getItem('disp');

            if (keyword.length >= min_length) {

                $('#resultado').html('<li data-theme="b"><div class="ui-loader"><span class="ui-icon ui-icon-loading"></span></div></li>');
                $('#resultado').listview("refresh");

                var row = "";
                $.ajax({

                    url : "Processa_lista_estudante.php",
                    type:  "POST",
                    dataType:"json",

                    data: {keyword:keyword,curso:c, acao:4, disp:disp, ctr:1},
                    success : function(result){

                        if (result.length > 0){

                            for (var i=0;  i < result.length ; i++){
                                row += '<li value="'+result[i].nrmec+'" onClick="put_est_item(this.value);" data-theme="b"><a>'+result[i].nome +' '+result[i].apelido + '</a></li>';

                            }

                        }else{

                            row +='Nao foi encontrado';
                        }

                        $('#resultado').show();
                        $('#resultado').html(row);
                        $('#resultado').listview( "refresh" );
                        $('#resultado').trigger( "updatelayout");

                    }
                })
            }
        })


    });
</script>