<?php
/**
 * Script: alunos.inc.php
 */

if ( isset( $_REQUEST['action'] ) && !empty( $_REQUEST['action'] ) ):  //sintaxe alternativa do php

$action = $_REQUEST['action'];
$id = intval($_REQUEST['id']);

switch( $action ):
    
    case 'salvar':
      
      $aluno = new \Model\Aluno();
      $aluno->setId($_POST['id']);
      $aluno->setNome(strtoupper($_POST['nome']));
      $aluno->setTurmaId($_POST['turma_id']);
      
      salvar($aluno);

    break;

    case 'excluir':
        excluir($id);
    break;
endswitch;

endif;


function pesquisar(int $id){

$ret = null;

//pesquisa o registro no banco
$sql = "select * from aluno where id = :id ";
$stm = CON::connect()->prepare($sql);
$stm->bindParam(':id', $id );
$stm->execute();

$ret = $stm->fetch();

return $ret;

}

function salvar(\Model\aluno $aluno){

    $stm = null;

    //die("ID: " . $aluno->getId());
    if ( pesquisar( $aluno->getId() ) ):

    $sql = "update ALUNOS set nome = :nome, turma_id = :turma_id where id = :id"  ;
    $stm = CON::connect()->prepare($sql);
    $stm->bindValue(':id', $aluno->getId(), \PDO::PARAM_INT);
    $stm->bindValue(':nome', $aluno->getNome(), \PDO::PARAM_STR);
    $stm->bindValue(':turma_id', $aluno->getTurmaId(), \PDO::PARAM_STR);

    $stm->execute();   
    
   else:

    //die(var_dump($aluno->getNome()));        //se não existir insira
    $sql = "insert into ALUNOS( nome,turma_id ) values ( :nome,:turma_id )";
    $stm = CON::connect()->prepare($sql);

    $stm->bindValue(':nome', $aluno->getNome());
    $stm->bindValue(':turma_id', $aluno->getTurmaId()) ;

    $stm->execute();
    
   endif;

}


function excluir(int $id){

$sql = 'delete from ALUNOS where id = :id';
$stm = CON::connect()->prepare($sql);
$stm->bindValue(':id', $id, \PDO::PARAM_INT );

$stm->execute();

}

function turmas(){
$sql = 'select * from TURMA';
$res = CON::connect()->query($sql);
return $res->fetchAll();
}

?>

<div style="margin: 0 auto; width:80%">
        <header>
            <h2 style="padding: 4px;margin:0 auto;background-color: lightblue; text-align:center;">Cadastro de alunos</h2>
            <p align="center">
                <a class="btn-voltar" href="index.php">Voltar</a>
            </p>
            <p>
                <form name="form_aluno" id="form_aluno" method="post" action="alunos.php">
                    <label for="id">ID</label>
                    <input type="number" id="id" value="<?=$_REQUEST['id']??'0'?>" name="id" value="0" readonly="readonly" />
                    <br>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" value="<?=$_REQUEST['nome']??''?>" size="50" maxlength="50" required="required">
                    <br>
                    <label for="turma_id">Turma</label>
                    <select id="turma_id" name="turma_id">
                         <option selected value="">Selecione uma turma</option>
                         
                         <?php foreach( turmas() as $turma): ?>
                              <option value="<?=$turma['id']?>">
                                  <?=$turma['nome'];?>
                             </option>
                         <?php endforeach; ?>

                    </select>

                    <button type="reset" onclick="limparForm();">Novo</button>
                    <button type="submit" name="action" value="salvar">Salvar</button>
                </form>
            </p>
        </header>
        <article>



            
        <h4><?=!empty( $_REQUEST['mensagem']) ?? null?></h4>

<?php
  
  $pagina = $_REQUEST['pagina'] ?? 1;
  $offset = ($pagina -1 ) *  $registros_por_pagina  ;
  
  $alunos = \Persistence\AlunoDAO::listar($offset);
  
  echo Utils\Paginate::getLinks('ALUNOS');

  ?>


<table width="100%" border="1" cellpadding="5" cellspacing="4" rules="both">
   <caption>.:: Listagem de alunos ::..</caption>

   <thead>
       <tr>
           <th width="30">ID</th>
           <th>Nome</th>
           <th>Turma</th>
           <th width="120">Opções</th> 
       </tr>
   </thead>
   <tbody>

       <?php foreach( $alunos as $aluno ): ?>
       <tr>
           <td><?=$aluno['id']?></td>
           <td><?=utf8_encode($aluno['nome'])?></td>
           <td><?=\Persistence\AlunoDAO::getTurma($aluno['id'])['turma_nome']?></td>
           <td>
           <a href="?action=editar&id=<?=$aluno['id']?>&nome=<?=$aluno['nome']?>">Editar</a>| <a href="?action=excluir&id=<?=$aluno['id']?>">Excluir</a>
           </td>
       </tr>
       <?php endforeach; ?>
       <!-- Para completar as linhas restantes para compor o layout fixo em 10 registros-->
       <?php 
       if ( $alunos->rowCount() < $registros_por_pagina):
           for( $i=0; $i < ( $registros_por_pagina - $alunos->rowCount() ); $i++):
             echo '<tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>';
           endfor;  
       endif; ?> 
       

   </tbody>

   <tfoot>
       <tr>
           <th align="left" colspan="3">Total página: <?=$pagina?>/<?=$paginas?> #Registros: <?=$alunos->rowCount()?> de <?=$total_registros?></th>
       </tr>
   </tfoot>

</table>

</article>
<footer>

</footer>

</div>

<script>
const limparForm = function(){
    
    document.getElementById('id').value = "0";
    document.getElementById('nome').value = "";

    location.href= "alunos.php";
}
</script>
