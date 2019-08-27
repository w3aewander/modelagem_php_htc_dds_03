<?php
/**
 * Persitence: AlunoDAO
 */

 namespace Persistence;

 use \Persistence\Connection as CON;

 class AlunoDAO  {

    /**
     * Retorna a turma que o aluno pertence;
     * @param int $aluno_id ID do aluno
     * @return string 
     */
    public static function getTurma(int $aluno_id) : \Model\Turma {

      $sql = 'select a.nome aluno_nome,
              a.id aluno_id, 
              t.id  turma_id, 
              t.nome turma_nome 
              from ALUNOS a INNER JOIN TURMA t
              on a.turma_id = t.id 
              and a.id = :aluno_id';

      $stm = CON::connect()->prepare($sql);
      $stm->bindParam(':aluno_id',$aluno_id);
     
      $stm->execute(); 

      $res = $$stm->fetch(\PDO::FETCH_OBJ);

      $turma = new \Model\Turma();
      $turma>setId($res->turma_id);
      $turma->setNome($res->turma_nome);
      
      return $turma;
    }
 }