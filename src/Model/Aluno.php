<?php
/**
 * Classe Aluno
 *
 */

namespace Model;

class Aluno
{
 private $id;
 private $nome;
 private $turma_id;

 /**
  * Método construtor da classe aluno com os valores padrão dos atributos
  * @param int $id
  * @param string $nome
  * @param int $turma_id
  * @return void none
  */
 public function __construct(int $id=0, string $nome="", int $turma_id=0 )
 {
     $this->id = $id;
     $this->nome = $nome;
     $this->turma_id = $turma_id;
 }

 /**
  * Obtém o id do aluno
  * @param none
  * @return int $id 
  */
 public function getId()
 {
  return $this->id;
 }

 /**
  * Seta o id do aluno
  * @param int $id 
  * @return void none
  */
 public function setId(int $id)
 {
  $this->id = $id;
 }

 /**
  * Obtém o nome do aluno
  * @param none
  * @return string $nome
  */
 public function getNome()
 {
  return $this->nome;
 }
 
 /**
  * Seta o nome do aluno
  * @param string $nome
  * @return void none
  */
 public function setNome(string $nome)
 {
  $this->nome = $nome;
 }

 /**
  * Obtém o id da turma que aluno pertence
  * @param void none
  * @return int $turma_id 'id da classe Turma'
  */
 public function getTurmaId()
 {
  return $this->turma_id;
 }

 /**
  * Seta o id da turma que o aluno pertence
  * @param int $turma_id
  * @return void none
  */
 public function setTurmaId(int $turma_id)
 {
     $this->turma_id = $turma_id;
     
 }
}
