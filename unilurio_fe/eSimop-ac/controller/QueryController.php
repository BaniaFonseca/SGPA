<?php

require_once("../functions/Conexao.php");
require_once('../controller/EstudanteNotaController.php');
require_once('../controller/PautaNormalController.php');

?>

<?php

class QuerySql{

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

    public function listaDisciplina($docente, $ctr){

        $this->db = new mySQLConnection();

        $query = "SELECT DISTINCT  disciplina.idDisciplina, disciplina.descricao
FROM disciplina INNER JOIN docentedisciplina on docentedisciplina.idDisciplina =  disciplina.idDisciplina
INNER JOIN docente on docente.idDocente = docentedisciplina.idDocente
INNER JOIN curso ON curso.idCurso= docentedisciplina.idCurso

WHERE docentedisciplina.idDocente = '$docente'";

        if ($ctr == 0 ){
            return ($query);

        }else{

            $result = mysqli_query($this->db->openConection(),$query);
            while($row = mysqli_fetch_assoc($result)){
                $array[] = array('disciplina'=> $row['idDisciplina'],
                    'descricao'=> $row['descricao']);
            }
            return (($array));
        }
    }

    /*Lista todos os cursos que um dado docente lecciona*/

    public function discplinasCurso($idcurso)
    {
        return ("SELECT DISTINCT disciplina.idDisciplina as disp, disciplina.descricao FROM disciplina
INNER JOIN docentedisciplina ON disciplina.idDisciplina= docentedisciplina.idDisciplina
WHERE docentedisciplina.idCurso = '$idcurso'");
    }

    public function get_Cursos()
    {
        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),"SELECT idCurso, descricao from curso");

        while ($row[] = mysqli_fetch_assoc($result)){;}
        return ($row);
    }

    public function listaCursoDocente($docente){

        $db = new mySQLConnection();

        $query= "SELECT DISTINCT curso.idCurso as idC, curso.descricao as nomeC from curso
INNER JOIN docentedisciplina on docentedisciplina.idCurso = curso.idCurso
INNER JOIN docente ON docente.idDocente = docentedisciplina.idDocente
   WHERE docente.idDocente= '$docente'";

        $result = mysqli_query($db->openConection(),$query);

        while($array[] = mysqli_fetch_assoc($result)){
            ;
        }

        return ($array);
        $db->closeDatabase();
    }

    public function analisarDisciplina($doc,$cr,$disp)
    {
        $query ="SELECT COUNT(*) as valor FROM docentedisciplina
   WHERE docentedisciplina.idDocente= '$doc' and docentedisciplina.idDisciplina = '$disp'
 AND docentedisciplina.idCurso = '$cr'";
        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),$query);

        if($array = mysqli_fetch_assoc($result)){
            return ($array['valor']);
        }

        $db->closeDatabase();
    }

    /*Lista todas disciplinas por cursos nas quais o docente encontra se associado*/
    public function listaDispCursoDocente($curso, $docente){

        $db = new mySQLConnection();

        $query = "SELECT DISTINCT disciplina.idDisciplina as disp,
		disciplina.descricao as nomeD from disciplina
INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso

      WHERE docentedisciplina.idCurso = '$curso' and docentedisciplina.idDocente='$docente'";
        $result = mysqli_query($db->openConection(),$query);

        while($array[] = mysqli_fetch_assoc($result)){
        }
        return ($array);

        $db->closeDatabase();
    }

    public function getDocenteIdCurso($disciplina, $idDocente)
    {
        $db = new mySQLConnection();

        $query = "SELECT DISTINCT curso.idCurso as idc FROM docentedisciplina INNER JOIN  docente
                    ON docente.idDocente = docentedisciplina.idDocente INNER JOIN disciplina
                    ON disciplina.idDisciplina = docentedisciplina.idDisciplina INNER JOIN curso
                    ON curso.idCurso= docentedisciplina.idCurso

                 WHERE docentedisciplina.idDisciplina= '$disciplina'
                    AND docentedisciplina.idDocente = '$idDocente';";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idc'];
        }

        $db->closeDatabase();
    }

    public function estudanteQtdAvaliacaoDisp($idEstudante,$disciplina,$estado)
    {
        $db = new mySQLConnection();
        $query = "SELECT COUNT(tipoavaliacao.idTipoAvaliacao) AS qtd, tipoavaliacao.idTipoAvaliacao as tipo FROM tipoavaliacao
INNER JOIN pautanormal ON pautanormal.idTipoAvaliacao = tipoavaliacao.idTipoAvaliacao
INNER JOIN disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina
INNER JOIN estudante_nota ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal

WHERE disciplina.idDisciplina= '$disciplina' AND estudante_nota.idEstudante = '$idEstudante'
 AND pautanormal.estado= '$estado'
GROUP BY tipoavaliacao.descricao";

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)){ ;}
        return ($row);
        $db->closeDatabase();
    }

    /*Devolve um array com a lista de estudante, notas por disciplinas e tipo de avaliacao*/
    public  function listaNotaTesteAluno($idEstudante,$disciplina, $avaliacao){

        $db = new mySQLConnection();

        $query = "SELECT estudante_nota.idNota, tipoavaliacao.descricao, estudante_nota.nota , pautanormal.idPautaNormal as ptn,
                pautanormal.dataReg FROM tipoavaliacao INNER JOIN pautanormal
            ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
            ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
            ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
                    WHERE disciplina.idDisciplina= '$disciplina'  AND estudante_nota.idEstudante = '$idEstudante'
                         AND tipoavaliacao.idTipoAvaliacao = '$avaliacao'";

        $result = mysqli_query($db->openConection(),$query);
        while ($array[] = mysqli_fetch_assoc($result)){;}
        return ($array);

        $db->closeDatabase();
    }

    public function listar_tipo_avaliacao($disp, $curso, $av)
    {
        $query="SELECT DISTINCT tipoavaliacao.descricao, pautanormal.idPautaNormal as idNota FROM tipoavaliacao INNER JOIN pautanormal
            ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
            ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
            ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
            WHERE disciplina.idDisciplina= '$disp'  AND pautanormal.idcurso = '$curso'
   AND tipoavaliacao.idTipoAvaliacao = '$av'";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),$query);
        while ($array[] = mysqli_fetch_assoc($result)){;}
        return ($array);

        $db->closeDatabase();
    }

    public function obterEstudantesDisciplina($disp, $curso){

        return  (

        "SELECT DISTINCT estudante.nrEstudante as numero,estudante.idEstudante, estudante.nomeCompleto
                               FROM estudante
                              INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante=estudante.idEstudante
INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
INNER JOIN disciplina ON disciplina.idDisciplina = estudante_disciplina.iddisciplina
                               WHERE estudante_disciplina.idcurso = '$curso' AND estudante_disciplina.iddisciplina= '$disp' ORDER BY estudante.nomeCompleto ");
    }

    //	obtem o identificado do estado apartir numero mecanografico;

    public function getIdEstudante($nrmec){
        $db = new mySQLConnection();

        $query = "SELECT estudante.idEstudante as idEst FROM estudante
					WHERE estudante.nrEstudante = '$nrmec' ";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idEst'];
        }
        $db->closeDatabase();
    }

    /*---------------------------------------*/

    public function obterCursoEstudante($nrmec)
    {
        $db = new mySQLConnection();

        $query ="SELECT DISTINCT estudante_disciplina.idcurso as curso FROM estudante INNER JOIN estudante_disciplina
                              ON estudante_disciplina.idEstudante = estudante.idEstudante
                              WHERE estudante.nrEstudante = '$nrmec'";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['curso'];
        }
        $db->closeDatabase();
    }

    /*-----------Retorna o identificador do estudante apartir do nome e apelido recebido -------------*/

    public function getIdEstByNameApelido($fullname, $ctr){

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),
            "SELECT idEstudante  FROM estudante WHERE nomeCompleto ='$fullname'");
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idEstudante'];
        }
    }

    /**-----------Retorna a lista de tipos de avaliacao e suas respectivas quantidades--------------*/

    public function obterQtdAvaliacao($disciplina, $curso){
        $db = new mySQLConnection();

        $query = "SELECT  tipoavaliacao.idTipoAvaliacao as tipo, tipoavaliacao.descricao as descricao
                    FROM pautanormal INNER JOIN tipoavaliacao
                    ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao INNER JOIN  disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina
                    WHERE disciplina.idDisciplina = '$disciplina' AND pautanormal.idcurso= '$curso'
                GROUP BY tipoavaliacao.descricao;";

        $result = mysqli_query($db->openConection(), $query);
        while($row[] = mysqli_fetch_assoc($result)){;}
        return  ($row);
    }

    /*----------- permite obter a nota de um estudante apartir do idNota -------------------*/
    public function getEstNota($idNota){

        $db = new mySQLConnection();

        $query = "SELECT estudante_nota.nota FROM estudante_nota
					WHERE estudante_nota.idNota = '$idNota';";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['nota'];
        }else{
            return 0;
        }
    }

    // devolve o total de disciplna leccionado por um docente
    public function getCountDisp($curso, $docente){

        $this->db = new mySQLConnection();

        $this->query = "SELECT DISTINCT COUNT(*) as total from disciplina

                                                            INNER JOIN docentedisciplina on docentedisciplina.idDisciplina = disciplina.idDisciplina
                                                            INNER JOIN docente on docente.idDocente= docentedisciplina.idDocente
                                                            INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso
                                                                      WHERE curso.idCurso = '$curso' and docente.idDocente = '$docente'";
        $this->result = mysqli_query($this->db->openConection(),$this->query);
        if ($this->row = mysqli_fetch_assoc($this->result)){
            return ($this->row['total']);
        }else{
            return 0;
        }

        $this->db->closeDatabase();

    }

    /*This fuction return the especial the ID ofPautaNormal by passing tHE ID of nota table*/

    public function getIdPautaNormal($idNota){
        $db = new mySQLConnection();
        $query = "SELECT pautanormal.idPautaNormal FROM pautanormal INNER JOIN estudante_nota
					on pautanormal.idPautaNormal= estudante_nota.idPautaNormal
				  WHERE estudante_nota.idNota = '$idNota'";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idPautaNormal'];
        }else{
            return 0;
        }
    }


    public function getDoc_id($user){

        $db = new mySQLConnection();
        $query = "SELECT docente.idDocente as id FROM docente INNER JOIN utilizador
ON utilizador.id = docente.idUtilizador
                           WHERE utilizador.username LIKE '$user'";

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['id']);
        }else{
            return 0;
        }
    }

    public function getDoc_id_user($user){

        $db = new mySQLConnection();
        $query = "SELECT utilizador.id FROM utilizador  WHERE utilizador.username = '$user'";

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['id']);
        }else{
            return 0;
        }
    }

    public function getNomeCompleto($user,$ctr){

        $db = new mySQLConnection();

        if ($ctr == 0){

            $query ="SELECT nomeCompleto FROM docente  INNER JOIN utilizador ON utilizador.id= docente.idUtilizador
 WHERE utilizador.username = '$user'";

        }else{

            if ($ctr == 5){
                $query = "SELECT estudante.nomeCompleto FROM estudante where estudante.nrEstudante= '$user'";
            }else{
                $query = "SELECT estudante.nomeCompleto FROM estudante INNER JOIN utilizador ON utilizador.id= estudante.idUtilizador
                                                            WHERE utilizador.username= '$user'";
            }
        }
        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['nomeCompleto']);
        }else{
            return 0;
        }

    }

    public function queryAutoComplete($keyword, $curso, $disp){

        return ("SELECT DISTINCT nrEstudante as numero, nomeCompleto  FROM estudante
         INNER JOIN estudante_disciplina
                                  ON estudante_disciplina.idestudante = estudante.idEstudante
  WHERE estudante_disciplina.iddisciplina = '$disp' AND estudante_disciplina.idcurso = '$curso'
AND nomeCompleto LIKE '$keyword'");

    }

    public function getDisciplinaDocenteIdCurso($disp, $idDosc){
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), "SELECT DISTINCT docentedisciplina.idCurso FROM docentedisciplina
WHERE docentedisciplina.idDisciplina = '$disp' AND docentedisciplina.idDocente= '$idDosc'");
        if ($row = mysqli_fetch_assoc($result))
            return ($row['idCurso']);
    }

    public function testeAutocomplete($nrmec, $curso){


        return ("SELECT DISTINCT estudante.nrEstudante, estudante.nomeCompleto, estudante.idEstudante  FROM estudante
                     INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante

                                                   WHERE estudante_disciplina.idcurso = '$curso' AND estudante.nrEstudante = '$nrmec';");

    }

    public static function getAcessoEstudante($user){

        return ("SELECT  *
 FROM estudante INNER JOIN utilizador ON utilizador.id = estudante.idUtilizador
                                                  WHERE utilizador.username = '$user' ");
    }

    public static function getAcessoCoordenador($user){

        return ("SELECT * FROM docente INNER JOIN curso on
                                        curso.coordenador= docente.idDocente
                                        INNER JOIN utilizador ON utilizador.id = docente.idUtilizador
                              WHERE utilizador.username = '$user'");
    }

    public static function  getAcessoDocente($user){

        $query = "SELECT * FROM docente INNER JOIN utilizador
		ON utilizador.id = docente.idUtilizador
                                                  WHERE utilizador.username = '$user'";

        return $query;
    }

    public function getAcessoRegAcademico($user)
    {
        $ra = "RA";


        $query ="SELECT * FROM utilizador
                     WHERE utilizador.username = '$user' AND utilizador.categoria='$ra'";

        return $query;
    }

    public function decideUserLogin ($user, $ctr){
        $this->db = new mySQLConnection();

        //  row['username'] eh o endereco electronico de cada utilizador
        switch($ctr){
            case 1:

                $this->result = mysqli_query($this->db->openConection(), self::getAcessoEstudante($user));
                while($this->row = mysqli_fetch_assoc($this->result)){
                    self::$item = $this->row['username'];
                }break;
            case 2:
                $this->result = mysqli_query($this->db->openConection(), self::getAcessoDocente($user));

                while($this->row = mysqli_fetch_assoc($this->result)){
                    self::$item = $this->row['username'];
                }break;

            case 3:
                $this->result = mysqli_query($this->db->openConection(), self::getAcessoCoordenador($user));
                while($this->row = mysqli_fetch_assoc($this->result)){
                    self::$item = $this->row['username'];
                } break;


            case 4:
                $this->result = mysqli_query($this->db->openConection(),               self::getAcessoRegAcademico($user));
                while($this->row = mysqli_fetch_assoc($this->result)){
                    self::$item = $this->row['username'];
                };

        }
        return(self::$item);

        $this->db->closeDatabase();
    }

    public function getCountEstd($disciplina){

        $this->db = new mySQLConnection();
        $this->query= "SELECT COUNT(DISTINCT estudante.nrEstudante) as conta FROM estudante
                                        INNER JOIN estudante_disciplina ON estudante.idEstudante = estudante_disciplina.idestudante
                              WHERE estudante_disciplina.iddisciplina = '$disciplina'";

        $this->result = mysqli_query($this->db->openConection(),$this->query);
        if ($this->row = mysqli_fetch_assoc($this->result)){
            echo $this->row['conta'];
        }
        $this->db->closeDatabase();
    }

    //Permite oque se obtenh o identificador da pauta normal e sera usado para insercao de pauta de recorrencia;
    public function obterIdPautaNormal($idestudante, $disciplina){

        $db = new mySQLConnection();

        $query = "SELECT DISTINCT pautanormal.idPautaNormal as idp FROM pautanormal INNER JOIN disciplina
							ON disciplina.idDisciplina = pautanormal.idDisciplina INNER JOIN estudante_nota
							ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN estudante
							ON estudante.idEstudante = estudante_nota.idEstudante

							WHERE estudante.idEstudante= '$idestudante' AND
								  disciplina.idDisciplina = '$disciplina';";
        $result = mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){
            return $row['idp'];
        }else{
            return 0;
        }

    }

    public function seletMaxIndex()
    {
        $db = new mySQLConnection();

        $query = "SELECT MAX(planoavaliacao.idPlanoAvalicacao) as max FROM planoavaliacao;";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return ($row['max']);
        }
    }

    public function listarPlanoActual($max)
    {


        return ("SELECT  planoavaliacao.idplano, disciplina.idDisciplina, disciplina.descricao,tipoavaliacao.descricao as tipo,tipoavaliacao.idTipoAvaliacao as av,
	        planoavaliacao.peso, planoavaliacao.qtdMaxAvaliacao as qtd
	      FROM planoavaliacao INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = planoavaliacao.idTipoAvaliacao
                INNER JOIN disciplina ON disciplina.idDisciplina = planoavaliacao.idDisciplina
                    WHERE planoavaliacao.idplano > '$max'");
    }


    public function idDocenteNome($nome)
    {

        $db = new mySQLConnection();

        $query = "SELECT docente.idDocente FROM docente WHERE nomeCompleto = '$nome'";
        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idDocente'];
        }
        $db->closeDatabase();
    }

    public function getNome_from_ra($texto)
    {
        $query ="SELECT username FROM utilizador WHERE username LIKE '$texto'";
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['username'];
        }
        $db->closeDatabase();

    }

    public function disp_docente_json($linha){

        return ("SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao
                                from disciplina INNER JOIN docentedisciplina
                                ON docentedisciplina.idDisciplina = disciplina.idDisciplina INNER JOIN
                                docente ON docente.idDocente = docentedisciplina.idDocente WHERE
                                docente.idDocente = '$linha'");
    }

    public function listaDocentesDisciplina($idDisp)
    {
        return ("SELECT DISTINCT docente.idDocente, docente.nomeCompleto FROM docente INNER JOIN docentedisciplina
    ON docente.idDocente = docentedisciplina.idDocente INNER JOIN disciplina
    ON disciplina.idDisciplina = docentedisciplina.idDisciplina WHERE disciplina.idDisciplina='$idDisp' ");

    }

    public function listDisciplinasDoente($idDoc)
    {


        return ("SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao from disciplina INNER JOIN docentedisciplina
            ON docentedisciplina.idDisciplina = disciplina.idDisciplina INNER JOIN
            docente ON docente.idDocente = docentedisciplina.idDocente WHERE
            docente.idDocente ='$idDoc'");


    }

    public function recuperar_senha($email,$fullname, $ctr)
    {

        if ($ctr == 1){

            $query ="SELECT utilizador.password FROM utilizador INNER JOIN docente
ON docente.idUtilizador = utilizador.id
                  WHERE utilizador.username ='$email'
                  AND docente.nomeCompleto ='$fullname'"; // acesso a dados docente

        }


        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){

            return ('Senha: '.$row['password']);
        }else{
            return -1;
        }

        $db->closeDatabase();
    }

    public function queryMaster($idcurso)
    {
        $db = new mySQLConnection();

        $query = "SELECT descricao from curso where idCurso= '$idcurso'";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['descricao'];
        }
        $db->closeDatabase();
    }

    public function contarAvaliacoesRealizadas($avaliacao, $disciplina,$curso, $docente){

        $query = "
            SELECT COUNT(DISTINCT estudante_nota.idPautaNormal) as conta, pautanormal.idDisciplina
                  FROM pautanormal INNER JOIN estudante_nota
                    ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina INNER JOIN docentedisciplina
                    ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                    WHERE docentedisciplina.idDocente = '$docente' AND disciplina.idDisciplina = '$disciplina'
                     and pautanormal.idTipoAvaliacao = '$avaliacao' AND docentedisciplina.idCurso = '$curso'";

        $consulta = "SELECT  DISTINCT qtdMaxAvaliacao as maximo from planoavaliacao INNER JOIN disciplina
                        ON planoavaliacao.idDisciplina = disciplina.idDisciplina INNER JOIN docentedisciplina
                        ON docentedisciplina.idDisciplina = disciplina.idDisciplina

                        WHERE docentedisciplina.idDocente = '$docente' AND docentedisciplina.idCurso = '$curso'
                        and planoavaliacao.idTipoAvaliacao = '$avaliacao' and planoavaliacao.idDisciplina = '$disciplina'";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),$query);
        $row = mysqli_fetch_assoc($result);
        $valores = mysqli_query($db->openConection(),$consulta);
        $qtd = mysqli_fetch_assoc($valores);

        if($qtd['maximo'] ==0 && $row['conta'] ==0){
            echo "Carro docente registar plano de avaliacao primeiro";
        }else{

            return ($qtd['maximo'] - $row['conta']);
        }

        $db->closeDatabase();

    }

    public function checkExameNormalRec($tipo, $disp, $ctr){

        if ($ctr == 0 ){
            $query = "SELECT COUNT(pautanormal.idTipoAvaliacao) as tipo FROM pautanormal
				 WHERE pautanormal.idTipoAvaliacao = '$tipo' AND pautanormal.idDisciplina = '$disp'";
        }else{

            $query = "SELECT COUNT(pautanormal.idTipoAvaliacao) as tipo FROM pautanormal
				 WHERE pautanormal.idTipoAvaliacao = '$tipo'  AND pautanormal.idDisciplina = '$disp'";
        }

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row= mysqli_fetch_assoc($result)){
            return ($row['tipo']);
        }
    }
    public function allAvaliacaoDocenteDisp($docente, $disciplina)
    {
        $query ="SELECT  COUNT(DISTINCT estudante_nota.idPautaNormal) as conta, pautanormal.idDisciplina
                    FROM pautanormal INNER JOIN estudante_nota
                    ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina INNER JOIN docentedisciplina
                    ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                    WHERE docentedisciplina.idDocente = '$docente' AND disciplina.idDisciplina = '$disciplina'";
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['conta']);
        }

        $db->closeDatabase();
    }

    public function find_estudante_docente($username, $ctr){
        if ($ctr == 0){

            $query = "SELECT nomeCompleto, nrEstudante as numero, idEstudante FROM estudante
                    WHERE  username='$username' AND nrEstudante = 'password'";

        }else{
            $query = "SELECT username, password, idDocente, email,nomeCompleto  FROM docente
                      WHERE email = '$username'";
        }

        return ($query);

    }


    public function docenteCursoDisciplina($id)
    {
        return ("SELECT DISTINCT curso.idCurso, curso.descricao FROM curso
          INNER JOIN docentedisciplina ON docentedisciplina.idCurso = curso.idCurso
          INNER JOIN docente ON docente.idDocente = docentedisciplina.idDocente
          WHERE docente.idDocente = '$id'");

    }

    public function contaDisciplina($idDisp, $doc)
    {
        $query="  SELECT COUNT(docentedisciplina.idDisciplina) as conta, docentedisciplina.idDisciplina  FROM docentedisciplina
          WHERE idDisciplina = '$idDisp' AND docentedisciplina.idDocente = '$doc'";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row= mysqli_fetch_assoc($result)){
            return ($row['conta']);
        }
    }


    public function get_creditos_ano($disp, $ctr) {

        if($ctr == 0){

            $query = "SELECT ano as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
        }else{
            $query ="SELECT creditos as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
        }
        $db = new mySQLConnection();

        $result= mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){

            return ($row['valor']);
        }
    }


    public function check_publicacao ($idpauta){

        $query = "SELECT pautanormal.estado FROM pautanormal
				  WHERE pautanormal.idPautaNormal = '$idpauta'";

        $db = new mySQLConnection();

        $result= mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){

            return ($row['estado']);
        }

    }

    public function email_docente ($fullname){

        $query = "SELECT utilizador.username as email from docente INNER JOIN utilizador
		        ON docente.idUtilizador = utilizador.id
				WHERE docente.nomeCompleto = '$fullname'";

        $db = new mySQLConnection();

        $result= mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){

            return ($row['email']);
        }

    }


    public function return_dif_data($pauta,$ctr)
    {
        if ($ctr == 0 ){
            $query ="SELECT DATEDIFF(NOW(), pautanormal.dataReg) as dif FROM pautanormal
WHERE pautanormal.idPautaNormal = '$pauta'";
        }else{
            $query ="SELECT pautanormal.idDisciplina as dif FROM pautanormal
WHERE pautanormal.idPautaNormal = '$pauta'";
        }

        $db = new mySQLConnection();
        $rs = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($rs)) {
            return ($row['dif']);
        }
    }

    public function obterPautaNormal($idnota)
    {
        $query ="SELECT pautanormal.idPautaNormal as ptn FROM pautanormal INNER JOIN estudante_nota
ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
WHERE estudante_nota.idNota = '$idnota'";
        $db = new mySQLConnection();

        $rs = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($rs)) {
            return ($row['ptn']);
        }
    }

    public function mostrar_nome_estudante($idnota)
    {
        $query ='SELECT nomeCompleto as fullname
			FROM estudante INNER JOIN estudante_nota
				ON estudante.idEstudante = estudante_nota.idEstudante
					WHERE estudante_nota.idNota = '.$idnota;

        $db = new mySQLConnection();

        $rs = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($rs)) {
            return ($row['fullname']);
        }
    }

    public function disciplinas_plano($docente)
    {
        return "SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao FROM disciplina INNER JOIN
	docentedisciplina ON docentedisciplina.idDisciplina= disciplina.idDisciplina
	INNER JOIN planoavaliacao ON planoavaliacao.idDisciplina = disciplina.idDisciplina
	WHERE docentedisciplina.idDocente = '$docente'";

    }

    public function datalhes_disciplina($disp, $doc)
    {
        $query ="SELECT curso.descricao, disciplina.descricao as disp, faculdade.descricao as facul, disciplina.ano, disciplina.creditos FROM disciplina
			INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
			INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso INNER JOIN faculdade  ON faculdade.idFaculdade = curso.idFaculdade
 WHERE disciplina.idDisciplina = '$disp'
			 AND docentedisciplina.idDocente = '$doc'";

        $db = $db = new mySQLConnection();

        $t=0; $temp="";  $curso ="";  $init ="Leccionada na ";

        $result = mysqli_query($db->openConection(), $query);
        while ($row = mysqli_fetch_assoc($result)){

            $temp.=$row['descricao'].' ,  ';

            if ($t== 0){
                $curso.=$row['ano'].'º Ano';//e com '.$row['creditos'].' Creditos Academicos.';

            }else {  $temp.="  " ;}

            $t++;
        }


        return $init.''.$temp.' '.$curso;

    }


}

?>
