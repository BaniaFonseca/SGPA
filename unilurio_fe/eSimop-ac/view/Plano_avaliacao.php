<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 20-Sep-15
 * Time: 6:08 AM
 */

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
    ;

    $query = new QuerySql();
    $ctr_est = new SqlQueryEstudante();
    $idDoc = $query->getDoc_id($_SESSION['username']);
    $pautaControlle = new PublicarPauta();
    $myvar = 0;



?>

<!doctype html>

<html >

<head>

    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">
    <meta charset=utf-8 />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Plano de Avaliacao</title>
    <link href="../css/table_style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../css/edit_pauta_style.css" type="text/css">
    <link rel="stylesheet" href="../css/table_style.css" type="text/css">
    <link rel="stylesheet" href="../css/estudante_style.css" type="text/css">
    <link rel="stylesheet" href="../css/cabecalho.css" type="text/css">

    <link href="../../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_assets/css/jquery.mobile.structure-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_assets/css/jquery.mobile.theme-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link   type="text/css" href="../libs/jqueryAlerts/css/jquery.alerts.css" rel="stylesheet"/>

    <script src="../../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../../_assets/js/jquery.mobile-1.4.3.min.js"></script>
    <script type="text/javascript" src="../js/js_function.js"></script>
    <script type="text/javascript" src="../libs/validarCampos.js"></script>
    <script src="../js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>
    <script type="text/javascript" src="../libs/jqueryAlerts/scripts/jquery.alerts.js"> </script>

    <style>
        body{
            font-size:13px;
            text-align:center;
        }

        #rs_docente li:hover{background: #22aadd; color: #ffffff}


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

        .lista_disp{
            width:400px; height:350px; margin-right: 1em; float: left;
            border: 1px solid #ccc;
            border-radius: 3px;

        }
        .bt_style{padding: 8px 30px;}

    </style>


</head>
<body>

<div data-role="page" id="page5">
        <div data-role="header" align="center" class="config_header" data-position="fixed" data-theme="b">
             <h3>Mostrar ou Registar plano de Avaliação</h3>

            <div style="float: left;  margin-top: -2.5em; margin-left: 1em">

                <button style="float: left" id="back" data-icon="home" data-iconpos="notext" value="Icon only" type="button"/>
            </div>

        <!--a href="Coordenador_curso.php" data-icon="home" data-rel="back" data-iconpos="left">Home</a-->

         <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
              <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp;<a href="#"><img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>
        </div>

<div data-role="content" align="center">

    <div class="ui-corner-all custom-corners" style="margin-top: 1.5em ;" id="ctr_login_doc">
        <div class="ui-bar ui-bar-a headers" style=" background: none; width: 90%;   border:none;border-bottom:3px solid #ff9933 ">

            <div style="float: left;"><h3 style="color: #008000;font-size: 16px;
			margin-bottom: -3em; margin-left: -.85em">&nbsp;</h3></div>

            <div style="float:right; margin-buttom:-5em;margin-right: -.9em; width: 320px ">
                <input type="search"   class="ui-bar-a" name="search_doc" onkeyup="do_autocomplete(this.value)"
                       placeholder="Buscar docente ... nome" id="search_doc" value=""/>
            </div>


        </div>



        <div class="ui-body ui-body-c" style=" width: 90%">

            <div style="float:right; width: 310px">

                <ul id="rs_docente" data-theme="a" data-role="listview" data-inset="true" style=" margin-buttom:-5em;margin-right: -.85em "></ul>
                <!--- Mostra o nomes de docentes pesquisa actual -->

                <div class="sr_plano" align="center"></div> <!-- Mostra o plano de avaliacao docente pesquisado-->
            </div>
            <br>
                <!------------------------  Mostra disciplina do docente corrente ------------------------->
            <div class="lista_disp" style=";margin-left: -1em">

                <div class="mostrar_doc"  style="margin-top: -.5em; height: 50px;color: darkblue; font-weight: bold"><br>
                    Disciplinas Associadas ao Docente <?php echo $_SESSION['nomeC']?>


                </div><hr>
                <ul data-role="listview" data-inset="false" style="width:350px; margin-top: 7em" class="docente_disp">

                    <li data-theme="b" style="" class="disp_doc">Seleccionar Disciplina</li>
                    <?php

                    $db = new mySQLConnection();
                    $query = new QuerySql();

                    $result = mysqli_query($db->openConection(),$query->listaDisciplina($idDoc, 0));?>
                    <?php

                    while ($row= mysqli_fetch_assoc($result)){?>

                        <li data-theme="d" value="<?php echo $row['idDisciplina']?>"  onclick="buscar_disp(this.value)">
                            <a href=""><?php echo $row['descricao']?></a> </li>

                    <?php }
                    $_SESSION['acao'] = 2;

                    ?>

                </ul> <!---------------------------- Mostra disciplinas docente corrente-->

                <div class="remover_div">

                    <ul  id="resultados" style="width:350px;margin-top: 5em" data-role="listview" data-inset="false"></ul>

                </div>


            </div>


            <h3 class="sucesso" style="margin-left: 30em;"></h3>

                <!---  Saessao mostra plano de avliacao -->


            <div class="visualizar_pl" style=" float: right; margin-right: -1em; width: 700px">

                <table data-role="table" id="table-custom-2" data-mode="color" class="ui-body-c ui-shadow table-stripe ui-responsive">
                        
                    <thead>

                          <tr class="ui-bar-b"  id="div-bar" style="background: #22aadd;border: none; color: #ffffff; font-size: 12px">
                                
                                <th >Tipo de Avaliação</th>
                                <th >Peso</th>
                        <th>Qtd. Maxima</th>
                                
                              </tr>
                    </thead>

                        <tbody id="table_pl" style="font-size: 11px;"> </tbody>
                      </table>


                <table data-role="table" id="table-custom-2"class="ui-body-c ui-shadow table-stripe ui-responsive">
                        
                    <thead>
                    <div style="color:green">Datas previstas para realização de Avaliações</div>
                          <tr class="ui-bar-b"  id="div-bar" style="background: #22aadd;border: none; color: #ffffff; font-size: 12px">
                                
                                <th >Testes</th>
                               <th >Mini-Testes</th>
                               <th >Outras Avaliações</th>
                                
                              </tr>
                    </thead>

                        <tbody id="table_pl1" style="font-size: 11px;"> </tbody>
                      </table>

            </div> <!---- Table show plano-->


            <h3 style="margin-top:2em;">&nbsp;</h3>
            <div class="disp_doc_pesq"> </div>

            </div>

    </div> <!-- caixa de texto -->

</div><!-- end contente-->


<div data-role="footer"  align="right" data-position="fixed">

        <a href="#page3" data-mini="true" data-rel="popup" id="assoc_peso" data-transition="pop"
           class="ui-btn ui-corner-all ui-btn-inline ui-mini ui-btn" data-position-to="input">Peso e Avaliação</a>

        <a href="#page8" id="notificar_doc"  data-theme="a" data-rel="popup" data-transition="pop"
               class="ui-btn ui-corner-all ui-btn-inline ui-mini ui-btn" data-position-to="window">Notificar Docente</a>

        <a href="#registar_plano" id="btn_reg_plano" data-transition="pop"
            data-rel="popup"  data-theme="a" data-mini="true" data-position-to="input"
           class="ui-btn ui-corner-all ui-btn-inline ui-mini ui-btn">Registar ou Alterar Plano</a>


</div>

<!-----   popup registar disciplina --->

<div data-role="popup" id="registar_plano" data-dismissible="false"  style=" width: 600px; margin-right: 4em; margin-top: 4em">

<div data-role="header"><h3 class="show" style="color: #00516e">Realizar Plano de Avaliação</h3></div>

<div data-role="content">
    <h3 class="show_sucess" align="left"></h3>

    <form class="ui-filterable">
        <input id="autocomplete-input" data-type="search" placeholder="Buscar  disciplina ...">
    </form>

    <ul data-role="listview" data-filter="true" data-filter-reveal="true" data-input="#autocomplete-input" data-inset="true" class="docente_disp_plano">

        <?php

        $db = new mySQLConnection();
        $query = new QuerySql();

        $result = mysqli_query($db->openConection(),$query->listaDisciplina($idDoc, 0));?>
        <?php

        while ($row= mysqli_fetch_assoc($result)){?>

            <li data-theme="b" value="<?php echo $row['idDisciplina']?>"  onclick="buscar_disp(this.value)"><a href="">
                <?php echo $row['descricao']?></a></li>

        <?php }
        $_SESSION['acao'] = 2;

        ?>

    </ul>

    <form class="select_type_av">
        <h5 style="color:blue; margin-top: -.5em; margin-bottom: -.3em" align="right">Selecionar o Tipo de Avaliação</h5>
        <fieldset data-role="controlgroup" data-iconpos="right" id="my_inputs">

            <input name="checkbox-h-6a" id="checkbox-h-6a" type="checkbox" value="1">
            <label for="checkbox-h-6a">Teste</label>
            <input name="checkbox-h-6b" id="checkbox-h-6b" type="checkbox" value="2">
            <label for="checkbox-h-6b">Mini-Teste</label>
            <input name="checkbox-h-6c" id="checkbox-h-6c" type="checkbox" value="3">
            <label for="checkbox-h-6c">Trabalho</label>
        </fieldset>

    </form>

    <!--Inicio espaco de gestao de resgisto --->

    <div class="ui-field-contain" style="">
        <h5 style="color:blue; margin-top: -.5em; margin-bottom: -.3em" align="right">Inserir Datas e Quantidade de Avaliações</h5>

        <table border="0" width="620px" class="ui-bar-d" style="font-size: 11.5px; font-family: serif">

            <tr>
                <td> <input type="text" name="qtMaxT" data-inline="true" data-mini="true" value="" id="qtMaxT" placeholder="Qtd. Max. Teste"/></td>
                <td> <input type="date"    name="dataT" value="" id="dataT" data-inline="true" data-mini="true" placeholder="dd/mm/aaaa"/></td>

                <td>&nbsp;<button id="add_dataT" data-inline="true" class="bt_style"  data-mini="true"  value="2">Adicionar Data</button></td>

            </tr>

            <tr><td> <input type="text"  name="qtMaxMT" data-inline="true" data-mini="true" value="" id="qtMaxMT" placeholder="Qtd. Max Mini-Teste"/></td>
                <td>

                    <input type="date"  name="dataMT" data-inline="true" data-mini="true" value="" id="dataMT" placeholder="dd/mm/aaaa"/></td>

                <td>&nbsp;<button id="add_dataMT" data-inline="true" class="bt_style"  data-mini="true" value="2">Adicionar Data</button></td>

            </tr>
            <tr><td> <input type="text"  name="qtMaxOTV" data-inline="true" data-mini="true" value="" id="qtMaxOTV" placeholder="Qtd. Max Trabalho"/></td>
                <td> <input type="date"  name="dataOTV" data-inline="true" data-mini="true" value="" id="dataOTV" placeholder="dd/mm/aaaa"/></td>

                <td>&nbsp;<button  id="add_dataOTV" data-inline="true" class="bt_style"  data-mini="true" value="2">Adicionar Data</button></td>

            </tr>

            <tr>
                <td><h3 class="soma" align="center" style="color:red"></h3></td>
                <td><h3 class="regData"></h3></td>
                <td></td>
            </tr>

        </table>

        <div align="right"><h3 class="sucess"></h3></div>

    </div>

</div>

<div data-role="footer" align="right">
    <button data-mini="true" data-theme="b" style="padding: 8px 30px; background: #2567ab; border: none" data-inline="true" id="sv_plano">Salvar</button>
</div>

    <a href="#" id="close_f" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-left" data-transition="slide" data-rel="back">Close</a>
</div>

<!----------- fim popup   ------------>

<div data-role="popup" id="page8" data-dismissible="false" style="width: 450px;">

    <div data-role="header" align="left">
        <h3 style="color:darkgreen"> Envio de  Mensagem - Gmail</h3>
    </div>

    <div data-role="content" align="center">

        <div class="dados_notificacao"></div>
        <div class="enviare" align="center"></div> <!--Mostra o espaco de envio de email--->
        <input type="text" name="textemail" value="" id="txtemail" placeholder="email (remetente)"/>
        <input type="password" name="txtsenha" value="" id="txtsenha" placeholder="senha (remetente)"/>
        <textarea id="txtarea" style="height: 300px" placeholder="Escreva seu comentario ..."></textarea>
        <div id="res_sucess"></div>

    </div><br>

    <div data-role="footer"  align="right">
        <button data-theme="b" data-mini="true" data-inline="true" value="1" id="send_email">Enviar a Mensagem</button>
    </div>

    <a href="#" id="close_f" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-left" data-transition="slide" data-rel="back">Close</a>
</div>

<div data-role="popup" id="page3"  data-dismissible="false"  style=" width: 600px; margin-right: 4em; margin-top: 4em">

    <div data-role="header"><h3>Associar Pesos  Avaliações a Disciplina </h3></div>
    <div data-role="content">

        <p style="text-align: justify; font-size: 15px;color:green"> Os pesos atribuidos aos Testes, Mini-Testes, ou Outras Avaliações a soma dos mesmos não deve ser superior a 100;</p>
        <ul data-role="listview" data-inset="true" class="resultados">
            <li data-theme="b"><div align="center" style="font-size: 13px">Disciplinas com plano antecipado - Seleccionar  </div></li>
            <?php

            $db = new mySQLConnection();
            $query = new QuerySql();

            $result = mysqli_query($db->openConection(),$query->disciplinas_plano($idDoc));?>
            <?php

            while ($row= mysqli_fetch_assoc($result)){?>

                <li data-theme="a" value="<?php echo $row['idDisciplina']?>"  onclick="get_displina(this.value)">
                    <a href=""><?php echo $row['descricao']?></a> </li>

            <?php }?>

        </ul> <!---------------------------- Mostra disciplinas docente corrente-->

        <!--Inicio espaco de gestao de resgisto--->
        <div  id="with_botton" align="left" style="width: 300px; margin-top: 2em">

            <form>
                    <input name="campo_teste" id="campo_teste" data-mini="true" data-inline="true" value="" type="text" placeholder=" Peso do Teste .." pattern="[0-9]+$">
                    <input data-clear-btn="true" name="campo_min" data-mini="true" data-inline="true" id="campo_mini" value="" type="text"  placeholder="Peso Mini-teste" pattern="[0-9]+$">
                    <input data-clear-btn="true"name="campo_outro" id="campo_outro" value="" data-mini="true" data-inline="true" type="text" placeholder="Trabalhos " pattern="[0-9]+$">

            </form>

            <h3 class="validarCampo" style="color:green;"><h3 class="peso" style="color:red;"></h3>

        </div>
        <div align="right"><h3 class="sucess"></h3></div>
    </div>

    <div data-role="footer" align="right">

        <button data-mini="true" data-theme="b" class="bt_style" data-inline="true" id="save_peso">Salvar</button>

    </div>

    <a href="#" id="close_f" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-left" data-transition="slide" data-rel="back">Close</a>
</div>

</div>

</body></html>

<script type="text/javascript" charset="utf-8">

    var vetor=[], vetor1=[], vetor2=[], vetor3=[], disciplinas=[], testes=[];
    var qtd, dp , tipo;
    var ctr =0, vez =0;
    var global = [];
    var valor = 0,  soma=0;

    var i=0, k=0, s=0, t=0;
    var p1=0, p2=0, p3=0;

    $(document).ready(function(e) {


        $('.mybotton').hide();
        $('#pesq_doc').hide();
        $('.all_plano').hide();
        $('#myform').hide();
        $('.visualizar_plano').hide();
        $('.hide_btn').hide();
        $('.sucess').hide();
        $('.with_botton').hide();
        $('.visualizar_pl').hide();
        $('.myvar').hide();
        $('#rs_docente').hide();
        $('#adpter_disp').hide();
        $('.disp_doc_pesq').hide();
        $('#vz_all_plano').hide();
        $('.hide_div').hide();
        $('#resultados').hide();
        $('#notificar_doc').hide();

        /*
        *
        * validar data
        * */

        $('#dataMT').change(function () {

           /*if ( validateDate($(this).val(),'mm/dd/yyyy ') == true){
               alert('verdade');
           }else{alert('data false');}*/

        });
        /*
         * Pega o texto de uma ul li do docente pesquisado
         * */

            $('.docente_disp_plano li').click(function () {

                $('#autocomplete-input').val($(this).text()).css({'color': 'green', 'fontWeight': 'bold'});
                $('.docente_disp_plano').hide();
                $('.show').html("Realizar Plano de Avaliação' ["+$(this).text()+"]");

            });

            $('#close_f').click(function () {
                $('#btn_reg_plano').show();
            });

        $('#back').click(function(){
            Javascript:history.go(-1);
        })


            $('#reg_plano').click(function () {
                window.location = "Plano_avaliacao.php";
            })

            $('#relatorios').click(function () {
                window.location = "Editar_pauta.php?acao=10";
            });


            $('.resultados').on('click', 'li', function () {

                $('.resultados li.current ').removeClass('current').css({'background': 'white', 'color': 'black'});
                $(this).closest('li').addClass('current');
                $(this).closest('li ').css({'background': 'rgba(220,220,250,255)', 'color': 'blue'});


            })

            $('#reg_pauta').click(function () {
                window.location = 'Docente_pauta.php';
            });

            $('#btn_reg_plano').click(function () {
                $(this).hide();
                $('#assoc_doc').show();
            });


            /*
             * More function
             * */

            $('#add_dataT').click(function () {

                var disp = $('.docente_disp li').text();

                if (t < $('#qtMaxT').val()) {
                    t++;
                    vetor1.push($('#dataT').val());

                    $('.show_sucess').html('Data registada para Teste - ' + t)
                        .css({'color': 'green'});
                    console.log(vetor1);

                } else {
                    if (t == $('#qtMaxT').val()) {
                        $('.show_sucess').html('Terminado para Testes')
                            .css({'color': 'blue'});
                    }

                }
            });

            $('#add_dataMT').click(function () {

                if (k < $('#qtMaxMT').val()) {
                    k++;
                    vetor2.push($('#dataMT').val());

                    $('.show_sucess').html('Data registada para Mini-Teste - ' + k)
                        .css({'color': 'green'});
                    console.log(vetor2);

                } else {

                    if (k == $('#qtMaxMT').val()) {
                        $('.show_sucess').html('Terminado para Mini-Testes')
                            .css({'color': 'blue'});
                    }
                }
            });


            $('#add_dataOTV').click(function () {

                if (s < $('#qtMaxOTV').val()) {

                    s++;
                    vetor3.push($('#dataOTV').val());

                    $('.show_sucess').html('Data para o trabalho - ' + s)
                        .css({'color': 'green'});
                    console.log(vetor3);

                } else {

                    if (s == $('#qtMaxOTV').val()) {
                        $('.show_sucess').html('Terminado para Trabalhos')
                            .css({'color': 'blue'});
                    }
                }
            });


            $('#qtMaxT').keyup(function () {
                $('.soma').show();
                soma += $(this).val() << 0;
                $('.soma').html('Total de Avaliações: ' + soma).css({'color': '#996633', 'margin-bottom': '.5em'});
            });

            $('#qtMaxMT').keyup(function () {
                $('.soma').show();
                soma += $(this).val() << 0;
                $('.soma').html('Total de Avaliações: ' + soma).css({'color': '#996633', 'margin-bottom': '.5em'});
            });

            $('#qtMaxOTV').keyup(function () {
                $('.soma').show();
                soma += $(this).val() << 0;
                $('.soma').html('Total de Avaliações: ' + soma).css({'color': '#996633', 'margin-bottom': '.5em'});
            });


            $('#mostra_plano').click(function () {
                $('#resultados').remove();
                $('.remover_div').remove();
                $('.inputs').hide();


                $.ajax({

                    url: "Processa_cadastro_pauta.php",
                    type: "POST",
                    data: {acesso: 4},

                    success: function (result) {

                        $('#table_plano').html(result);
                        $('.visualizar_plano').fadeIn('slow');

                        $(this).fadeOut('slow');
                        $('.botons').hide();
                        $('.sv_plano').hide();
                        $('#table_pl').hide();

                        $('.rs_docente').hide();
                        $('.sr_plano').hide();
                        $('.visualizar_pl').hide();
                        $('.docente_disp').hide();

                    }

                });

            });


            /*
             * docente disciplina
             * */

            $('.docente_disp').on('click', 'li', function () {

                $('.docente_disp li.current').removeClass('current').css({'background': 'white', 'color': 'black'});
                $(this).closest('li').addClass('current');
                $(this).closest('li').css({'background': 'rgba(235,240,250,255)', 'color': 'blue'});

            });

            $('#resultados').on('click', 'li', function () {

                $('#resultados li.current').removeClass('current').css({'background': 'white', 'color': 'black'});
                $(this).closest('li').addClass('current');
                $(this).closest('li').css({'background': 'rgba(235,240,250,255)', 'color': 'blue'});

            });

            /*
             * validacao em campos de texto;
             * */

            $('#campo_teste').change(function () {

                if ($(this).val() > 0) {
                    print_r(1);
                }

            });

            $('#campo_mini').change(function () {

                if ($(this).val() > 0) {
                    print_r(2);
                }

            });

            $('#campo_outro').change(function () {

                if ($(this).val() > 0) {
                    print_r(3);
                }

            });

            /*
             *
             * Coloca os valores no vetor de dados
             * */

            $('.proximo').click(function () {

                var radios = $('input:checked');

                for (var i = 0; i < radios.length; i++) {
                    if (radios[i].value != 0 && radios[i].checked == true) {

                        $.ajax({

                            url: "Processa_edit_avaliacao.php",
                            type: "POST",
                            data: {acao: 3, pauta: radios[i].value},
                            success: function (data) {
                                $('.myp').html(data).css('color', 'blue').fadeOut('slow');
                                location.reload(1).fadeIn(12000);
                            }
                        }) // Termina a primeira requisicao ajax;

                    }

                    if (radios[i].value == 0) {

                        vetor.push(radios[i].value);

                    }
                }

            })

            /*
             * Metodo click controla o intervalo atribuido no registo dos pesos;
             * */
            $('.continuar').click(function () {

                if ($('#campo_teste').val() >= 60 && $('#campo_teste').val() <= 90
                    && $('#campo_mini').val() >= 10) {

                    $('#label').text("Atribução de quantidades para avaliação - disciplina");
                    $('.with_botton').show('slow');
                    $('#inputs').hide('slow');
                    $('.hide_div').hide();

                } else {
                    alert('Caro Docente:\nReveja os pesos atribuidos as Avaliações', 'Validacao de Pesos');
                }
            })

    })// fim documento ready

/*
*
* Metodo autocomplete do docente
* */
    function do_autocomplete(item) {

        var min_length = 3;
        var keyword = item;
        $('#rs_docente').html("");

        if (keyword.length >= min_length) {

            var row = "";
            $('#rs_docente').show();


                $('#rs_docente').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                $('#rs_docente').listview("refresh");

                $.ajax({

                    url:"Processa_registo_academico.php",
                    type:"POST",
                    dataType:"json",

                    data: {texto:keyword,acao:6},
                    success : function(result){

                        for (var i=0;  i < result.length; i++){
                            row += '<li value="'+result[i].id+'" class="ui-bar-a" onClick="put_doce_item(this.value);" data-theme="a">'+result[i].fullname+'</li>';

                        }
                        $('#rs_docente').show();
                        $('#rs_docente').html(row);
                        $('#rs_docente').listview( "refresh" );
                        $('#rs_docente').trigger( "updatelayout");

                        $('.rs_docente').hide('slow');
                        $('.sr_plano').hide();
                        $('.visualizar_pl').hide();
                        $('.docente_disp').hide();
                        $('#notificar_doc').show();

                    }
                }); // fim primeiro ajax


            }else{$('#rs_docente').hide();}

    };


    // mostra disciplina do docente pesquisado
    function put_doce_item(item) {
        $('#rs_docente').hide();
        $('#assoc_peso').hide();
        $('#btn_reg_plano').hide();
		$('#notificar_doc').show();

        var campo = $('#rs_docente li');
        for (var i = 0; i< campo.length; i++ ){
            var nodo = campo[i];
            $('#search_doc').val(nodo.innerText).css('color','blue');
            $('.mostrar_doc').html('Disciplina associadas ao Docente '+nodo.innerText);

        }

        if (item !=null){

            var row = "";

            $('#resultados').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
            $('#resultados').listview("refresh");

            $.ajax({

                url: 'Processa_docente.php',
                type:  "POST",
                dataType:"json",

                data: {nome:item, acao:7,ctr:0},
                success : function(result){

                    row += '<li data-theme="b" class="ui-bar-b">Selecionar Disciplina</li>';

                    for (var i=0;  i < result.length; i++){

                        row += '<li value="'+result[i].id+'" onClick="buscar_disp(this.value);" data-theme="a"><a href="#">'+result[i].descricao+'</a></li>';

                    }
                    $('#resultados').show('slow');
                    $('#resultados').html(row);
                    $('#resultados').listview( "refresh" );
                    $('#resultados').trigger( "updatelayout");

                }
            }); // fim primeiro ajax

        }else{$('#resultados').hide();}

    }



    /*
    * Controla o registo do plano de avaliacao
    * */


    function adicionar (qt){

        vetor = new Array(qt);
        var soma=0;

        if ($('#campo_teste').val() >= 60 && $('#campo_teste').val() <= 90){

            vetor[0]= $('#campo_teste').val();
            vetor[1]= $('#campo_mini').val();
            vetor[2]= $('#campo_outro').val();

            for(var i=0; i< vetor.length; i++){
                soma += vetor[i] << 0;
            }
            return (soma);

        }else{
            //jAlert ('Seleccione Opções :\n\n[1] - Tipo de Avaliaçao;\n[2] - Curso e \n[3] - Disciplina.','Atençao');
            jAlert('o valor atribuido ao campo para Teste \ndeve estar entre [ 60 - 80 ]','Validacao');
            return;
        }
    }

    function print_r(qt){

        valor= adicionar(qt);

        if (valor >= 10){

            $('.peso').html(valor+' % registo em processo ...').css({'color':'green'});

            if (valor == 100){

                $('.validarCampo').html(valor+ "%  registado correctamente").css({'color':'black', 'font-size':'15px'});
                $('.peso').hide();
                $('.hide_div').show();
                return;
            }else{
                if (valor > 100){
                    jAlert ('Caro Docente, excedeu o limite da soma dos pesos \n\n'+
                    '* Deve registar no maximo  ate 100%\n'+
                    '* Reveja os dois ultimos campos ou reduza o primeiro\n','Validacao de Pesos');

                    return;
                }
            }

        }

    }


    /*
    * Funcoes salvar plano e de registo de datas
    *
    * */

    function registar_plano (dp,av,qtd,peso) {

            $.ajax({
                url:"Processa_cadastro_pauta.php",
                type:"POST",
                data:({acesso:3,avaliacao:av,peso:peso,disp:dp, qt:qtd}),
                success:function(data){}
            });
    }

    function regitar_datas_av(disp, vetor, av){

        $('.show_sucess').show();

        for (var i=0; i < vetor.length; i++) {

            $.ajax({
                url:"Processa_cadastro_pauta.php",
                type:"POST",

                data:({acesso:10,tipo:av,disp:disp, data:vetor[i]}),

                success:function(data){

                    $('.show_sucess').html(data)
                        .css({'color':'green','font-family':'serif','font-size':'20px'}).fadeOut(9000)
                    ;
                }
            });

        };
    }

    /* -------------   Busca disciplinas docente e mostra o plano onclick (function)   -----------  */

    function buscar_disp(item) {


        $.ajax({

            url:"Processa_cadastro_pauta.php",
            type:"POST",
            data:{disp:item, acesso:7, ctr:1},

            success: function (res){

                $.ajax({

                    url:"Processa_cadastro_pauta.php",
                    type:"POST",
                    data:{disp:item, acesso:9},
                    success:function (result){

                        $('.visualizar_pl').fadeIn('slow');
                        $('#table_pl').html(res);
                        $('.enviare').hide();
                        $('.notificar').show();
                        $('#table_pl1').html(result);

                    }
                });

            }
        });

        // funcao salvar plano que so deve ser executado caso for feitoo clique na linha da disciplina

        $('#sv_plano').click(function () {

            var tipo = $('input:checkbox');
            var qtdT = $('#qtMaxT').val();
            var qtdMT = $('#qtMaxMT').val();
            var qtdOTV = $('#qtMaxOTV').val();

            if (qtdMT > 0 && qtdOTV > 0 && qtdT >0 && item > 0) {

                for (var i = 0; i < tipo.length; i++) {


                    if (tipo[i].value != "" && tipo[i].checked == true) {

                        if (tipo[i].value == 1) {

                        registar_plano(item, 1, qtdT, p1);
                         regitar_datas_av(item, vetor1, 1);

                         }
                         if (tipo[i].value == 2) {

                        registar_plano(item, 2, qtdMT, p2);
                         regitar_datas_av(item, vetor2, 2);

                         }
                         if (tipo[i].value == 3) {

                         registar_plano(item, 3, qtdOTV, p3);
                         regitar_datas_av(item, vetor3, 3);

                         }
                    }
                }

            } else {
                jAlert("Deve registar as quantidades e selecionar a disciplina\n", 'Atencao', function (r) {
                    if (r)return;
                })
            }

        });


        // funcao notificar docente

        $('#notificar_doc').click(function(){
            $('.dados_notificacao').show();
            $.ajax({

                url:"Processa_cadastro_pauta.php",
                type:"POST",
                data:{disp:item, acesso:11},
                success:function (result){

                    $('.dados_notificacao').html(result);

                }

            })
        })

        // acao do botao enviar email

        $('#send_email').click(function(){

            send_email(item); // metodo enviar email implementado no arquivo javascript
        })
    }

    /*
     * Metodo salvar peso e avaliacao
     * */

    function get_displina(item){

        $('#save_peso').click(function () {
        $('.sucess').show();

        var pt = $('#campo_teste').val();
        var pmt = $('#campo_mini').val();
        var potv = $('#campo_outro').val();

        $.ajax({
            url: "Processa_cadastro_pauta.php",
            type: 'POST',
            data: {disp: item, p1: pt, p2: pmt, p3: potv, acesso: 8},
            success: function (rs) {
                $('.sucess').html("");
                $('.sucess').html("Registado com sucesso").css({
                    'color': 'blue',
                    'font-size': '15px'
                }).fadeOut(6000);
                $('.validarCampo').html("");
                $('.peso').html("");
            }

        }); });
    }
</script>