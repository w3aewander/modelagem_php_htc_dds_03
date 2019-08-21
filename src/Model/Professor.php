<?php
/**
 * Model Professor
 */

 namespace Model;

 class Professor {

     private $id;
     private $nome;

     /**
      * Get the value of id
      */ 
     public function getId()
     {
          return $this->id;
     }

     /**
      * Set the value of id
      *
      * @return  self
      */ 
     public function setId(int $id)
     {
          $this->id = $id;

          return $this;
     }

     /**
      * Get the value of nome
      */ 
     public function getNome()
     {
          return $this->nome;
     }

     /**
      * Set the value of nome
      *
      * @return  self
      */ 
     public function setNome(string $nome)
     {
          $this->nome = $nome;

          return $this;
     }
 }