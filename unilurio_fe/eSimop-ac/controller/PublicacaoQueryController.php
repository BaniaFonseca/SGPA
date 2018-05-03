<?php

	require_once("../functions/Conexao.php");
	require_once('../controller/EstudanteNotaController.php');
	require_once('../controller/PautaNormalController.php');
?>

<?php

class PublicarPauta{

	private $db;
	private $row;
	private $query;
	private $result;
	private static $item;
	private $vetor_nrmec;
	private $json_data;
	private $json_php;
	private $array;
	private $arrayd;

	/*-------------Mostra a lista de pautas nao/ou publicadas por curso, caso seja passado valor 1 retorna  ----*/

	public function listapautaCurso($estado, $idDoc){
		$db = new mySQLConnection();

		$query = "SELECT DISTINCT  pautanormal.idcurso, curso.descricao as curso FROM curso

                              INNER JOIN pautanormal ON pautanormal.idcurso = curso.idCurso
                              INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                              INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                              INNER JOIN estudante_nota ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
                              INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao=pautanormal.idTipoAvaliacao

                              WHERE pautanormal.estado = '$estado' AND curso.coordenador='$idDoc'";

		$result = mysqli_query($db->openConection(),$query);
		while ($row[] = mysqli_fetch_assoc($result)){;

		}
		return ($row);
	$db->closeDatabase();
	}

	public function listaDisciplinaCurso($estado, $curso){

		$db = new mySQLConnection();
		$query = "SELECT DISTINCT disciplina.descricao,disciplina.idDisciplina,pautanormal.idPautaNormal as ptn,
                                        COUNT(DISTINCT pautanormal.idTipoAvaliacao) as qtd

                                                  FROM pautanormal INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                                                  INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                                                  INNER JOIN curso ON curso.idCurso= docentedisciplina.idCurso INNER JOIN estudante_nota
                                                  ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN tipoavaliacao
                                                  ON tipoavaliacao.idTipoAvaliacao=pautanormal.idTipoAvaliacao
                                                  WHERE pautanormal.estado = '$estado' and pautanormal.idcurso ='$curso'
GROUP BY disciplina.descricao";


        $result = mysqli_query($db->openConection(),$query);
        while ($row[] = mysqli_fetch_assoc($result)){;

        }
        return ($row);

	}

          public function qtdAvaliacaoPublicada($estado, $curso)
{
                    $query ="SELECT  COUNT(DISTINCT pautanormal.idDisciplina) as quantidade
   FROM pautanormal INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
WHERE pautanormal.estado = '$estado' AND pautanormal.idcurso = '$curso'";

                   $db = new mySQLConnection();
                    $result = mysqli_query($db->openConection(),$query);
                    if ($row= mysqli_fetch_assoc($result)){
                              return ($row['quantidade']);
                    }

          $db->closeDatabase();


}

	public function listaAvaliacaoDisciplina($estado, $disciplina, $curso){

                        //obtem somente pauta normal
       return "SELECT DISTINCT tipoavaliacao.descricao as avaliacao,tipoavaliacao.idTipoAvaliacao as tipo,
        			disciplina.idDisciplina, pautanormal.idPautaNormal as ptn,pautanormal.idcurso, pautanormal.dataReg
        			FROM tipoavaliacao INNER JOIN pautanormal ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao
        			INNER JOIN disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
        			ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
        			WHERE disciplina.idDisciplina= '$disciplina' AND pautanormal.estado = '$estado'
        			 AND pautanormal.idcurso= '$curso'";

	   }

	public function listaNotaEstudante($disciplina,$pautaNormal,$curso, $estado){
		      $db = new mySQLConnection();

		$query = "SELECT DISTINCT estudante.nomeCompleto, estudante_nota.nota, disciplina.descricao,
                    estudante_nota.idNota,estudante.nrEstudante
                    FROM estudante_nota

    INNER JOIN estudante ON estudante.idEstudante= estudante_nota.idEstudante
                    INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                    INNER JOIN disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina
                    INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante=estudante.idEstudante
INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso

                    WHERE disciplina.idDisciplina ='$disciplina'  AND pautanormal.estado= '$estado' AND pautanormal.idcurso= '$curso'
AND pautanormal.idPautaNormal = '$pautaNormal'";

	           $result = mysqli_query($db->openConection(),$query);

		       while ($row[] = mysqli_fetch_assoc($result)){;}
		       return ($row);

	$db->closeDatabase();

	}

	public function getNomeDsciplina($idDisp){
		$db = new mySQLConnection();
		$query = "SELECT disciplina.descricao FROM disciplina
					WHERE disciplina.idDisciplina = '$idDisp';";

		$result = mysqli_query($db->openConection(), $query);
		if ($row = mysqli_fetch_assoc($result)){
			return $row['descricao'];
		}
	$db->closeDatabase();

	}

	public function pautaNormal($ptn, $ctr)
	{
                          if( $ctr==0){

          $query ="SELECT disciplina.descricao as valor FROM disciplina INNER JOIN pautanormal
ON pautanormal.idDisciplina = disciplina.idDisciplina
WHERE pautanormal.idPautaNormal = '$ptn'";
                              }
                              if ($ctr== 2){
          $query = "SELECT pautanormal.idcurso as valor FROM pautanormal
WHERE pautanormal.idPautaNormal = '$ptn'";

                              }
                              if ($ctr== 1){
          $query ="SELECT disciplina.idDisciplina as valor FROM disciplina
INNER JOIN pautanormal ON pautanormal.idDisciplina = disciplina.idDisciplina
WHERE pautanormal.idPautaNormal = '$ptn'";
                              }

                               if ($ctr== 3){
          $query = "SELECT curso.descricao as valor FROM curso
          INNER JOIN pautanormal on pautanormal.idcurso = curso.idCurso
WHERE pautanormal.idPautaNormal ='$ptn'";

                              }
                               if ($ctr== 4){
                                         $query ="SELECT tipoavaliacao.idTipoAvaliacao as valor FROM tipoavaliacao
          INNER JOIN pautanormal on pautanormal.idTipoAvaliacao = tipoavaliacao.idTipoAvaliacao
WHERE pautanormal.idPautaNormal =  '$ptn'";
                               }

                    $db = new mySQLConnection();
                    $result = mysqli_query($db->openConection(), $query);
                    if ($row = mysqli_fetch_assoc($result)){
                              return $row['valor'];
                    }
          $db->closeDatabase();
	}


	/*--------------------------Lista de disciplina curso estudante ---------------------------------*/

          public function listaEstudanteDisp($idEst, $disp){
		$db = new mySQLConnection();

		return("SELECT DISTINCT disciplina.descricao, disciplina.idDisciplina FROM  disciplina
                                        INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                                                  INNER JOIN curso on curso.idCurso = docentedisciplina.idCurso INNER JOIN inscricaodisciplina
                                                  on inscricaodisciplina.iddisciplina = disciplina.idDisciplina INNER JOIN inscricao
                                                  ON inscricao.idinscricao = inscricaodisciplina.idinscricao INNER JOIN estudante
                                                  ON estudante.idEstudante = estudante.idEstudante
                                          WHERE estudante.idEstudante = '$idEst' AND disciplina.descricao LIKE '%$disp%'
                                          ORDER BY disciplina.descricao ASC;");
  		}


   public  function get_Director_Curso($idcurso){
           $db = new mySQLConnection();
          $q ='SELECT CONCAT_WS(" º. ",grau_academico.descricao,docente.nomeCompleto) as coor_curso FROM docente
INNER JOIN curso ON curso.coordenador = docente.idDocente
INNER JOIN grau_academico ON grau_academico.idGrau= docente.idGrauAcademico WHERE curso.idCurso ='.$idcurso;

 $rs = mysqli_query($db->openConection(), $q);

    if ($row= mysqli_fetch_assoc($rs)) {
         return ($row['coor_curso']);
    }
}

function get_nome_dir(){
           $db = new mySQLConnection();

      $query='SELECT CONCAT_WS(" ,",docente.nomeCompleto,grau_academico.descricao) as grau FROM utilizador
INNER JOIN faculdade ON faculdade.responsavel= utilizador.id INNER JOIN docente
ON docente.idUtilizador = utilizador.id INNER JOIN grau_academico
ON grau_academico.idGrau = docente.idGrauAcademico;';

         $result = mysqli_query($db->openConection(), $query);

         if ($row = mysqli_fetch_assoc($result)){
              return ($row['grau']);
         }
 }

function get_nome_adj(){

 $db = new mySQLConnection();
      $query='SELECT CONCAT_WS(" ,",docente.nomeCompleto,grau_academico.descricao) as grau, utilizador.id FROM docente INNER JOIN
grau_academico ON grau_academico.idGrau = docente.idGrauAcademico INNER JOIN utilizador
ON utilizador.id = docente.idUtilizador WHERE utilizador.categoria="Director Adj. Pedagogico";';

         $result = mysqli_query($db->openConection(), $query);

         if ($row = mysqli_fetch_assoc($result)){
              return ($row['grau']);
         }
 }

public function buscar_docente($dip){
 $db = new mySQLConnection();
    $q = "SELECT docente.nomeCompleto, utilizador.idSexo, grau_academico.descricao FROM docente
INNER JOIN utilizador ON utilizador.id= docente.idUtilizador
 INNER JOIN grau_academico ON grau_academico.idGrau = docente.idGrauAcademico
 INNER JOIN docentedisciplina ON docente.idDocente = docentedisciplina.idDocente
 INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso
            WHERE docentedisciplina.idDisciplina= '$dip'";

    $rs = mysqli_query($db->openConection(), $q);
    $t=0; $sexo="";
    if ($row= mysqli_fetch_assoc($rs)) {

          if ($row['idSexo'] == 1 && $row['descricao']!='Msc.' && $row['descricao']!="Ph.D"){
               $sexo='º';

          }elseif($row['idSexo'] != 1 ){
               $sexo='ª';
          }

          return ($row['descricao'].''.$sexo.'.  '.$row['nomeCompleto']);
    }
}


public function mostra_datas_plano($disp)
{
          return ("SELECT data_avaliacao.dataRealizacao, data_avaliacao.idavaliacao FROM data_avaliacao
WHERE data_avaliacao.idDisciplina = '$disp';");
}

public function contar_datas_avaliacao($av, $disp)
{

	$db = new mySQLConnection();

	$rs = mysqli_query($db->openConection(), "SELECT COUNT(data_avaliacao.idavaliacao) as contas FROM data_avaliacao
WHERE data_avaliacao.idavaliacao = '$av' AND data_avaliacao.idDisciplina = '$disp';");
          if ($row = mysqli_fetch_assoc($rs)){
                    return ($row['contas']);
          }
}

}

?>

