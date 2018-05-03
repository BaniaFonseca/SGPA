<?php
 
 require_once 'Docente.class.php';
 require_once 'Curso.class.php';
 
 class DocenteCurso {
    
    private $semestre;
    private $curso;
    private $docente;

   

    public function c_DocenteCurso($idDocente, $idCurso) {
        $this->curso =$idCurso;
        $this->docente=$idDocente;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function getDocente() {
        return $this->docente;
    }

    public function setDocente($docente) {
        $this->docente = $docente;
    }

    public function toString() {
        return "esimop.DocenteCurso[ docenteCursoPK=" + $this->docenteCursoPK + " ]";
    }
}
    
?>