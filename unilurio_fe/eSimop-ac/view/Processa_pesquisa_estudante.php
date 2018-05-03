<?php

   session_start();

   require_once('../controller/PublicacaoQueryController.php');
   require_once("../functions/Conexao.php");
   require_once('../controller/EstudanteNotaController.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/QueryController.php');

   require_once('../controller/QueryControllerEstudante.php');
   require_once('../controller/PautaNormalController.php');
   require_once('../controller/PublicacaoQueryController.php');
   require_once('../controller/DocenteController.php');
   require_once('../../PHPMailer/class.phpmailer.php');

   $query = new QuerySql();
   $ctr_est = new SqlQueryEstudante();
   $docente = new DocenteController();
   $idDoc = $query->getDoc_id($_SESSION['username'],$_SESSION['password']);

?>

<?php

    $acao = $_POST['acao'];

    switch ($acao) {
        case 1:
break;
}
