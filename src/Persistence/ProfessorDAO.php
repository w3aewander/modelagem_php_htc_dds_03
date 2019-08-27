<?php
/**
 * Persistence: ProfessorDAO
 */

namespace Persistence;

use \Persistence\Connection as CON;

class ProfessorDAO
{

 public static function salvar(\Model\Professor $professor):bool
 {

  try {
   $sql = "insert into PROFESSOR(nome) values (:nome) ";
   $stm = CON::connect()->prepare($sql);
   $stm->bindValue(":nome", $professor->nome);

   $stm->execute();

   return true;

  } catch (Exception $ex) {
   print($ex->getMessage());
   return false;
  }
 }

 public static function pesquisar(int $id):\Model\Professor
 {

  $sql = "select * from PROFESSOR where id = :id ";
  $stm = CON::connect()->prepare($sql);
  $stm->bindParam(':id', $id);
  $stm->execute();

  $res = $stm->fetch(\PDO::FETCH_OBJ);

  $professor = new \Model\Professor();
  $professor->setId($res->id);
  $professor->setNome($res->nome);

  return $professor;
 }

 /**
  * Listar professores
  * @param none
  * @return array \Model\Professor
  */
 public static function listar(): array
 {
  $sql = "select * from PROFESSOR";

  $res = CON::connect()->query($sql);

  $arr_professor = [];
  $rows = $res->fetchAll(\PDO::FETCH_BOTH);

  foreach ( $rows as $row):
   //instancia um novo professor
   $professor = new \Model\Professor();
   $professor->setId($row->id);
   $professor->setNome($row->nome);

   //inclui o objeto no array - lista
   $arr_professor[] = $professor;

  endforeach;

  return $arr_professor;

 }

 /**
  * Lista todas as turmas para o professor.
  * @param int $professor_id
  */
 public static function getTurmas(int $professor_id): array
 {

  $sql = "select t.id  turma_id, t.nome turma_nome  from TURMA  t
                    inner join PROFESSOR_TURMA p
                    on p.turma_id=t.id
                    where p.professor_id = :id";

  $stm = CON::connect()->prepare($sql);

  $stm->bindParam(":id", $professor_id);
  $stm->execute();

  $rows = $stm->fetchAll(\PDO::FETCH_OBJ);
  
  $arr_turmas = [];

  foreach ($rows as $row ):
   $turma = new \Model\Turma();
   $turma->setId($row->turma_id);
   $turma->setNome($row->turma_nome);

   //array_push($arr_turmas,$turma);
   $arr_turmas[] = $turma;

  endforeach;


  return $arr_turmas;

 }

 /**
  * Obtem as disciplinas que o professor leciona
  * @param int $professor_id
  * @return array \Model\Disciplina
  */
 public static function getDisciplinas(int $professor_id):array
 {
  $sql = "select d.id disciplina_id, d.nome disciplina_nome  from DISCIPLINA  d
                inner join PROFESSOR_DISCIPLINA p
                on p.disciplina_id=d.id
                where p.professor_id = :id";

  $stm = CON::connect()->prepare($sql);

  $stm->bindParam(":id", $professor_id);
  $stm->execute();

  $arr_disciplinas = [];

  while($row = $stm->fetch(\PDO::FETCH_OBJ) ):
    
   $disciplina = new \Model\Disciplina();
   $disciplina->setId($row->disciplina_id);
   $disciplina->setNome($row->disciplina_nome);
   
   $arr_disciplinas[] = $disciplina;

  endwhile;

  return $arr_disciplinas;

 }

}