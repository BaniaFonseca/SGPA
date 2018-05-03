<?php
//session_start();

require_once("../functions/Conexao.php");
require_once('../controller/EstudanteNotaController.php');
require_once('../controller/PautaNormalController.php');
?>

<?php

class SqlQueryEstudante{

    private $db;
    private $row;
    private $query;
    private $result;
    private static $item;
    private $vetor_nrmec;
    private $json_data;
    private $json_php;
    private $array;


    public function estudanteDisciplina($estudante, $discplina, $ctr) {

        $db = new mySQLConnection();

        $query = "SELECT disciplina.descricao, disciplina.idDisciplina,curso.descricao as curso, curso.idCurso
                    FROM disciplina INNER JOIN estudante_disciplina  ON estudante_disciplina.iddisciplina = disciplina.idDisciplina
          INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                    WHERE estudante_disciplina.idestudante = '$estudante'";

        if ($ctr ==0){
            $query = $query."ORDER BY disciplina.descricao ASC";

        }else{
            $query = $query."AND disciplina.descricao LIKE '$discplina' ORDER BY disciplina.descricao ASC";
            return ($query);
        }

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)) {;}
        return ($row);

    }

    public function estudanteRec($estudante, $estado)
    {
        return ("SELECT estudante_nota.idNota, estudante_nota.nota, disciplina.codigo, disciplina.descricao,examerecorrencia.estado,
                        disciplina.idDisciplina FROM estudante_nota INNER JOIN examerecorrencia
                        ON examerecorrencia.idExameRec = estudante_nota.idNota INNER JOIN pautanormal
                        ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal INNER JOIN disciplina
                        ON disciplina.idDisciplina = pautanormal.idDisciplina

                        WHERE estudante_nota.idEstudante = '$estudante'
                                AND examerecorrencia.estado = '$estado'
                                AND pautanormal.idTipoAvaliacao = 4 AND estudante_nota.nota < 10
                                GROUP BY disciplina.descricao ASC");

    }

    public function getIdEstudante($nome) {
        $db = new mySQLConnection();
        $query = "SELECT estudante.idEstudante as id FROM estudante
INNER JOIN utilizador ON utilizador.id = estudante.idUtilizador
 WHERE  utilizador.username ='$nome'";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['id'];
        }
    }

    public function  validarRecorrencia ($idEst, $idDisp){
        $query ="SELECT COUNT(examerecorrencia.idExameRec) as conta FROM examerecorrencia

			INNER JOIN estudante_nota ON estudante_nota.idNota = examerecorrencia.idExameRec
			INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal

			WHERE pautanormal.idTipoAvaliacao = 4
			AND estudante_nota.idEstudante = '$idEst'
			AND pautanormal.idDisciplina = '$idDisp'
			AND examerecorrencia.estado = 1";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['conta'];
        }
    }
    public function returnTipo($idnota, $ctr){

        if ($ctr == 0){

            $query ="SELECT  pautanormal.idTipoAvaliacao as tipo ";

        }else{

            $query ="SELECT  pautanormal.idDisciplina as tipo ";
        }

        $query = $query."FROM pautanormal
					INNER JOIN estudante_nota ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
					WHERE estudante_nota.idNota = '$idnota'";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)) {
            return $row['tipo'];
        }

    }


    public function  listaPautaPublicada($disp,$estado, $curso) {
        $db = new mySQLConnection();

        $query = " SELECT DISTINCT tipoavaliacao.descricao as avaliacao,tipoavaliacao.idTipoAvaliacao as tipo
                    FROM pautanormal INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                    INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao
                    WHERE disciplina.idDisciplina= '$disp' AND pautanormal.estado = '$estado'  AND pautanormal.idcurso = '$curso'";
        $result = mysqli_query($db->openConection(),$query);

        while ($row[] = mysqli_fetch_assoc($result)){;}
        return ($row);

        $db->closeDatabase();
    }

    public function getpautaDate($disciplina, $estd, $estado, $curso)
    {



        return ("SELECT estudante_nota.idNota,  tipoavaliacao.idTipoAvaliacao as tipo, tipoavaliacao.descricao, estudante_nota.nota,
                pautanormal.idPautaNormal as ptn,pautanormal.dataReg, pautanormal.dataPub FROM tipoavaliacao INNER JOIN pautanormal
                ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
                ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
                ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal

                WHERE estudante_nota.idEstudante = '$estd' AND pautanormal.estado= '$estado'
                AND disciplina.idDisciplina = '$disciplina' AND pautanormal.idcurso = '$curso'

                GROUP BY estudante_nota.idNota, disciplina.descricao ORDER BY tipoavaliacao.descricao DESC");

    }
    public function obterIdCursoEstudante($id)
    {

        $query ="SELECT DISTINCT  estudante_disciplina.idcurso FROM estudante_disciplina
WHERE estudante_disciplina.idestudante = '$id';";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['idcurso'];
        }


    }

    public  function listaNotaTesteAluno($idEstudante,$disciplina, $avaliacao, $curso){

        //$db = new mySQLConnection();

        $query = "SELECT estudante_nota.idNota, tipoavaliacao.descricao, estudante_nota.nota , pautanormal.idPautaNormal as ptn,
                pautanormal.dataReg FROM tipoavaliacao INNER JOIN pautanormal
                ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
                ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
                ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
                    WHERE disciplina.idDisciplina= '$disciplina'  AND estudante_nota.idEstudante = '$idEstudante'
                  AND tipoavaliacao.idTipoAvaliacao = '$avaliacao' AND pautanormal.idcurso = '$curso'
                    ORDER BY tipoavaliacao.descricao ";
        return ($query);

        /* $result = mysqli_query($db->openConection(),$query);
         while ($array[] = mysqli_fetch_assoc($result)){;}
         return ($array);

         $db->closeDatabase();*/
    }

    public function obterQtdAvaliacaoPub($disciplina,$estado,$curso, $ctr){
        $db = new mySQLConnection();

        $query = "SELECT  tipoavaliacao.idTipoAvaliacao as tipo, disciplina.idDisciplina,tipoavaliacao.descricao as descricao
                    FROM pautanormal INNER JOIN tipoavaliacao
                    ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao INNER JOIN  disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina
                    WHERE disciplina.idDisciplina = '$disciplina' AND pautanormal.estado= '$estado' and pautanormal.idcurso ='$curso'
GROUP BY tipoavaliacao.descricao";

        $result = mysqli_query($db->openConection(), $query);
        if ($ctr == 0){
            return (mysqli_num_rows($result));

        }else{

            while($row[] = mysqli_fetch_assoc($result)){;}
            return  ($row);
        }
    }


    public function pautaPublicadas($estado, $curso)
    {
        $db = new mySQLConnection();

        $query = "
                    SELECT DISTINCT tipoavaliacao.idTipoAvaliacao as idtipo, COUNT(tipoavaliacao.idTipoAvaliacao)AS conta, disciplina.descricao

                    FROM disciplina INNER JOIN pautanormal ON pautanormal.idDisciplina = disciplina.idDisciplina
                    INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao= pautanormal.idTipoAvaliacao
                    INNER JOIN curso ON curso.idCurso = disciplina.idCurso WHERE curso.idCurso= '$curso' AND
                    pautanormal.estado = '$estado' GROUP BY disciplina.descricao";

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)) {; }
        return ($row);
    }

    public function getCursoDescricao($disp)
    {
        $db = new mySQLConnection();
        $query = "SELECT curso.descricao FROM curso INNER JOIN disciplina ON
            disciplina.idCurso = curso.idCurso
               WHERE disciplina.idDisciplina = '$disp'";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['descricao '];
        }

    }

    public function getCoutEstdPauta($value, $estado)
    {

        $db = new mySQLConnection();
        $query = "SELECT COUNT(estudante_nota.idEstudante) as conta FROM
                    estudante_nota INNER JOIN pautanormal ON pautanormal.idPautaNormal= estudante_nota.idPautaNormal
                    WHERE pautanormal.estado = '$estado' AND pautanormal.idTipoAvaliacao= '$value';";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['conta'];
        }
    }


    public function getDetalhesPauta($idCurso)
    {

        $db = new mySQLConnection();

        $query ="SELECT disciplina.descricao, disciplina.idDisciplina, COUNT(pautanormal.idTipoAvaliacao) as conta FROM disciplina
                INNER JOIN curso ON curso.idCurso = disciplina.idCurso  INNER JOIN pautanormal
                ON pautanormal.idPautaNormal = disciplina.idDisciplina INNER JOIN tipoavaliacao
                ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao
                WHERE curso.idCurso='$idCurso'
                GROUP BY tipoavaliacao.descricao";

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)) {;}
        return ($row);

    }

    public function getPlanoAvaliacao($disciplina)
    {
        return("SELECT planoavaliacao.qtdMaxAvaliacao as qtd, disciplina.descricao as disp,
                     planoavaliacao.peso, tipoavaliacao.descricao FROM tipoavaliacao INNER JOIN planoavaliacao
                     ON tipoavaliacao.idTipoAvaliacao = planoavaliacao.idTipoAvaliacao INNER JOIN disciplina
                     ON disciplina.idDisciplina= planoavaliacao.idDisciplina
              WHERE planoavaliacao.idDisciplina= '$disciplina'");
    }

    public function checkIdPautaNorml($disciplina, $av,$estado,$idptn, $curso , $ctr){
        $query = "SELECT estudante_nota.idNota, tipoavaliacao.idTipoAvaliacao as tipo, tipoavaliacao.descricao, estudante_nota.nota,
                pautanormal.idPautaNormal as ptn,pautanormal.dataReg, pautanormal.dataPub,estudante.nrEstudante as nrmec,
                estudante.nomeCompleto,disciplina.descricao as displ
                FROM tipoavaliacao INNER JOIN pautanormal
                ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
                ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
                ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN estudante
                ON estudante.idEstudante = estudante_nota.idEstudante INNER JOIN estudante_disciplina
                                                                        ON estudante_disciplina.idestudante = estudante.idEstudante

                WHERE pautanormal.estado= 2 AND estudante_disciplina.iddisciplina= '$disciplina'
                                        AND tipoavaliacao.idTipoAvaliacao = '$av' AND pautanormal.idcurso = '$curso' AND estudante_disciplina.idcurso= '$curso'";

        if ($ctr==0){

            $query=$query."AND pautanormal.idPautaNormal = '$idptn'";
        }else{
            $query=$query."GROUP BY pautanormal.idPautaNormal";
        }
        return ($query);

    }

    public function novo_modelo_relatorio($ptn,$estado)
    {
        return ("SELECT estudante_nota.idNota,  estudante_nota.idEstudante, estudante_nota.nota, estudante.nomeCompleto,
                               estudante.nrEstudante as nrmec, pautanormal.idDisciplina as disp,pautanormal.idTipoAvaliacao as tipo, pautanormal.idcurso
                              FROM estudante INNER JOIN estudante_nota ON estudante_nota.idEstudante = estudante.idEstudante
                              INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                              WHERE pautanormal.idPautaNormal = '$ptn' AND pautanormal.estado= '$estado'");
    }

    public function buscarDadosDisciplina($disciplina,$curso)
    {
        return ("SELECT DISTINCT docente.idDocente, utilizador.idSexo , grau_academico.descricao as grauAcademico,
 curso.descricao,curso.idCurso, docentedisciplina.semestre,
                            docente.nomeCompleto FROM docente
INNER JOIN grau_academico ON grau_academico.idGrau = docente.idGrauAcademico
INNER JOIN utilizador ON utilizador.id = docente.idUtilizador
           INNER JOIN docentedisciplina ON docente.idDocente = docentedisciplina.idDocente
           INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso
                      WHERE docentedisciplina.idDisciplina= '$disciplina' AND docentedisciplina.idCurso= '$curso'");
    }


    public function contas_estudantes($disp,$curso , $ctr, $tipo){
        $query ="";
        if ($ctr == 1){
            $query.="SELECT COUNT(DISTINCT estudante.nrEstudante) as qtd   FROM estudante
INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante
WHERE estudante_disciplina.idcurso = '$curso' AND estudante_disciplina.iddisciplina= '$disp'";
        }

        if ($ctr == 2){
            $query.="SELECT COUNT(DISTINCT estudante.nrEstudante) as qtd   FROM estudante
INNER JOIN estudante_nota ON estudante_nota.idEstudante = estudante.idEstudante
INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal

WHERE pautanormal.idCurso = '$curso' AND pautanormal.idDisciplina = '$disp'";
        }

        if (($ctr == 3) && ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante.nrEstudante) as qtd   FROM estudante
INNER JOIN estudante_nota ON estudante_nota.idEstudante = estudante.idEstudante
INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal

WHERE pautanormal.idCurso = '$curso' AND pautanormal.idDisciplina = '$disp' AND pautanormal.idTipoAvaliacao= '$tipo'";
        }

        if (($ctr == 4 )&& ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante_nota.idEstudante) as qtd   FROM estudante_nota
WHERE estudante_nota.idEstudante NOT IN(

 SELECT estudante_nota.idEstudante FROM estudante_nota
         INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
          WHERE pautanormal.idCurso = '$curso' AND pautanormal.idDisciplina = '$disp' AND pautanormal.idTipoAvaliacao= '$tipo')";
        }


        if (($ctr == 5) && ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = '$tipo'
AND estudante_nota.nota >= 10;";
        }

        if (($ctr== 6 )&& ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = '$tipo'
AND estudante_nota.nota = 0;";
        }

        if (($ctr == 7) && ($tipo == 4 || $tipo== 5) ){

            $query.="SELECT COUNT(DISTINCT estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina='$disp' AND pautanormal.idTipoAvaliacao = 5
AND estudante_nota.nota < 10;";

        }

        if (($ctr== 8)){

            $query.="SELECT COUNT(DISTINCT estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao > 3
AND estudante_nota.nota >= 10;";
        }

        if (($ctr== 9)){

            $query.="SELECT COUNT(DISTINCT estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao > 3
AND estudante_nota.nota < 10;";
        }

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['qtd']);
        }
    }
    public function contar_media($curso, $disp , $ctr)
    {
        $query ="SELECT  DISTINCT AVG(estudante_nota.nota) as media, estudante_nota.idEstudante from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
INNER JOIN estudante_disciplina ON estudante_disciplina.iddisciplina = disciplina.idDisciplina

                        INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                        INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao
                        WHERE disciplina.idDisciplina = '$disp'
                        AND pautanormal.estado= 2 AND pautanormal.idcurso= '$curso' AND tipoavaliacao.idTipoAvaliacao < 4
GROUP BY estudante_nota.idEstudante";

        $cota =0;
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        while ($row = mysqli_fetch_assoc($result)){
            if ($row['media'] >=16 && $ctr== 1){$cota++;} // dispensados
            if ($row['media'] < 10 && $ctr== 2){$cota++;} // excluidos
            if ($row['media'] >= 10 && $row['media'] < 16 && $ctr== 3 ){$cota++;} // admitidos do exame normal
        }
        return $cota;
    }

    public function return_mes()
    {
        if (date('m')== 1){return 'Janeiro';}
        if (date('m')== 2){return 'Fevereiro';}
        if (date('m')== 3){return 'Março';}
        if (date('m')== 4){return 'Abril';}
        if (date('m')== 5){return 'Maio';}
        if (date('m')== 6){return 'Junho';}
        if (date('m')== 7){return 'Julho';}
        if (date('m')== 8){return 'Agosto';}
        if (date('m')== 9){return 'Setembro';}
        if (date('m')== 10){return 'Outubro';}
        if (date('m')== 11){return 'Novembro';}
        if (date('m')== 12){return 'Dezembro';}
    }


    public function returnMediaEstudante($idEst, $disp, $curso)
    {
        $q="SELECT  DISTINCT AVG(estudante_nota.nota) as media, estudante_nota.idEstudante from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                                                            INNER JOIN estudante_disciplina ON estudante_disciplina.iddisciplina = disciplina.idDisciplina

                        INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                        INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disp' AND
estudante_nota.idEstudante = '$idEst' AND pautanormal.idcurso= '$curso' AND tipoavaliacao.idTipoAvaliacao < 4
GROUP BY estudante_nota.idEstudante";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $q);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['media']);
        }

    }

    public function validar_busca_recorrencia($aluno, $disp, $curso, $tipo)
    {
        $query ="SELECT estudante_nota.nota FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = '$tipo'
AND estudante_nota.nota >= 10 AND estudante_nota.idEstudante = '$aluno';";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['nota']);
        }

    }

    public function aprovados_exa_nor($curso, $disp)
    {
        $query = "SELECT estudante_nota.nota, estudante_nota.idEstudante as id FROM estudante_nota
          INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
          WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = 4
          AND estudante_nota.nota >= 10";

        return ($query);

    }

    public function aprovados_exa_rec($curso, $disp)
    {
        $query = "SELECT estudante_nota.nota, estudante_nota.idEstudante as id FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = 5
AND estudante_nota.nota >= 10";

        $estudante = new SqlQueryEstudante();

        $ex_nor = $estudante->aprovados_exa_nor($curso, $disp);

        $db = new mySQLConnection();
        $conta=0;

        $result = mysqli_query($db->openConection(), $query);
        $res = mysqli_query($db->openConection(), $ex_nor);

        while ($row = mysqli_fetch_assoc($result)){

            while ($vetor = mysqli_fetch_assoc($res)){
                if ($row['nota'] < 10 && $vetor['nota'] >= 10 && $vetor['id'] == $row['id']){
                    $conta++;
                }

            }

        }return $conta;

    }


}


?>
