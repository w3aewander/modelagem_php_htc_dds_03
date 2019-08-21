<?php
/** 
 * 
 */
require   "./vendor/autoload.php";

use \Model\Aluno;
use \Model\Turma;

$turma = new Turma();

$turma->setId(2);
$turma->setNome("HTC-DDS-03");

echo "<h2>{$turma->getNome()}</h2>";

$aluno = new Aluno();
$aluno->setId(10);
$aluno->setNome("Wanderlei Silva");
$aluno->setTurmaId(1);

echo "Nome do aluno: " . $aluno->getNome() . "<br>";

$aluno2 = new Aluno();
$aluno2->setId(20);
$aluno2->setNome("Alguém da Silva");
$aluno2->setTurmaId(1);

printf( "<h2>Nome do Aluno</h2><p>%s</p>", $aluno2->getNome() );    

$turma = new Turma();
$turma->setId(1010);
$turma->setNome("HTC - Os melhores alunos do SENAI noturno.");

printf("<h2>Informações da turma</h1>
        <p>
          ID da Turma: %d <br>
          Nome da turma: <font color='red'>%s</font> 
        </p>",
        $turma->getId(),
        $turma->getNome()
);