<?php

   require_once('../functions/Conexao.php');
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');

   require_once('../controller/QueryControllerEstudante.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/PublicacaoQueryController.php');

   require_once('../controller/SexoController.php');
   require_once('../controller/QueryController.php');
   require_once('../controller/QueryControllerEstudante.php');

   $ctr_est = new SqlQueryEstudante();
   $query = new QuerySql();
?>

<?php

    class PautaFrequencia {

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


          /*
           *
           * Permite obter a media de frequencia para admissao ao exame normal e de exame de recorrencia;
           * */

        public function obterMediaFrequecia($disciplina, $aluno, $estado,$curso, $ctr)
        {

            $db = new mySQLConnection();
            //$intenal = new PautaFrequencia();

            $query = "SELECT DISTINCT AVG(estudante_nota.nota) as media, disciplina.idDisciplina,
                        tipoavaliacao.descricao, tipoavaliacao.idTipoAvaliacao as tipo from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
INNER JOIN estudante_disciplina ON estudante_disciplina.iddisciplina = disciplina.idDisciplina

                        INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                        INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disciplina' AND estudante_nota.idEstudante = '$aluno'
                        AND pautanormal.estado= '$estado' AND pautanormal.idcurso= '$curso'";

            if ($ctr == 0){
                $query.="AND tipoavaliacao.idTipoAvaliacao < 4
                            GROUP BY tipoavaliacao.descricao;";
            }else{
                $query.="AND tipoavaliacao.idTipoAvaliacao >= 4
                            GROUP BY tipoavaliacao.descricao;";
            }
             $result = mysqli_query($db->openConection(), $query);

             if (mysqli_num_rows($result) > 0){
                 $soma =0;

                 while ($row = mysqli_fetch_assoc($result)) {

                     $ppeso = self::returnPesoAvaliacao($disciplina, $row['tipo'])/100;

                     $soma = $soma+ ($row['media']*$ppeso);
                 }
                return (round($soma));
            }else{
                return 'Sem Notas Completas';
            }

        }

        public function getNotaExame($disciplina, $aluno, $estado,$curso, $ctr)
        {
                $db = new mySQLConnection();

                $query = "SELECT DISTINCT  estudante_nota.nota,tipoavaliacao.descricao from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                        INNER JOIN estudante_disciplina ON estudante_disciplina.iddisciplina = disciplina.idDisciplina

                        INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                        INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disciplina' AND estudante_nota.idEstudante = '$aluno'
                        AND pautanormal.estado= '$estado' AND pautanormal.idcurso= '$curso'";

               if ($ctr == 0){

                   $query.= "AND tipoavaliacao.idTipoAvaliacao = 4";

               }else{
                   $query.="AND tipoavaliacao.idTipoAvaliacao = 5";

               }

                $result = mysqli_query($db->openConection(), $query);

                 if ($row = mysqli_fetch_assoc($result)) {

                   if ($ctr_est->returnMediaEstudante($aluno, $disciplina, $curso) < 16
                    || $ctr_est->validar_busca_recorrencia($aluno, $disciplina, $curso, 5) < 10){

                          return ($row['nota']);
                   }
               }

        }
        public function getMecaEstudante($id)
        {
             $link =new mySQLConnection();

             $result = mysqli_query($link->openConection(), "SELECT nrEstudante FROM estudante
                                                                WHERE estudante.idEstudante = '$id';");
             if ($row = mysqli_fetch_assoc($result)) {
                return ($row['nrEstudante']);
             }

        }

        public function getnomeDisp($id)
        {
             $link =new mySQLConnection();

             $result = mysqli_query($link->openConection(), "SELECT  descricao FROM disciplina
                                                                WHERE idDisciplina = '$id';");
             if ($row = mysqli_fetch_assoc($result)) {
                return ($row['descricao']);
             }

        }

        public function ordenacaoTestes($disciplina, $aluno, $estado,$curso, $ctr)
        {

            $query = " SELECT DISTINCT  tipoavaliacao.idTipoAvaliacao as tipo,estudante_nota.nota,
                       tipoavaliacao.descricao from estudante_nota
INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao
WHERE estudante_nota.idEstudante = '$aluno' and pautanormal.idDisciplina= '$disciplina' AND pautanormal.idcurso = '$curso'";

             if ($ctr == 0){

                 $query.= "AND tipoavaliacao.idTipoAvaliacao < 4 ORDER BY pautanormal.dataReg";
             }else{

                 $query.= " AND tipoavaliacao.idTipoAvaliacao >= 4 ORDER BY pautanormal.dataReg";
             }
              return ($query);
        }

        public function obterAlunoCurso($displina, $curso)
        {
                return("SELECT
                    SELECT estudante.nrEstudante,
                    estudante.nomeCompleto,
                    estudante_disciplina.dataReg,
                    estudante.idEstudante,
                    curso.descricao
                    FROM
                    estudante INNER JOIN estudante_disciplina
                                                                                                    ON estudante_disciplina.idestudante = estudante.idEstudante
                    INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
INNER JOIN disciplina ON disciplina.idDisciplina = estudante_disciplina.iddisciplina
                    WHERE estudante_disciplina.iddisciplina = '$disciplina'
AND estudante_disciplina.idcurso='$curso'");
        }

        public function returnPesoAvaliacao($disp, $avaliacao)
        {
                $query =" SELECT planoavaliacao.peso FROM planoavaliacao
                      WHERE planoavaliacao.idDisciplina = '$disp' AND planoavaliacao.idTipoAvaliacao = '$avaliacao'";
                 $link =new mySQLConnection();

             $result = mysqli_query($link->openConection(), $query);
             if ($row = mysqli_fetch_assoc($result)) {
                return ($row['peso']);
             }
        }

}


 ?>