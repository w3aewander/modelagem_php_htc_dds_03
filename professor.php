<?php
/**
 * Professor
 */

require './vendor/autoload.php';

$disciplinas = \Persistence\ProfessorDAO::getDisciplinas(1) ;

foreach ( $disciplinas as $disciplina):
       echo $disciplina->getNome();
endforeach;