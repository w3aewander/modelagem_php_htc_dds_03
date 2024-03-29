<?php
/** 
 * 
 */

 ini_set("display_errors",1);
 error_reporting(E_ALL|E_WARNING);

require  __DIR__ . "/../vendor/autoload.php";


use \Model\Aluno;
use \Model\Turma;
use \Persistence\Connection as Con;

$result = [];

if (isset($_POST['nome'])){

  $pdo = Con::connect();
  $nome = $_POST['nome'];
  
  
  $sql = " select * from VIEW_PROFESSOR_DISCIPLINA ";
  //$sql .= " where Professor like :nome ";   --busca exata
  $sql .= " where Professor like :nome ";  //busca aproximada.
  $stm = $pdo->prepare($sql);

  $nome = $nome."%";

  $stm->bindParam(":nome", $nome);

  $stm->execute();

  $result = $stm->fetchAll();

}

  $table = '<h1 align="center">Listagem de Professores e suas Disciplinas</h1>';
  $table .= '<div style="padding: 8px;display: block;margin:0 auto;text-align: center;">';
  $table .= '<a style="padding: 2px;margin:2px;"  href="turma.php">Cadastro de Turma</a> |';
  $table .= '<a style="padding: 2px;margin:2px;"  href="disciplina.php">Cadastro de Disciplina</a> |';
  $table .= '<a style="padding: 2px;margin:2px;"  href="professor.php">Cadastro de Professor</a> |';
  $table .= '<a style="padding: 2px;margin:2px;"  href="alunos.php">Cadastro de Aluno </a>';
  $table .= '</div>';

  echo "
        <div  style='margin:50px auto;width: 800px'> 
        <form action='#' method='post'> 
        <label style='font-size: 1.4em;'>Pesquisar professor:</label>
        <input 
               style='font-size: 1.5em' 
               type='search' 
               name='nome' 
               id='nome' 
               size='50'
               placeholder='digite o nome para pesquisa'>
        <hr>
        <button type='submit'>Pesquisar</button>
        </form>
        </div>";
  
  $table .= "<table cellspacing='5' cellpadding='5' align='center' style='padding: 30px;width: 800px;' border='1' rules='all'>
              <thead style='background-color: blue;color: white;'>
                 <tr style='padding:4px;'>
                    <th>Professor</th>
                    <th>Disciplina</th>
                 </tr>
              </thead>
              <tbody>";
  
  foreach( $result as $row){
  
       $table .= "<tr>
                  <td>{$row["Professor"]}</td>
                  <td>{$row["Disciplina"]}</td> 
                  </tr>";
  }
  
  $table .= "</tbody></table>";
  
  echo $table;
  

//$sql = "select * from VIEW_PROFESSOR_DISCIPLINA";
//$result = $pdo->query($sql);



/*
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
*/