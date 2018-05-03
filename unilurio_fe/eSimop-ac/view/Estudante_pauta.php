<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 30-Sep-15
 * Time: 6:26 PM
 */

        session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.html";
    </script>


<?php }
        require_once("../functions/Conexao.php");
        require_once('../controller/QueryControllerEstudante.php');
        require_once('../controller/PautaNormalController.php');
        $curso = '';
        require_once('../controller/PublicacaoQueryController.php');
        require_once('../controller/QueryController.php');
        require_once('../controller/EstudanteNotaController.php');
        require_once('../controller/PautaNormalController.php');

        $pautaControlle = new PublicarPauta();
        $var = new SqlQueryEstudante();
        $db = new mySQLConnection();
        $idAluno= $var->getIdEstudante($_SESSION['username']);
        $idcurso = $var->obterIdCursoEstudante($idAluno);
        $pautaControlle = new PublicarPauta();

        $query = new QuerySql();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">

    <title>Cadastro pauta</title>

    <style>

        body {
            font-family: serif;
            font-size: 13px;

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
        #res_tipo_av li a{text-decoration: none;}
        #res_tipo_av li{padding: 6px;}


        /*
         estilos do select disciplinas
         *
         * */


        .ui-selectmenu.ui-popup .ui-input-search {
                margin-left: .5em;
                margin-right: .5em;
        }
        .ui-selectmenu.ui-dialog .ui-content {
                padding-top: 0;
        }
        .ui-selectmenu.ui-dialog .ui-selectmenu-list {
                margin-top: 0;
        }
        .ui-selectmenu.ui-popup .ui-selectmenu-list li.ui-first-child .ui-btn {
                border-top-width: 1px;
                -webkit-border-radius: 0;
                border-radius: 0;
        }
        .ui-selectmenu.ui-dialog .ui-header {
                border-bottom-width: 1px;
        }

        .tablist-left {
            width: 25%;
            display: inline-block;
        }
        .tablist-content {
            width: 60%;
            display: inline-block;
            vertical-align: top;
            margin-left: 5%;
        }
        #save_pauta_freq {font-size:13px; ;background:darkgreen;
        border:none; padding: 8px 30px; font-family: serif; margin-right: -.1em;
        }
        #save_pauta_normal {font-size:13px; ;background:darkgreen;
            border:none; padding: 8px 30px; font-family: serif; margin-top: -1.7em; margin-right: -.1em;
        }


</style>

    <link href="../css/table_style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../css/estudante_style.css" type="text/css">
    <link rel="stylesheet" href="../css/table_style.css" type="text/css">
    <!--link rel="stylesheet" href="../css/cabecalho.css" type="text/css"-->

    <link href="../../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_assets/css/jquery.mobile.structure-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_assets/css/jquery.mobile.theme-1.4.3.min.css" rel="stylesheet" type="text/css"/>

    <script src="../../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../../_assets/js/jquery.mobile-1.4.3.min.js"></script>
    <script type="text/javascript" src="../js/js_function.js"></script>
    <script src="../js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>
    <script type="text/javascript" src="../libs/jqueryAlerts/scripts/jquery.alerts.js"> </script>
    <link   type="text/css" href="../libs/jqueryAlerts/css/jquery.alerts.css" rel="stylesheet"/>
    <script type="text/javascript" src="../js/js_estudante.js"></script>

    </head>

<body>


    <div data-role="page">

        <div data-role="header" data-theme="b" class="config_header" style="border: none;">
            <h3>&nbsp;</h3>

            <div style="float: left; font-size: 13px; font: consolas; margin-left: 1em; margin-top: -2.5em; margin-bottom: 1.5em"><a href="#search">
                    <img src="../../_assets/img/icons-png/bars-white.png" width="20px" class=""></a>&nbsp;eSimop-ac</div>

            <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow; font-size: 13px; font: consolas">
                <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp;<a href="#"><img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>

        </div>

        <div data-role="content">


            <div class="ui-corner-all custom-corners nova_pauta" style=" width: 95%; margin-top:2.5em; float: left">

                <div class="ui-bar ui-bar-a" style="background:none; border:none;  border-bottom: 3px solid #ff0000">

                    <h3 style="float: left; font-size: 15px; color:green; margin-left: -1em">Consultar Pautas Publicadas</h3>

                    <div style="float: right; margin-right: -1.3em">

                        <a href="#redes_sociais"  data-rel="popup"
                           class="ui-btn ui-btn-a ui-corner-all ui-shadow ui-btn-inline
                                        ui-btn-icon-right ui-body-b ui-btn-b ui-icon-navigation"
                           data-transition="slideup"  style="background: darkgreen; border:none;
                            padding: 8px 30px; font-size: 12px; margin-bottom: -.2em" >Conectar Redes Sociais</a>

                    </div>

                </div>



            <div data-role="tabs" style="width: 70%; margin-left: -.2em">
                <div data-role="navbar" >

                    <ul class="gerir_navbar">
                        <li value="1"><a href="#one" data-theme="a" >Disciplinas e Pautas Publicadas</a></li>
                        <li value="2"><a href="#two" data-theme="a" >Pesquisas Avançadas</a></li>
                        <li value="3"><a href="#outras_pesq" data-theme="a" >Mais Acções</a></li>
                    </ul>
                </div>


                <div id="one" class="ui-content">

                    <ul id="menu_disp_est" data-role="listview" data-inset="true" class="getPtn2" data-theme="a"
                        style="width:69%; margin-left: -1em; font-size: 13px; font: serif ">
                        <li data-theme="b">Disciplinas Associadas ao Estudante <?php echo $_SESSION['nomeC']?></li>
                        <input type="hidden" id="save_nome_disp"/>
                        <input type="hidden" id="save_nome_av"/>

                        <?php

                        $vetor =  $var->estudanteDisciplina($idAluno, "", 0);

                        foreach($vetor as $row){
                            if ($row!=null){
                                $disp = $row['idDisciplina'];
                                $curso=$row['curso'];

                                if ($var->obterQtdAvaliacaoPub($disp,2,$row['idCurso'], 0) > 0){?>

                                    <li value="<?php echo $row['idDisciplina']?>"  class="getDisp" onclick="buscar_av_publicada(this.value)">
                                    <a href="#two"><?php echo $row['descricao']?></a></li>

                                    <?php }else{?>

                                    <li class="ui-bar-a" value="<?php echo $row['idDisciplina']?>" style="color:blue" class="getDisp">
                                        <?php echo $row['descricao'] .'   [ Nenhuma Avaliação Publicada ] '?> </li>
                            <?php }} }?>

                    </ul>

                </div>  <!--fim TAB1--->

                <div id="two" class="ui-content">

                    <div data-role="collapsibleset" data-iconpos="left"
                         data-content-theme="a" data-mini="true" style=" margin-top: 1em; width:103.5%;
                           margin-left: -1em; background:#007CCC" class="main_div">

                        <div  data-role="collapsible" data-theme="c" style=" color:#008000">

                            <h3 style=" font-size: 13px; font-family: Consolas;">Detatlhes de Pautas Nommais</h3>

                            <div style="width: 30%; margin-top: 1em">

                            <input  type="search" data-mini="true" data-inline="true" id="disciplina"
                                    name="disciplina" placeholder="Buscar Disciplina ... nome" onkeyup="do_autocomplete_disp(this.value, 1)">
                            <ul id="resultado" data-role="listview" data-inset="true" data-theme="a" style="font-size: 12px"></ul>
                                </div>

                            <div class="myresult">
                                <h3 class="titulo2" style="color:green" align="justify"></h3>
                                <table data-role="table" id="table-custom-2"
                                       class="ui-body-d ui-shadow table-stripe ui-responsive"
                                       style="margin-top: 1em; margin-bottom: 3em">
                                    <thead>

                                    <tr class="ui-bar-b" style="background: #4682B4; font-size: 13px; border: none; color:white" align="center">

                                        <th >Tipo de Avaliação </th>
                                        <th >Classificação</th>
                                        <th >Data de Registo</th>
                                        <th >Data de Publicação</th>

                                    </tr>
                                    </thead>
                                    <tbody class="mycontente" style="font-size: 12px"></tbody>
                                </table>

                                <div align="right">
                                <button data-theme="b" data-mini="true" data-inline="true" data-icon="check" data-iconpos="right"
                                        class="save_style" id="save_pauta_normal">Guardar Resultado</button>
                                </div>

                            </div>

                        </div>  <!--fim colapsible 1--->

                        <div  data-role="collapsible" data-theme="a" align="center">

                            <h3 style=" font-size: 13px; font-family: Consolas;" id="detail" >Detatlhes de Pautas de Frequências</h3>


                            <div class="full_table" align="center">

                                <div class="contente_freq"> </div>
                                <br>
                                <div align="center">
                                    <hr style="border: 2px solid #ff9933; width:90%"></div>

                                <div align="right" style="margin-right: 3em">
                                    <!--button data-theme="b" data-mini="true" data-inline="true" data-icon="check" data-iconpos="right"
                                            class="save_style" id="save_pauta_freq">Guardar Resultado</button-->

                                    <a href="#mais_action" data-position-to="window"  data-rel="popup"
                                       class="ui-btn ui-btn-a ui-corner-all ui-shadow ui-btn-inline
                                        ui-btn-icon-right ui-body-b ui-btn-b ui-icon-gear"
                                       data-transition="turn" id="save_pauta_freq" >Avaliações de Exame</a>


                                </div>

                            </div>


                        </div>  <!--fim colapsible 1--->


                        <div  data-role="collapsible" data-theme="a" style="" align="right">

                            <h3 style=" font-size: 13px; font-family: Consolas;">Detalhes do Plano de Avaliação</h3>

                            <div style="margin-top: 1em;width: 30%">

                                <input  type="search" data-mini="true" data-inline="true" id="disciplinaX"
                                        name="disciplinaX" placeholder="Buscar Disciplina ... nome" onkeyup="do_autocomplete_disp(this.value, 2)">
                                <ul id="rs_plano_av" data-role="listview" data-inset="true" data-theme="a" style="font-size: 12px"></ul>
                            </div>


                            <div class="div_plano" style=" margin-bottom: 2em">

                                <table data-role="table" id="table-custom-2" data-mode="color" class="ui-body-c ui-shadow table-stripe ui-responsive">
                                        
                                    <thead>

                                          <tr class="ui-bar-b"  id="div-bar" style="background: #B0C4DE;border: none; color: #ffffff; font-size: 12px">
                                                
                                                <th >Tipo de Avaliação</th>
                                                <th >Peso</th>
                                        <th>Qtd. Maxima</th>
                                                
                                              </tr>
                                    </thead>

                                        <tbody id="table_plano_m" style="font-size:11px"> </tbody>
                                      </table>


                                <table data-role="table" id="table-custom-2"class="ui-body-c ui-shadow table-stripe ui-responsive">
                                        
                                    <thead>
                                    <div style="color:green" align="right">Datas previstas para realização de Avaliações</div>
                                          <tr class="ui-bar-b"  id="div-bar" style="background: #B0C4DE;border: none; color: #ffffff; font-size: 12px">
                                                
                                                <th >Testes</th>
                                        <th >Mini-Testes</th>
                                        <th >Outras Avaliações</th>
                                                
                                              </tr>
                                    </thead>

                                        <tbody id="table_plano1" style="font-size: 11px;"> </tbody>
                                      </table>

                            </div> <!---- Table show plano-->

                        </div> <!--fim colapsible 2--->

                    </div>  <!--fim colapsibleset--->
                </div>  <!--fim TAB2--->

                <div id="outras_pesq" class="ui-content" align="center">

                        <div id="one" class="ui-body-d tablist-content">
                            <h1 class="active_ano" style="color:blue;font-family: Consolas">
                            <?php echo 'Ano Activo  '. date('Y');?>
                            </h1>
                            <input type="hidden" id="txt_ano_activo" value="<?php echo date('Y');?>"/>

                        </div>
                </div>  <!--fim TAB3--->

            </div> <!--- fimm tabs -->
                </div> <!--- fimm CONNER ALL -->

            <div style="float: right; width: 320px; height: 470px; border: 1px solid #ccc;
             border-radius: 4px; margin-top: -19em;  margin-right: 4.5em;" class="res_av ctr_res_av"><br><br>

                <div style="padding: 5px 18px">

                <ul data-role="listview" id="res_tipo_av" data-inset="true" class="ui-body-b" style=" border:none;font-size: 13px;" >

                </ul><br>

                    <div class="descricao" align="center"> </div>

                </div>

            </div><!--   fim primeira div--->

                <div style="float: right; width: 320px; height: 480px; border: 1px solid #ccc;
             border-radius: 4px; margin-top: -9em;  margin-right: 4.5em;" class="res_av ctr_user_info"><br>

                    <div style="padding: 9px 18px">
                        <h3 style="text-align: justify; color: green; font-family: monospace">Caro Estudante:<br>
                            O sistema Móvel de Pautas Académicas Permite efectuar Consultas de resultados dos anos anteriores
                            e se assim for seleccione o ano que deseja e volta a realizar as consultas.
                        </h3>


                        <div id="select_ano" style="font-family: consolas">

                            <form class="ui-filterable">
                                <input id="autocomplete-input" data-mini="true" data-inline="true" data-type="search" placeholder="Buscar o ano ...">
                            </form>

                            <ul data-role="listview" data-filter="true" data-filter-reveal="true"
                                data-input="#autocomplete-input" data-inset="true" class="select_ano_list">


                                <?php


                                for($i = obter_ano_ingresso($_SESSION['username']); $i< date('Y'); $i++){?>
                                <li><?php echo $i; }?></li>
                                <li><?php echo date('Y')?></li>

                            </ul>
                        </div>


                    </div>







        </div>  <!--fim CONTENT--->

        <div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
            <h6 style=" float: left; font-family:serif; color: seagreen ">Unilurio Faculdade de Engenharia
                @Todos os direitos reservados (email:rjose@unilurio.ac.mz)</h6>

            <button style="float: right" id="sair" data-mini="true" data-inline="true" data-icon="power" data-iconpos="right">Sair</button>
        </div><!-- /footer -->


        <div data-role="popup" id="redes_sociais" data-theme="a" style="margin-top: 5em; width: 260px; margin-right: 2em">
            <ul data-role="listview" data-inset="true" style="min-width:210px; font-size: 13px;">
                <li data-theme="b" style="">Selecionar uma  Opção</li>
                <li><a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
                <li><a href="https://twitter.com/" target="_blank">Twitter</a></li>
                <li><a href="https://www.yahoo.com/" target="_blank">Yahoo</a></li>
                <li><a href="https://www.linkedin.com/" target="_blank">LinkedIn</a></li>
                <li><a href="https://www.youtube.com/" target="_blank">Youtube</a></li>
                <li><a href="http://www.google.com/" target="_blank">Google</a></li>
            </ul>
        </div>

        <div data-role="popup" id="mais_action" data-dismissible="false" style="width: 585px; margin-right: 1em; margin-top: 5em">
                    <div style="margin-left: 2em; margin-top: .5em">
                    <select style="font-size: 12px; font: serif;" id="select_freq" name="select_freq"
                            data-mini="true" data-inline="true" data-native-menu="false"  data-theme="a" onchange="gerir_frequencia_disp(this.value)">
                        <option value="0" data-placeholder="false" desable="desable">Seleccionar a Disciplina</option>

                        <?php

                        $vetor =  $var->estudanteDisciplina($idAluno, "", 0);

                        foreach($vetor as $row){
                            if ($row!=null){?>

                                <option value="<?php echo $row['idDisciplina']?>"onclick="gerir_avaliacao_disp(this.value)">

                                        <?php echo $row['descricao']?></option>

                            <?php } }?>

                    </select>
            </div><br>

        <hr style="border: 1.5px solid red; margin-top: -1em">

            <br><br><h3 id="mytitle" style="font-size: 13px" align="center"></h3>

            <h3 style="color:#236B8E; margin-top: 5em" class="showText" align="center">Seleccionar  a Disciplina e o Tipo de Exame</h3>

            <div style="padding: 5px 5px" align="center">

                <div id="avaliaco_freq"></div>
                  <br><br><br>

            </div>

            <h3 class="mytexto" align="center"> </h3>

            <div data-role="footer" align="right">

                <button  data-inline="true" data-mini="true"
                        style="font-size:13px;" value="1" id="ex_normal">Exame Normal</button>

                <button data-inline="true" data-mini="true"
                        style="font-size:13px;margin-left: -.5em" value="2" id="ex_recorrencia">Exame de Recorrência</button>

            </div>

            <a href="#" data-rel="back" id="active_log" class="ui-btn ui-corner-all ui-shadow
 ui-btn-b ui-icon-delete ui-btn-icon-notext ui-btn-right">Sair</a>
        </div>

    </div> <!-- fim page -->

</body>

</html>

<script type="text/javascript">


    /*
     *
     * Metodo autocomplete do docente
     * */

    $('document').ready(function(){
        $('.ctr_user_info').hide();

        $('.gerir_navbar li').click(function(){
            var valor = $(this).val();
            if (valor == 1){$('.res_av').show('slow'); $('.ctr_user_info').hide();$('.ctr_res_av').show();}
            if (valor == 2){$('.res_av').hide();}
            if (valor == 3){$('.ctr_user_info').fadeIn('slow');$('.ctr_res_av').hide();$('.ctr_res_av').hide();}
        });

        $('#active_log').click(function(){
            $('.main_div').fadeIn('slow');
        });

        $('#save_pauta_freq').click(function(){
            $('.main_div').hide();
        })

        $('.descricao').html('Selecionar a Disciplina que deseja visualizar os resultados !')
            .css({'color':'blue','font-size':'32px','textAlign':'center','font-family':'consolas'});


        $('#detail').click(function() {

            var vetor = $('#select_freq')[0];
            $('.contente_freq').html("");
            $('.displinas_est').hide();

            for (var i = 0; i< vetor.length; i++){

                var dsp = vetor[i].value;
                if (vetor[i].value != "" && vetor[i].value > 0){

                    $.ajax({

                        url:"Processa_pauta_freq.php",
                        type:"POST",
                        data:{acao:2, disp:vetor[i].value},
                        success:function (result){
                            $('.full_table').show('slow');
                            $('.contente_freq').append(result);

                        }
                    })
                }
            }

        });


    });

    function do_autocomplete_disp (item, temp){

        var row = "";
        if (item.length > 0) {

            $.ajax({
                url: 'Processa_nota.php',
                type: 'POST',
                dataType: "json",

                data: ({disp: item, acao: 2}),
                success: function (result) {

                    if (temp == 1){

                    $('#resultado').show('slow');
                    $('#resultado').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                    $('#resultado').listview("refresh");

                    for (var i = 0; i < result.length; i++) {
                        row += '<li value="' + result[i].id + '" class="ui-bar-a" ' +
                        'onClick="get_item(this.value);" data-theme="a">' + result[i].descricao + '</li>';
                    }

                    $('#resultado').show();
                    $('#resultado').html(row);
                    $('#resultado').listview("refresh");
                    $('#resultado').trigger("updatelayout");

                    }else{
                        $('#rs_plano_av').show('slow');
                        $('#rs_plano_av').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                        $('#rs_plano_av').listview("refresh");

                        for (var i = 0; i < result.length; i++) {
                            row += '<li value="' + result[i].id + '" class="ui-bar-a" ' +
                            'onClick="get_item(this.value);" data-theme="a">' + result[i].descricao + '</li>';
                        }

                        $('#rs_plano_av').show();
                        $('#rs_plano_av').html(row);
                        $('#rs_plano_av').listview("refresh");
                        $('#rs_plano_av').trigger("updatelayout");
                    }
                }
            }); // fim primeiro ajax

        }else{
            $('#resultado').hide();
            $('#rs_plano_av').hide();
        }
    }

    /*
    * ouytas funcoes
    * */

    function gerir_frequencia_disp(item){

        if (item > 0) {

            /*$('#ad_exame').on('click', function () {

                $.ajax({
                    url: "Processa_pauta_freq.php",
                    type: "POST",
                    data: ({acao: 1, ctr: 2, disp: item}),
                    success: function (result) {

                        $('#users-contain').show('slow');
                        $('#avaliaco_freq').html(result);
                        $('.showText').remove();
                        $('#mytitle').html("Resultados da Pauta de Frequência").css({
                            'color': 'green',
                            'font-weight': 'bold'
                        });
                    }
                })

            });*/

            $('#ex_normal').on('click', function () {

                $.ajax({
                    url: "Processa_pauta_freq.php",
                    type: "POST",
                    data: ({acao: 1, ctr: 3, disp: item}),
                    success: function (result) {

                        $('#avaliaco_freq').fadeIn('slow');
                        $('#avaliaco_freq').html(result);
                        $('#mytitle').text("Resultados da Pauta de Exame Normal").css({
                            'color': 'green',
                            'font-weight': 'bold'
                        });
                        $('.showText').hide();
                    }
                })

            });

            $('#ex_recorrencia').on('click', function () {

                $.ajax({
                    url: "Processa_pauta_freq.php",
                    type: "POST",
                    data: ({acao: 1, ctr: 4, disp: item}),
                    success: function (result) {

                        $('#avafreq').fadeIn('slow');
                        $('#avaliaco_freq').html(result);
                        $('#mytitle').text("Resultados da Pauta do Exame de Recorrência").css({
                            'color': 'green',
                            'font-weight': 'bold'
                        });
                        $('.showText').hide();
                    }
                })
            });

        }else{
            $('#mytitle').html('Deve selecionar a disciplina').css('color','red');
        }

    }

    $(document).ready(function() {

        $('.sair').click(function() {

            $ajax({

                url:"User_login.php",
                type: "POST",
                data: {acao:3},
                success:function (result){
                    window.location = "../index.html";
                }
            })
        });


        /*$('#save_pauta_freq').click(function() {

            window.location= '../relatorios/Pauta_estudante.php?radio=on&disp=1';
        });*/

        $('#sair').click(function(){
            window.location="../index.html";

        })

        $('#users-contain').hide();
        $('.myresult').hide();
        $('.table_plano').hide();
        $('.full_table').hide();
        $('.div_plano').hide();

        $('#resultado').on('click','li',function(event){
            $('#disciplina').val($(this).html()).css({'color':'green'});
            $('#disciplinaX').val($(this).html()).css({'color':'green'});
            event.stopPropagation();
        });

        $('#rs_plano_av').on('click','li',function(event){
            $('#disciplina').val($(this).html()).css({'color':'green'});
            $('#disciplinaX').val($(this).html()).css({'color':'green'});
           event.stopPropagation();
        });

        $('#autocomplete-input').keyup(function(){
            $('.select_ano_list').show();
        })

        $('.select_ano_list').on('click','li',function(event){

            $('.select_ano_list').show();
            $('.select_ano_list li.current').removeClass('current').css({'background':'white', 'color':'black'});
            $(this).closest('li').addClass('current');
            $(this).closest('li').css({'background':'rgba(230,235,255,255)', 'color':'blue'});
            $('#autocomplete-input').val("");

            //$('#autocomplete-input').val($(this).html()).css({'color':'blue','fontWeight':'bold'});
            $('.active_ano').html('Ano Activo   '+$(this).html());
            $('txt_ano_activo').val($(this).html());
            event.stopPropagation();
            $('.select_ano_list').hide();

        });

        $('#menu_disp_est').on('click','li', function(){
           // $('.show_contente_av').html('Avaliações de '+$(this).text());
            $('#save_nome_disp').val('Avaliações de '+$(this).text());
        })

        $('#res_tipo_av').on('click','li', function(){

            $('#res_tipo_av li.current').removeClass('current').css({'background':'white', 'color':'black'});
            $(this).closest('li').addClass('current');
            $(this).closest('li').css({'background':'#ccc', 'color':'blue'});

            $('#save_nome_av').val($(this).text());
        })

    });

    /*
    * funcao buscar avaliacoes publicdas
    * */

    function buscar_av_publicada(item){

        $('.descricao').html("");
        $('.descricao').hide();
        var row ="";

        if (item !=null){

            $.ajax({

                url: 'Processa_nota.php',
                type:  "POST",
                data: {disp:item, acao:9},
                success : function(result){

                    row+='<li><h3 align="center" style="margin-bottom: -.8em">'+$('#save_nome_disp').val()+'</h3></li>';
                    row+=result;
                    $('#res_tipo_av').show('slow');
                    $('#res_tipo_av').html(row);
                }
            }); // fim primeiro ajax

        }else{$('#res_tipo_av').hide();}
    }

    function get_item(item) {
        /*
        funcoes mostrar avaliacao de disciplina
        * */

         if (item !=null){

            $.ajax({

                url:"Processa_nota.php",
                type:"POST",
                data:{disp:item,acao:1},
                success:function (result){

                    $('.myresult').show('slow');
                    $('.mycontente').html(result);
                    $('#resultado').hide();
                    $('#rs_plano_av').hide();
                }
            })

        $.ajax({

            url:"Processa_cadastro_pauta.php",
            type:"POST",
            data:{disp:item, acesso:7, ctr:1},

            success: function (res){

                $('.div_plano').show('slow');
                $('#table_plano_m').html(res);
                $('#rs_plano_av').hide();

            }
        });

        $.ajax({

            url:"Processa_cadastro_pauta.php",
            type:"POST",
            data:{disp:item, acesso:9},

            success: function (res){


                $('.div_plano').show('slow');
                $('#table_plano1').html(res);
                $('#rs_plano_av').hide();

            }
        });

        }else{
            $('#resultado').hide();
            $('.myresult').hide();
            $('#rs_plano_av').hide();
        }


        /*Metodos para salvar resultado de pauta estudante*/

        $('#save_pauta_normal').click(function(){
            window.location= '../relatorios/Pauta_estudante.php?radio=off&disp='+item;

        });
    }

    /*------------end document ------------------------*/

    function getNota_item(item) {

        var texto;
        $('.descricao').show();
        $.ajax({

            url:"Processa_edit_avaliacao.php",
            data:({idNota:item, acao:1}),
            type:"POST",

            success: function(result){

                if (result  > 0) {

                    if (result < 10){

                        $('.descricao').html('Classificação do '+$('#save_nome_av').val()+'<br>[ '+result+' valores ]')
                            .css({'color':'#ced0ce','font-size':'16px' ,'fontWeight':'bold'});
                    }

                    if(result >= 10 && result < 15){

                        $('.descricao').html('Classificação do '+$('#save_nome_av').val()+"<br>[ "+result+' valores ]')
                            .css({'color':'green','font-size':'16px','fontWeight':'bold'});

                    }

                    if (result >=15){
                        $('.descricao').html('Classificação do '+$('#save_nome_av').val()+'<br>[ '+result+' valores ]')
                            .css({'color':'blue','font-size':'16px','fontWeight':'bold'});
                    }
                }

                else{
                    $('.descricao').html(result);
                }

            },
            error: function(){
                alert ('Nao foi possivel registar!');
            }
        })
    }

</script>


<?php

 function obter_ano_ingresso($username){
    $db = new mySQLConnection();
    $query = mysqli_query($db->openConection(), "SELECT YEAR(utilizador.data_ingresso) as data_r FROM utilizador WHERE
utilizador.username = '$username'");
     if ($row= mysqli_fetch_assoc($query)){
         return $row['data_r'];
     }
}
?>
