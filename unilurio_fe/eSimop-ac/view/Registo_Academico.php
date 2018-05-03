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

</head>


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
</style>

<body>

<!-- inicio da pagina principal-->


<div data-role="page" data-transition="slide">

    <div data-role="header" data-theme="b" class="config_header" style="border:none">
        <h3 style="padding: 10px">&nbsp;</h3>

        <div style="float: left; margin-left: 1em; margin-top: -2em; margin-bottom: 1em"><a href="#search">
                <img src="../../_assets/img/icons-png/bars-white.png" width="20px" class=""></a></div>

        <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
            <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp;<a href="#"><img src="../../_assets/img/icons-png/user-white.png" width="15px"></a></div>

    </div>



    <div data-role="content" align="center" style="margin-top: 5em">

        <div class="ui-corner-all custom-corners nova_pauta" style=" width: 90%; margin-top:4em">

            <div class="ui-bar ui-bar-b" style="background:#aaa; border:none;  border-bottom: 5px solid #ff9933;">
                <h3 style="float: left; font-size: 15px; margin-bottom: -1em">Associar Estudante a Pauta de Recorrencia</h3>

                <div style="float:right; margin-top: -.5em; margin-bottom: -.5em">

                    <a href="#mais_action" data-position-to="window"  data-rel="popup"
                       class="ui-btn ui-btn-a ui-corner-all ui-shadow ui-btn-inline
                                        ui-btn-icon-right ui-body-b ui-btn-a ui-icon-gear get_estudante"
                       data-transition="turn" >Disciplinas e Cursos</a>

                    <!--button data-mini="true" id="more_action" data-inline="true" data-icon="search" data-iconpos="right" data-theme="b">Mais</button-->

                </div>

            </div>

            <div class="ui-body ui-body-a"><br>

                <div class="ui-contain">

                    <input type="search" data-mini="true" data-inline="true" class="ui-bar ui-bar-a"
                           name="pesquisar_est" placeholder=" Buscar estudante ... nome" value="" id="pesquisar_est" onkeyup="do_autocomplete(this.value, 2)"/>
                    <ul id="resultados_e" data-role="listview" data-inset="true"></ul>

                </div>

                <ul data-role="listview" class="get_curso" data-inset="true">

                    <li data-theme="b" style="background:#9C9C9C; color:white; border: none">
                        <div align="right" style="font-size: 15px; font-weight: bold">Seleccionar o Curso ...</div></li>
                    <?php

                    $db = new mySQLConnection();
                    $query = "SELECT idCurso, descricao from curso;";
                    $result = mysqli_query($db->openConection(), $query);
                    while ($row = mysqli_fetch_assoc($result)) {?>

                        <li value="<?php echo $row['idCurso']?>" onclick="mostrarCurso(this.value)" data-theme="d" data-icon="forward"><a>
                                <?php echo $row['descricao']?> </a></li>
                    <?php }
                    ?>
                </ul><br>

                <div id="mydiv"></div> <!---Mostra resultado estudante pauta recorrencia---->
                <br>
            </div>
        </div>
    </div>

    <div data-role="footer" data-position="fixed"  data-theme="a" align="right">

        <button data-mini="true" id="sair" onclick="logout()" data-inline="true" data-icon="delete" data-iconpos="right">Sair</button>

    </div>


    <!---------------------------- FIM POPUPS  E COMEC SESSAO DE PANEL------------------------------->


    <div data-role="popup" id="gerir_cursos"  data-dismissible="false" style="width:400px; height: 500px">


        <div data-role="header" data-theme="a" style="border:none">

            <h3 style="color:blue" class="resumo"></h3><br>

        </div>

        <div data-role="content" align="center"><br>

        </div>

        <div data-role="footer" data-position="fixed" align="right">

            <a href="#" style="font-size:12px; background:#696969; border:none"
               class="ui-btn ui-corner-all ui-shadow ui-icon-foward ui-btn-inline ui-btn-b"
               data-theme="a" data-transition="slide" id="btnBack">  Voltar  </a>

            <a href="#" style="font-size:12px; background:#007CCC; border:none"
               class="ui-btn ui-corner-all ui-shadow ui-icon-foward ui-btn-inline ui-btn-b"
               data-theme="a" data-transition="slide" id="confirmar_rec">Confirmar</a>


        </div>

        <a href="#" id="close_f" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-left" data-transition="flip">Close</a>

    </div>


    <!--- Popup no disciplina e curso -->


    <div data-role="popup" id="mais_action" data-dismissible="false" style="width: 450px">

        <div><h3 style="margin-left: 2em" align="left" >

                <button data-theme="b" data-inline="true" data-mini="true" style="font-size:12px; margin-right:1em;
                 background:#696969; border:none" value="1" id="novo_curso">Nova Curso</button>

                <button data-theme="b" data-inline="true" data-mini="true" style="font-size:12px; margin-left:-1.2em;
                 background:#696969 ;border:none" value="2" id="nova_disciplina">Nova Disciplina</button></div>

        <hr style="border: 1.5px solid red; margin-top: -1em">

        <br>
        <div style="padding: 10px 30px" align="right" class="new_curso">
            <h3 class="mensagem"></h3>
            <input type="text" name="" value="" id="txt_desc" placeholder="Descrição do Curso"/>
            <input type="text" name="" value="" id="txt_cod" placeholder="Codigo do Curso"/>
            <input type="search" name="" value="" id="txt_dir" placeholder="Director do Curso"/>

            <select name="select_facul"  id="select_facul" data-theme="a"
                    data-overlay-theme="c" data-pleaceholder="false" data-native-menu="false">
                <?php

                $result = mysqli_query($db->openConection(), "select * from faculdade");
                while ($row= mysqli_fetch_assoc($result)){ if ($row['idFaculdade']!= null){?>
                    <option value="<?php echo $row['idFaculdade']?>"><?php echo $row['descricao']?></option>

                <?php }}?>
                        
            </select>

        </div>

        <div style="padding: 10px 30px" align="right" class="new_disciplina">
            <h3 class="mensagem_d" style="color:blue"></h3>
            <input type="text" name="" value="" id="txt_desc_d" placeholder="Descrição da Disciplina"/>
            <input type="text" name="" value="" id="txt_cred" placeholder="Creditos"/>
            <input type="text" name="" value="" id="txt_codigo" placeholder="Codigo da Disciplina"/>

            <select name="select_nivel" id="select_nivel" data-theme="a"
                    data-overlay-theme="c" data-native-menu="false">

                <option value="" data-theme="a" desable="desable">Nivel Leccionado</option> 
                        <option value="1"> Primeiro</option>
                 <option value="2"> Segundo</option>
                 <option value="3"> Terceiro </option>
                 <option value="3"> Quarto</option>
                 
            </select>

              <div class="" style="margin-top: -3em">
                      
                        <select id="filter">
                    <option value="" desable="desable" data-pleaceholder="true">Seleccionar os Cursos</option>
                    <?php
                    $result = mysqli_query($db->openConection(), "select * from curso");
                    while ($row= mysqli_fetch_assoc($result)){?>
                        <option value="<?php echo $row['idCurso']?>"><?php echo $row['descricao']?></option>
                    <?php }?>            


                            </select>
                    </div>

        </div>

        <!--div><a href="Registo_Academico.php#page1" style="text-decoration: none;color: blue;">Registar Novo Director do Curso ?</div-->
        <br>

        <div data-role="footer" align="right">

            <button data-theme="b" style="font-size:12px; margin-right:2.5em;background:#4682B4;
  border:none; padding: 10px 30px" value="1" class="sv_curso">Salvar</button>

            <button data-theme="b" style="font-size:12px; margin-right:2.5em;background:#4682B4;
  border:none; padding: 10px 30px" value="2" class="sv_disp">Salvar</button>

        </div>

        <a href="#" data-rel="back" id="active_log" class="ui-btn ui-corner-all ui-shadow
 ui-btn-b ui-icon-delete ui-btn-icon-notext ui-btn-right">Sair</a>
    </div>


    <!--  popup contrar recorrencias   --->

    <div data-role="popup" class="jqm-header" id="gerir_recorencia" data-dismissible="false" style="width: 500px">

        <h3 style="font: Consolas;">Controlar Exames de Recorrências</h3>
        <hr style="border: 1.5px solid red;width: 70%">

        <div style="padding: 10px 15px">
            <h3 class="titulo2" style="color:green" align="justify"></h3>
            <table data-role="table" id="table-custom-2" class="ui-body-d ui-shadow table-stripe ui-responsive"
                   style="margin-top: 1em; margin-bottom: 3em">
                <thead>

                <tr class="ui-bar-a" style="background: #B0C4DE; border: none; color:black" align="center">

                    <th>Código</th>
                    <th >&nbsp;</th>
                    <th >Disciplina</th>
                    <th >Acção</th>

                </tr>
                </thead>
                <tbody id="table_rec">

                </tbody>
            </table>
        </div>

        <a href="#" data-rel="back" id="active_log" class="ui-btn ui-corner-all ui-shadow
 ui-btn-b ui-icon-delete ui-btn-icon-notext ui-btn-right">Sair</a>

    </div>


    <div data-role="panel"  id="search"  data-theme="a" data-dismissible="true"
         class="ui-responsive-panel" data-position-fixed="true" data-position="left"
         data-display="overlay" style="width:22.5%;margin-top:2.8em">

        <div style="float:right">

            <input data-icon="delete" class="sairt" data-iconpos="notext" value="Icon only" type="button">

        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <ul data-role="listview" data-theme="d" class="tela_menu"  data-inset="true">

            <li data-theme="b">Selecionar Opção </li>

            <li data-icon="" id="gerir_dd"><a href="Registo_Academico#page1">Docentes e Disciplinas</a></li>
            <li data-icon="" id="gerir_ed"><a href="Registo_Academico#page2">Estudantes e Disciplinas</a></li>
            <li data-icon="" id="gerir_cd"><a href="Registo_Academico#page3">Consultar Pauta</a></li>

        </ul>
    </div>

</div><!-- end content-->


<div data-role="page" id="page2" data-transition="slideup">

    <div data-role="header" data-position="fixed" data-theme="b">
        <h6>&nbsp;</h6>

        <div style="float: left; margin-left: 1em; margin-top: -2em; margin-bottom: 1em"><a href="#search">
                <img src="../../_assets/img/icons-png/bars-white.png" width="20px" class=""></a></div>

        <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
            <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp;<a href="#"><img src="../../_assets/img/icons-png/user-white.png" width="15px"></a>

        </div>

    </div>

    <div data-role="content" align="center" style="margin-top: 5em">


        <div class="ui-corner-all custom-corners nova_pauta" style=" width: 90%; margin-top:4em">

            <div class="ui-bar ui-bar-b" style="background:#aaa; border:none;  border-bottom: 5px solid #ff9933;">


                <div style="float:left">

                    <button data-mini="true" data-inline="true" data-icon="plus" data-iconpos="right" data-theme="b" id="novo_estudante">Novo Estudante</button>

                    <button data-mini="true" data-inline="true" data-icon="gear" data-iconpos="right" data-theme="b" id="assoc_estudante">Estudante Disciplina</button>

                </div>

            </div>

            <div class="ui-body ui-body-a" style="">

                <ul data-role="listview" data-inset="true" class="select_curso" style="width:335px; float: left">
                    <li data-theme="b" class="ui-bar ui-bar-a" style="background: #aaa; border:none">Seleccionar o Curso</li>
                    <?php

                    $db = new mySQLConnection();

                    $result = mysqli_query($db->openConection(), "Select * from curso");
                    while ($row = mysqli_fetch_assoc($result)){?>

                        <li  class="ui-bar ui-bar-a" value="<?php echo $row['idCurso']?>"><?php echo $row['descricao'] ?></li>

                    <?php }?>


                </ul><br>

                <!--- controllo estudante-->

                <div style="float: right; border: 1px solid #ccc; padding: 10px 50px;
                     height: 310px; width: 400px; border-radius: 5px">

                    <h3 style="color:green" class="texto">Regsitos do Novo Estudante</h3>


                    <div class="regista_aluno">

                        <h3 class="sucesso_reg_est" style="color:blue" align="right"></h3>

                        <input type="text" class="ui-bar ui-bar-a"  name="txtnome" value="" id="txtnome" placeholder="Nome Completo"/>
                        <input type="text" class="ui-bar ui-bar-a"  name="txtemail" value="" id="txtemail" placeholder="Endereco Electronico"/>
                        <input type="text" class="ui-bar ui-bar-a"  name="txtsenha" value="" id="txtsenha" placeholder="Numero Mecanografico"/>

                        <select name="select_sexo" id="select_sexo" data-theme="a"
                                data-overlay-theme="c" data-native-menu="false">

                            <option value="" data-theme="a" desable="desable">Seleccionar o Sexo</option> 
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>

                        </select><br>

                    </div>

                    <!--- associar estudante a rec -->
                    <div class="assoc_aluno">
                        <h3 class="sucesso_assoc_est" style="color: blue" align="right"></h3>
                        <input type="search" class="ui-bar ui-bar-a"  name="pesquisar_e" value="" id="pesquisar_e" placeholder="Buscar Estudante ... nome" onkeyup="do_autocomplete(this.value, 3)"/>
                        <ul data-role="listview" data-inset="true" id="resultado"></ul>

                         <div class="ui-field-contain" style="margin-top: -3em">
                                <select id="filter-menu" data-native-menu="false" multiple="multiple"  class="filterable-select"  data-filter-pleaceholder="Pesquisar disciplina">
                                <option value="" desable="desable" data-pleaceholder="true">Seleccionar as Disciplinas</option>

                                <?php
                                $result = mysqli_query($db->openConection(), "select * from disciplina");
                                while ($row= mysqli_fetch_assoc($result)){?>
                                    <option value="<?php echo $row['idDisciplina']?>"><?php echo $row['descricao']?></option>
                                <?php }?>            


                                        </select>

                        </div>
                    </div>


                    <div align="right">

                        <button style="background: #4682B4; padding: 10px 30px; border: none" data-theme="b" data-inline="true" data-mini="true" id="salvar_est"> Salvar</button>

                        <button style="background: #4682B4; padding: 10px 30px; border: none" data-theme="b" data-inline="true" data-mini="true" id="salvar_assoc_est"> Salvar</button>
                    </div>

                </div>

            </div>

        </div> <!--  fin conner alll-->

        <div>
        </div>
    </div>

    <div data-role="footer" data-position="fixed"  data-theme="a" align="right">

        <button data-mini="true" id="sair" onclick="logout()" data-inline="true" data-icon="delete" data-iconpos="right">Sair</button>

    </div>

</div>

<div data-role="page" id="page1" data-transition="flip">

    <div data-role="header" data-position="fixed" data-theme="b">
        <h6>&nbsp;</h6>

        <div style="float: left; margin-left: 1em; margin-top: -2em; margin-bottom: 1em"><a href="#search">
                <img src="../../_assets/img/icons-png/bars-white.png" width="20px" class=""></a></div>

        <div style="float: right; margin-right: 1em; margin-top: -2em; color:yellow">
            <?php echo $_SESSION['nomeC']?>&nbsp;&nbsp;<a href="#"><img src="../../_assets/img/icons-png/user-white.png" width="15px"></a>

        </div>

    </div>

    <div data-role="content" align="center" style="margin-top: 5em">
        <div class="ui-corner-all custom-corners nova_pauta" style=" width: 90%; margin-top:2em">
            <div class="ui-bar ui-bar-b" style="background:#aaa; border:none;  border-bottom: 5px solid #ff9933;">

                <div style="float:left">

                    <button data-mini="true" id="novo_docente" data-inline="true" data-icon="plus" data-iconpos="right" data-theme="b">Novo Docente</button>

                    <button data-mini="true" id="assoc_docente" data-inline="true" data-icon="gear" data-iconpos="right" data-theme="b">Docente Disciplina</button>

                </div>

            </div>

            <div class="ui-body ui-body-a" style="">

                <ul data-role="listview" data-inset="true" class="select_curso" style="width:310px; float: left;">
                    <li class="ui-bar ui-bar-a"  data-theme="b"
                        style="background: #aaa; border:none"><div>Seleccionar o Curso</div></li>
                    <?php


                    $db = new mySQLConnection();

                    $result = mysqli_query($db->openConection(), "Select * from curso");
                    while ($row = mysqli_fetch_assoc($result)){?>

                        <li  class="ui-bar ui-bar-a"  value="<?php echo $row['idCurso']?>"><?php echo $row['descricao'] ?></li>


                    <?php }?>


                </ul><br>


                <div style="float: right; border: 1px solid #ccc; padding: 10px 50px;
                     height: 380px; width: 450px; border-radius: 5px">

                    <h3 style="color:green" class="texto">Registos do Novo Docente</h3>

                    <div class="regista_docente">
                        <h3 class="sucesso_doc" style="color:blue" align="right"></h3>

                        <input type="text" class="ui-bar ui-bar-a" name="txtnome_d" value="" id="txtnome_d" placeholder="Nome Completo"/>
                        <input type="text" class="ui-bar ui-bar-a"  name="txtemail_d" value="" id="txtemail_d" placeholder="Endereco Electronico"/>
                        <input type="text" class="ui-bar ui-bar-a"  name="txtsenha_d" value="" id="txtsenha_d" placeholder="Senha Temporaria"/>

                        <select name="select_categoria" id="select_categoria" data-theme="a"
                                data-overlay-theme="c" data-native-menu="false">

                            <option value="0" data-theme="a"  desable="desable">Seleccionar a Categoria</option> 
                                    <option value="1">Docente</option>
                                    <option value="2">Director do Curso</option>
                            <option value="3">Director Adjunto Pedagogico</option>
                            <option value="4">Director da Fauldade</option>

                        </select>


                        <select name="select-sexo" id="select-sexo" data-theme="a"
                                data-overlay-theme="c" data-native-menu="false">

                            <option value="" data-theme="a" desable="desable">Seleccionar o Sexo</option> 
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>

                        </select>

                        <select name="select_grau" id="select_grau" data-theme="a"
                                data-overlay-theme="c" data-native-menu="false">

                            <option value="" data-theme="a" data-placeholder="true" desable="desable">Seleccionar o Grau Academico</option> 
                                    <?php

                            $result = mysqli_query($db->openConection(), "select * from grau_academico");
                            while ($row= mysqli_fetch_assoc($result)){ if ($row['idGrau']!= null){?>
                                <option value="<?php echo $row['idGrau']?>"><?php echo $row['descricao']?></option>
                            <?php }}?>

                        </select>
                    </div>

                    <!--- associar estudante a rec -->
                    <div class="assoc_docente">
                        <h3 class="sucesso_assoc" align="right"></h3>

                        <input type="search" class="ui-bar ui-bar-a" name="pesquisar_doc" value="" id="pesquisar_doc" autocomplete="on" onkeyup="do_autocomplete(this.value, 1)" placeholder="Buscar Docente ... nome"/>
                        <ul data-role="listview" data-inset="true" id="resultados"></ul>

                            <div class="ui-field-contain" style="margin-top: -3em">
                                  
                                    <select id="filter-menu-doc" data-native-menu="false" multiple="multiple"  class="filterable-select" data-filter-pleaceholder="Pesquisar disciplina">
                                <option value="" desable="desable" data-pleaceholder="true">Seleccionar as Disciplinas</option>
                                <?php
                                $result = mysqli_query($db->openConection(), "select * from disciplina");
                                while ($row= mysqli_fetch_assoc($result)){?>
                                    <option value="<?php echo $row['idDisciplina']?>"><?php echo $row['descricao']?></option>
                                <?php }?>            


                                        </select>
                                </div>

                    </div>


                    <div align="right">

                        <button style="background: #4682B4; border: none; padding: 10px 30px" data-theme="b" data-inline="true" data-mini="true" id="salvar_doc"> Salvar</button>

                        <button style="background: #4682B4; border: none; padding: 10px 30px" data-theme="b" data-inline="true" data-mini="true" id="salvar_assoc_doc"> Salvar</button>
                    </div>

                </div>
                <br>


            </div>

        </div>

    </div>

    <div data-role="footer" data-position="fixed"  data-theme="a" align="right">

        <button data-mini="true" id="sair" onclick="logout()" data-inline="true" data-icon="delete" data-iconpos="right">Sair</button>

    </div>

</div>


</body>
</html>

<script type="text/javascript">

    $(document).ready(function() {

        $('.new_disciplina').hide();
        $('.assoc_aluno').hide();
        $('.assoc_docente').hide();
        $('.sv_disp').hide();
        $('#salvar_assoc_doc').hide();
        $('#salvar_assoc_est').hide();

        $('.select_curso li').click(function() {


            $('.select_curso li.current').removeClass('current').css({'background':'white', 'color':'black'});
            $(this).closest('li').addClass('current');
            $(this).closest('li').css({'background':'rgba(230,235,255,255)', 'color':'blue'});
        });


        $('.get_curso').on('click','li a', function(){

            $('.get_curso li.current a').removeClass('current').css({'background':'#E8E8E8', 'color':'black'});
            $(this).closest('li').addClass('current');
            $(this).closest('li a' ).css({'background':'#E0FFFF', 'color':'blue'});

        });



        $('#novo_estudante').click(function() {
            $('.texto').html('Dados ao novo Estudante');
            $('.assoc_aluno').hide();
            $('.regista_aluno').show('slow');
            $('#salvar_assoc_est').hide();
            $('#salvar_est').show();
        });

        $('#assoc_estudante').click(function(){

            $('.texto').html('Associar estudante a disciplina')
            $('.assoc_aluno').show('slow');
            $('.regista_aluno').hide();
            $('#salvar_assoc_est').show();
            $('#salvar_est').hide();
        });


        $('#novo_docente').click(function() {
            $('.texto').html('Dados ao novo Docente');
            $('.assoc_docente').hide();
            $('.regista_docente').show('slow');
            $('.#alvar_assoc_doc').hide();
            $('.salvar_doc').show();

        });


        $('#salvar_doc').click(function() {

            var un = $('#txtemail_d').val();
            var pn = $('#txtsenha_d').val();
            var nomec = $('#txtnome_d').val();

            var desc= $('#select_categoria >  option:selected').html();
            var grau = $('select#select_grau').val();
            var sexo = $('#select-sexo').val();
            $('.sucesso_doc').show();

            $.ajax({
                url:"Processa_registo_academico.php",
                data:{acao:3, ctg:desc, sexo:sexo, email:un,pass:pn},
                type:"POST",
                success:function(result){
                    //$('.sucesso_doc').html(result); //.fadeOut(6000);

                    $.ajax({

                        url:"Processa_registo_academico.php",
                        data:{acao:4, fullname:nomec, email:un, grau:grau},
                        type:"POST",
                        success:function (result){
                            $('.sucesso_doc').html(result).fadeOut(6000);

                        }
                    }) /// fim segunda requisicao ajax depois do sucesso da primeira;
                }
            }) // fim primeira requisicao ajax;*/
        });

        $('#assoc_docente').click(function(){

            $('.texto').html('Associar Docente a disciplina')
            $('.assoc_docente').show('slow');
            $('.regista_docente').hide();
            $('#salvar_assoc_doc').show();
            $('#salvar_doc').hide();

        });

        $('#nova_disciplina').click(function() {

            $('.new_curso').hide();
            $('.new_disciplina').show('slow');
            $('.sv_disp').show();
            $('.sv_curso').hide();
        });

        $('#novo_curso').click(function() {
            $('.new_curso').show('slow');
            $('.new_disciplina').hide();
            $('.sv_disp').hide();
            $('.sv_curso').show();
        });


        $('.sair').click(function(){
            window.location="../index.html";
        });

        /*--------

         * Eventos salvar cursos e disciplinas
         * */

        $('#txt_dir').keyup(function() {

            var t = $(this).val();

            $('.mensagem').html($(this).val());

            if (t.length > 4){

                $.ajax({
                    url:"Processa_registo_academico.php",
                    type:"POST",
                    data:{texto:t, acao:2},
                    success:function(result){

                        $('.mensagem').html(result).css('color','green');

                    }
                });

            }

        });

        $('.sv_curso').click(function() {

            var des = $('#txt_desc').val();
            var cgo = $('#txt_cod').val();
            var dir=  $('#txt_dir').val();
            var facul = $('#select_facul').val();
            $('.mensagem').show();

            $.ajax({
                url:"Processa_registo_academico.php",
                type:"POST",
                data:{acao:1, descricao:des,codigo:cgo,facul:facul, fullname:dir},
                success:function(result){
                    $('.mensagem').html(result).css('color', 'blue').fadeOut(3000);
                }
            })
        });



        $('.sv_disp').click(function() {

            var cred = $('#txt_cred').val();
            var codg = $('#txt_codigo').val();
            var desc=  $('#txt_desc_d').val();
            var nivel = $('#select_nivel').val();

            $('.mensagem_d').show();

            $.ajax({
                url:"Processa_registo_academico.php",
                type:"POST",
                data:{acao:5, descricao:desc,codigo:codg,nivel:nivel, creditos:cred},
                success:function(result){

                    $('.mensagem_d').html(result).css('color', 'blue').fadeOut(6000);
                    $('#txt_desc_d').val("");
                    $('#txt_codigo').val("");

                }
            });
        });



        /*

         * Metodos Salvar e associar estudante a disciplina
         * */


        $('#salvar_est').click(function (){

            var un = $('#txtemail').val();
            var pn = $('#txtsenha').val();
            var nomec = $('#txtnome').val();
            var desc= "Estudante";
            var sexo = $('select#select_sexo').val();

            $('.sucesso_reg_est').show();

            $.ajax({
                url:"Processa_registo_academico.php",
                data:{acao:3, ctg:desc,sexo:sexo,email:un,pass:pn},
                type:"POST",
                success:function(result){

                    $.ajax({

                        url:"Processa_registo_academico.php",
                        data:{acao:8, fullname:nomec, nrmec:pn, email:un},
                        type:"POST",
                        success:function (result){
                            $('.sucesso_reg_est').html(result).fadeOut(6000);

                        }
                    }) // fim segunda requisicao ajax depois do sucesso da primeira;
                }
            }) // fim primeira requisicao ajax;*/

        });

    });

    /*

     * Metodos autocomplete estudante e docente
     * */



    /*

     * metodos pesquisar estudante e comeca o metodo autocompletar docente;
     * */


    function do_autocomplete(item, t){

        var min_length = 3;
        var keyword = item ;
        $('#resultados').html("");

        if (keyword.length >= min_length) {

            var row = "";
            if (t == 1){ // Pesquisa docente

                $('#resultados').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                $('#resultados').listview("refresh");

                $.ajax({

                    url:"Processa_registo_academico.php",
                    type:"POST",
                    dataType:"json",

                    data: {texto:keyword,acao:6},
                    success : function(result){

                        for (var i=0;  i < result.length; i++){
                            row += '<li value="'+result[i].id+'" onClick="put_doce_item(this.value, 1);" data-theme="b"><a>'+result[i].fullname+'</a></li>';

                        }

                        $('#resultados').show();
                        $('#resultados').html(row);
                        $('#resultados').listview( "refresh" );
                        $('#resultados').trigger( "updatelayout");
                    }
                }); // fim primeiro ajax




            }else{ // fim if de busca docente

                var c =  $('.get_curso li.current').val();

                if (t == 2 && c > 0){


                    $('#resultados_e').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                    $('#resultados_e').listview("refresh");

                    $.ajax({

                        url:"Processa_registo_academico.php",
                        type:"POST",
                        dataType:"json",

                        data: {texto:keyword,curso:c, acao:9},
                        success : function(result){

                            for (var i=0;  i < result.length; i++){
                                row += '<li value="'+result[i].id+'" onClick="put_doce_item(this.value, 2);">' +
                                '<a href="#gerir_recorencia" data-position-to="window" data-rel="popup" data-transition="pop">'+result[i].fullname+'</a></li>';

                            }

                            $('#resultados_e').show();
                            $('#resultados_e').html(row);
                            $('#resultados_e').listview( "refresh" );
                            $('#resultados_e').trigger( "updatelayout");
                            set_item_estd(item);

                        }

                    }); // fim segundo ajax
                }else{ // fim if

                    var cr = $('.select_curso li.current').val();

                    if (t == 3 && cr > 0){
                        $('#resultado').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                        $('#resultado').listview("refresh");

                        $.ajax({

                            url:"Processa_registo_academico.php",
                            type:"POST",
                            dataType:"json",

                            data: {texto:keyword, curso:cr, acao:9},
                            success : function(result){

                                for (var i=0;  i < result.length; i++){
                                    row += '<li value="'+result[i].id+'" onClick="put_doce_item(this.value, 2);" data-theme="a"><a>'+result[i].fullname+'</a></li>';

                                }

                                $('#resultado').show();
                                $('#resultado').html(row);
                                $('#resultado').listview( "refresh" );
                                $('#resultado').trigger( "updatelayout");
                            }


                        }) // fim success

                    }else{jAlert('Seleccionar o curso Primeiro','Atencao', function(r){if(r)return;})} // fim primeiro if
                }
            }  // fim else
        }// fim primeiro if
    } // fim funcao

    /*
     Carrega o id do docente corrente na lista;
     * */

    function put_doce_item(item, t) {


        if (t == 1){
            $('.sucesso_assoc').show();
            var campo = $('#resultados li a');

            for (var i = 0; i< campo.length; i++ ){
                var nodo = campo[i];
                $('#pesquisar_doc').val(nodo.innerText).css('color','blue');
            }

            $('#resultados').hide();

        }else{

            if (t == 2){

                var campo = $('#resultados_e li a');

                for (var i = 0; i< campo.length; i++ ){
                    var nodo = campo[i];
                    $('#pesquisar_est').val(nodo.innerText).css('color','blue');

                }

                set_item_estd($('#pesquisar_est').val());

                var dados = $('#resultado li a');

                for (var i = 0; i< dados.length; i++ ){
                    var nodo = dados[i];
                    $('#pesquisar_e').val(nodo.innerText).css('color','blue');
                }

                $('#resultados_e').hide();
                $('#resultado').hide();

            }

        }

        // associa docente a disciplinas
        var curso = $('.select_curso li.current').val();


        if (curso > 0 && item > 0 &&  t == 1){
            var vetor = $('select#filter-menu-doc')[0];

            $('.sucesso_assoc').show();
            $('#salvar_assoc_doc').click(function() {

                for (var i=0 ; i < vetor.length; i++){

                    if(vetor[i].value!="" && vetor[i].selected == true){

                        $.ajax({

                            url:"Processa_registo_academico.php",
                            type:"POST",
                            data: {disp:vetor[i].value, curso:curso, doc:item, acao:7},
                            success:function(result){

                                $('.sucesso_assoc').html(result).css('color','blue').fadeOut(6000);
                            }

                        });

                    }
                }
                $('#resultados').hide();
            });

        }else{

            if (t == 2 && curso > 0 && item > 0){

                var vetor = $('select#filter-menu')[0];
                $('.sucesso_assoc_est').show();
                $('#salvar_assoc_est').click(function() {

                    for (var i=0 ;i < vetor.length; i++){

                        if(vetor[i].value!="" && vetor[i].selected == true){

                            $.ajax({

                                url:"Processa_registo_academico.php",
                                type:"POST",
                                data: {disp:vetor[i].value, curso:curso, estudante:item, acao:10},
                                success:function(result){
                                    $('.sucesso_assoc_est').html(result).css('color','blue').fadeOut(6000);

                                }
                            });

                        }
                    }

                    $('#resultado').hide();
                });

            }
        }

    } /// fim funcao


    function logout()  {
        window.location="../index.html";
    }

    function mostrarCurso(item){


    }


    function set_item_estd(item) {
        var html ="";

        $('.titulo2').html("");
        $('.titulo2').html("Estudante "+item);

        $.ajax({

            url: "Processa_auto_avaliacao.php",
            type: "POST",
            dataType:"json",
            data: {nomec:item, acao:4},
            success:function(result){

                if (result.length > 0){

                    for(var i = 0 ; i < result.length; i++){

                        html+='<tr class="remove_tr"><td class="codigo">'+result[i].codigo+'</td>';
                        html+='<td>&nbsp;</td>';
                        html+='<td>'+result[i].descricao+'</td>';

                        html+='<td><button data-theme="b" id="btn_assoc"'+
                        'style="font-size:12px; background:#808080; border-radius:4px; border:none" '+             'value="'+result[i].idnota+'" class="ui-bar ui-bar-b"'+
                        'onclick="obter_valor(this.value)">Associar</button></td></tr>';
                    }
                    $('#table_rec').html(html);

                }else{

                    $('#table_rec').html("Nao possui taxas a pagar");
                    $('.titulo2').html(' Nao possui taxas a pagar!');
                }

            }


        });

    }


    /*-------------------------------------------------------------------------------------------------------------*/


    function obter_valor(item) {

        alert(item);

        $.ajax({

            url:"Processa_auto_avaliacao.php",
            type:"POST",
            data:{acao:5, disp:item},

            success: function(result){
                $('.remove_tr tr').removeClass('current');
                $('.remove_tr').remove('tr').fadeOut('slow');

            }
        });
    }


    /*
     Estilizacao do select disciplinas
     *
     * */
    $(document).ready(function(){

        (function( $ ) {
            function pageIsSelectmenuDialog( page ) {
                var isDialog = false,
                    id = page && page.attr( "id" );
                $( ".filterable-select" ).each( function() {
                    if ( $( this ).attr( "id" ) + "-dialog" === id ) {
                        isDialog = true;
                        return false;
                    }
                });
                return isDialog;
            }
            $.mobile.document
                // Upon creation of the select menu, we want to make use of the fact that the ID of the
                // listview it generates starts with the ID of the select menu itself, plus the suffix "-menu".
                // We retrieve the listview and insert a search input before it.
                .on( "selectmenucreate", ".filterable-select", function( event ) {
                    var input,
                        selectmenu = $( event.target ),
                        list = $( "#" + selectmenu.attr( "id" ) + "-menu" ),
                        form = list.jqmData( "filter-form" );
                    // We store the generated form in a variable attached to the popup so we avoid creating a
                    // second form/input field when the listview is destroyed/rebuilt during a refresh.
                    if ( !form ) {
                        input = $( "<input data-type='search'></input>" );
                        form = $( "<form></form>" ).append( input );
                        input.textinput();
                        list
                            .before( form )
                            .jqmData( "filter-form", form ) ;
                        form.jqmData( "listview", list );
                    }
                    // Instantiate a filterable widget on the newly created selectmenu widget and indicate that
                    // the generated input form element is to be used for the filtering.
                    selectmenu
                        .filterable({
                            input: input,
                            children: "> option[value]"
                        })
                        // Rebuild the custom select menu's list items to reflect the results of the filtering
                        // done on the select menu.
                        .on( "filterablefilter", function() {
                            selectmenu.selectmenu( "refresh" );
                        });
                })
                // The custom select list may show up as either a popup or a dialog, depending on how much
                // vertical room there is on the screen. If it shows up as a dialog, then the form containing
                // the filter input field must be transferred to the dialog so that the user can continue to
                // use it for filtering list items.
                .on( "pagecontainerbeforeshow", function( event, data ) {
                    var listview, form;
                    // We only handle the appearance of a dialog generated by a filterable selectmenu
                    if ( !pageIsSelectmenuDialog( data.toPage ) ) {
                        return;
                    }
                    listview = data.toPage.find( "ul" );
                    form = listview.jqmData( "filter-form" );
                    // Attach a reference to the listview as a data item to the dialog, because during the
                    // pagecontainerhide handler below the selectmenu widget will already have returned the
                    // listview to the popup, so we won't be able to find it inside the dialog with a selector.
                    data.toPage.jqmData( "listview", listview );
                    // Place the form before the listview in the dialog.
                    listview.before( form );
                })
                // After the dialog is closed, the form containing the filter input is returned to the popup.
                .on( "pagecontainerhide", function( event, data ) {
                    var listview, form;
                    // We only handle the disappearance of a dialog generated by a filterable selectmenu
                    if ( !pageIsSelectmenuDialog( data.toPage ) ) {
                        return;
                    }
                    listview = data.prevPage.jqmData( "listview" ),
                        form = listview.jqmData( "filter-form" );
                    // Put the form back in the popup. It goes ahead of the listview.
                    listview.before( form );
                });
        })( jQuery );

    })


</script>