<?php
/**
 * Master detail
 */

$action = $_REQUEST['action'] ?? 'listar';
$id = $_REQUEST['id'] ?? 0;

if ( $id ):
 $nome = \Persistence\ProfessorDAO::pesquisar($id)->getNome() ?? "";
endif;

switch($action):
  case 'salvar':
     $professor = new \Model\Professor();
     $professor->setId($id);
     $professor->setNome($nome);

     \Persistence\ProfessorDAO::salvar($professor);

  break;

  case 'excluir':
     \Persistence\ProfessorDAO::excluir($id);
  break;

  case 'editar':
    $nome = \Persistence\ProfessorDAO::pesquisar($id)->getNome();
  break;

endswitch;

?>

<div class="container">
    <form action="#" method="post">
        <label for="id">ID</label>
        <input type="number" id="id" name="id" value="<?=$id?>" size="5" maxlength="5" required="required">
        <br>
        <label for="id">Nome</label>
        <input type="text" id="nome" name="nome" value="<?=$nome ?? '' ?>" size="50" maxlength="50" required="required">
        <button type="reset" name="action" value="listar">Nome</button>
        <button type="submit" name="action" value="salvar">Salvar</button>
    </form>
   
    <label for="cbxturmas">Turmas</label>
    <select id="turmas" name="turmas" class="cbxturmas" size="5">
        <?php 
           $turmas = \Persistence\ProfessorDAO::getTurmas($id);
          foreach( $turmas  as $turma):
             echo "<option value='{$turma->getId()}'>{$turma->getNome()}</option>";
          endforeach;
          ?>
    </select>  

    <label for="cbxturmas">Disciplinas</label>
    <select id="disciplinas" name="disciplinas" class="cbxdisciplinas" size="5">
        <?php 
           $disciplinas = \Persistence\ProfessorDAO::getDisciplinas($id);
          foreach( $disciplinas  as $disciplina):
             echo "<option value='{$disciplina->getId()}'>{$disciplina->getNome()}</option>";
          endforeach;
          ?>
    </select>  

    <div class="d-block p-2">Páginas: <?=\Utils\Paginate::getLinks("PROFESSOR")?></div>
    <div class="d-block"><?=\Utils\GenerateTable::generate("PROFESSOR")?></div>

</div>