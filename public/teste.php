<?php
/**
 * 
 * 
 */

 require __DIR__ . "/../config/config.php";
 require __DIR__ . "/../vendor/autoload.php";

 $professor_disciplinas = \Persistence\ProfessorDAO::getDisciplinas(2);

 print_r($professor_disciplinas);
