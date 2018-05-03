
<?php

session_start();
   require_once('../controller/PublicacaoQueryController.php');
   require_once('../controller/PublicacaoQueryController.php');
   require_once("../functions/Conexao.php");
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/QueryController.php');

   require_once('../controller/QueryControllerEstudante.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/PublicacaoQueryController.php');

    $est_ctr = new SqlQueryEstudante();

?>

<?php

	$query = new QuerySql();
	$idDoc = $query->getDoc_id($_SESSION['username']);

	$db = new mySQLConnection();

	$nome=""; $apelido ="";

	$acao = $_POST['acao'];

	switch($acao){

            case 1:

                $keyword = '%'.$_POST['keyword'].'%';
                $disciplina = $_REQUEST['disciplina'];
                $db = new mySQLConnection();

                $curso = $query->getDocenteIdCurso($disciplina, $idDoc);

                $consulta = $query->queryAutoComplete($keyword, $curso, $disciplina);
                $result = mysqli_query($db->openConection(), $consulta);

                $t=0;

                while ($row = mysqli_fetch_assoc($result)){
					$vetor[] = array('nome'=>$row['nomeCompleto']);

		}
		echo json_encode($vetor);


             break;

            case 2:

			?>

                    <form  class="formularioP">
                    <fieldset data-role="controlgroup" data-type="horizontal">

                    <?php

                        $disp = $_POST['disciplina'];
                        $ctr =$_POST['ctr'];

                        if ($ctr == 1){

                                 $nrmec = $_POST['nrmec'];
                                 $curso =$query->obterCursoEstudante($nrmec);
                                 $idAluno =  $query->getIdEstudante($nrmec);

                        }else{
                                  $curso = $_POST['curso'];
                        }

                   $vetor  = $query->obterQtdAvaliacao($disp, $curso);

                    foreach ($vetor as $array) {

                       if ($array != null){
                           $tipo= $array['tipo']; ?>

                    <div class="my_drop">
                 <!-- A primeira condicao do if busca o ID da nota para edicao e a segunda para impressao de pauta--->

                              <?php if ($ctr == 1){?>
            <select name="teste" id="getAvaliacao" onchange="getItem(this.value)" data-overlay-theme="c" data-theme="b" data-native-menu="false">
                                  <?php }else{?>

               <select name="teste" id="get_tipo_aval" onchange="obter_tipo_av(this.value)" data-overlay-theme="c" data-theme="b" data-native-menu="false">

                                            <?php }?>
                            <option value="0" class="ui-bar-d" > <?php echo  $array['descricao']?> </option>

                       <?php
                    switch ($tipo) {

                        case 1:

                            $i = 0;
                            if ($ctr == 2){

                                   $vetorNota =$query->listar_tipo_avaliacao($disp, $curso, $tipo);
                            }else{

                                   $vetorNota = $query->listaNotaTesteAluno($idAluno, $disp, $tipo);
                            }

                            foreach ($vetorNota as $myvar) {
                                echo $array['descricao'] ;
                                if ($myvar != null) { ++$i; ?>

                            <option value="<?php echo $myvar['idNota'] ?>" style="font-size:12px "><?php echo  $array['descricao']  . ' ' . $i ?></option>



                        <?php } } break;

                        case 2:


                            $i = 0;

                            if ($ctr == 2){

                                   $vetorNota =$query->listar_tipo_avaliacao($disp, $curso, $tipo);
                            }else{

                                   $vetorNota = $query->listaNotaTesteAluno($idAluno, $disp, $tipo);
                            }

                            foreach ($vetorNota as $myvar) {
                               echo $array['descricao'] ;
                                if ($myvar != null) { ++$i; ?>

                            <option value="<?php echo $myvar['idNota'] ?>"><?php echo $array['descricao'] . ' ' . $i ?></option>

                        <?php }} break;

                        case 3:


                        $i = 0;


                           if ($ctr == 2){

                                   $vetorNota =$query->listar_tipo_avaliacao($disp, $curso, $tipo);
                            }else{

                                   $vetorNota = $query->listaNotaTesteAluno($idAluno, $disp, $tipo);
                            }


                            foreach ($vetorNota as $myvar) {
                               echo $array['descricao'];
                                if ($myvar != null) {++$i; ?>

                            <option value="<?php echo $myvar['idNota'] ?>"><?php echo $array['descricao'] . ' ' . $i ?></option>
                            <?php } } break;

                        case 4:


                        $i = 0;


                            if ($ctr == 2){

                                   $vetorNota =$query->listar_tipo_avaliacao($disp, $curso, $tipo);
                            }else{

                                   $vetorNota = $query->listaNotaTesteAluno($idAluno, $disp, $tipo);
                            }


                            foreach ($vetorNota as $myvar) {
                               echo $array['descricao'] ;
                             if ($myvar != null) {++$i; ?>

                            <option value="<?php echo $myvar['idNota'] ?>"><?php echo $array['descricao'] . ' ' . $i ?></option>

                             <?php } } break;

                        case 5:

                           $i = 0;


                            if ($ctr == 2){

                                   $vetorNota =$query->listar_tipo_avaliacao($disp, $curso, $tipo);
                            }else{

                                   $vetorNota = $query->listaNotaTesteAluno($idAluno, $disp, $tipo);
                            }


                            foreach ($vetorNota as $myvar) {
                              echo $array['descricao'] ;
                                if ($myvar != null) {++$i; ?>
                            <option value="<?php echo $myvar['idNota'] ?>"><?php echo $array['descricao'] . ' ' . $i ?></option>

                            <?php } } break;


                    default: return 0; }?> <!--end of swicth-->


                    </select>

                    </div>

                    <?php } }?> <!--end for-->

                          </fieldset>
                     </form>


       <?php break;

       case 3:
                $curso = $_POST['idcurso'];
                $nome = '%'.$_POST['keyword'].'%';
                $db = new mySQLConnection();


                $query =  " SELECT DISTINCT estudante.nrEstudante, estudante.nomeCompleto FROM estudante
                            INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante
                            WHERE estudante_disciplina.idcurso = '$curso'  AND estudante.nomeCompleto LIKE '$nome'";

                $result = mysqli_query($db->openConection(), $query);

                $t=0;

                while ($row = mysqli_fetch_assoc($result)){
                    ++$t;
                    $estudante = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row['nomeCompleto']);

                    echo '<li class="ui-body ui-body-a" onclick="set_item_estd(\''.str_replace("'", "\'", $row['nomeCompleto']).'\')">'.$estudante.'</li>';

                }
                $db->closeDatabase();

           break;


        case 4:
                $db = new mySQLConnection();
                $aluno = $_POST['nomec'];

                $idAluno =  $query->getIdEstByNameApelido($aluno,1);
                $_SESSION['aluno'] = $idAluno;

                $query = $est_ctr->estudanteRec($idAluno,1);

                $result = mysqli_query($db->openConection(), $query);
                $t=0;

                 while ($row= mysqli_fetch_assoc($result)) {
                       $vetor_x[] = array('codigo'=>$row['codigo'],
                                        'descricao'=>$row['descricao'],
                                        'nota'=>$row['nota'],
                                        'idnota'=>$row['idNota'],
                                        'idDisp'=>$row['idDisciplina']) ;
                 }
                 echo json_encode($vetor_x);

            $db->closeDatabase();
            break;

            case 5:

        		$db = new mySQLConnection();
				$estado = 2;
				$idnota =  $_POST['disp'];
				$_SESSION['idnota_ass']= $idnota;

				$query = "UPDATE `examerecorrencia` SET  `estado`= '$estado'  WHERE  `idExameRec`= '$idnota'";

					$stmt = mysqli_prepare($db->openConection(),$query);
					$result = mysqli_stmt_bind_param($stmt,'ii',$estado, $idnota);

					if (mysqli_stmt_execute($stmt)){

						echo('Pauta publicada com sucesso');
				    }else{
						echo('Nao foi possivel publicar a pauta');
					}

				  break;

            case 6:

                $nome = '%'.$_POST['keyword'].'%';
                $db = new mySQLConnection();

                $query ="SELECT docente.idDocente, docente.nomeCompleto FROM docente
                            WHERE nomeCompleto LIKE '$nome'";

                $result = mysqli_query($db->openConection(), $query);

                while ($row = mysqli_fetch_assoc($result)){

                    $docente = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row['nomeCompleto']);

                    echo '<li  class="ui-body ui-body-d" onclick="sub_item_docente(\''.str_replace("'", "\'", $row['nomeCompleto']).'\')"><a>'.$docente.'</a></li>';

                 }

                $db->closeDatabase();

            break;

            case 7:
                     $db = new mySQLConnection();

                     $fullname= $_POST['estudante'];
                     $idest= $query->getIdEstByNameApelido($fullname, 0);

                     $query = "SELECT COUNT(estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN examerecorrencia ON estudante_nota.idNota = examerecorrencia.idExameRec
WHERE estudante_nota.idEstudante = '$idest'" ;
                    $result = mysqli_query($db->openConection(), $query);

                     if($row = mysqli_fetch_assoc($result)){
                              echo $row['qtd'];
                    }
            break;




 }?>



