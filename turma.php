<?php
   
   ini_set('display_errors', 1);
   error_reporting(E_ALL|E_WARNING);

   require __DIR__ . "/vendor/autoload.php";
   
   use \Persistence\Connection as CON;


   if ( isset( $_REQUEST['action'] ) && !empty( $_REQUEST['action'] ) ):  //sintaxe alternativa do php

    $action = $_REQUEST['action'];
    $id = intval($_REQUEST['id']);

    switch( $action ):
        
        case 'salvar':
          
          $turma = new \Model\Turma();
          $turma->setId($_POST['id']);
          $turma->setNome(strtoupper($_POST['nome']));
          
          salvar($turma);

        break;

        case 'excluir':
            excluir($id);
        break;
   endswitch;

   endif;


   function pesquisar(int $id){

    $ret = null;

    //pesquisa o registro no banco
    $sql = "select * from TURMA where id = :id ";
    $stm = CON::connect()->prepare($sql);
    $stm->bindParam(':id', $id );
    $stm->execute();
    
    $ret = $stm->fetch();

    return $ret;

   }

   function salvar(\Model\Turma $turma){

        $stm = null;

        //die("ID: " . $turma->getId());
        if ( pesquisar( $turma->getId() ) ):

        $sql = "update TURMA set nome = :nome where id = :id " ;
        $stm = CON::connect()->prepare($sql);
        $stm->bindValue(':id', $turma->getId(), \PDO::PARAM_INT);
        $stm->bindValue(':nome', $turma->getNome(), \PDO::PARAM_STR);

        $stm->execute();   
        
       else:

        //die(var_dump($turma->getNome()));        //se não existir insira
        $sql = "insert into TURMA( nome ) values ( :nome )";
        $stm = CON::connect()->prepare($sql);
        $stm->bindValue(':nome', $turma->getNome());

        $stm->execute();
        
       endif;
    
   }


   function excluir(int $id){

    $sql = 'delete from TURMA where id = :id';
    $stm = CON::connect()->prepare($sql);
    $stm->bindValue(':id', $id, \PDO::PARAM_INT );

    $stm->execute();

   }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Turma</title>

    <style>
    label {
        display: inline-block;
        width: 150px;
        background-color: lightblue;
        padding: 4px;
    }

    input[type="number"] {
        background-color: lightgray;
    }

    input[type="text"] {
        background-color: lightyellow;
    }

    table {
        border-collapse: collapse;
    }

    caption {
        padding: 5px;
        background-color: lightblue;
        text-align: left;
    }

    tfoot>tr {
        background-color: lightblue;
    }
    </style>

    <script>
         const limparForm = function(){
             
             document.getElementById('id').value = "0";
             document.getElementById('nome').value = "";

             location.href= "turma.php";
         }
    </script>
</head>

<body>

    <div style="margin: 0 auto; width:80%">
        <header>
            <h2 style="padding: 4px;margin:0 auto;background-color: lightblue; text-align:center;">Cadastro de Turmas</h2>
            <p>
                <form name="form_turma" id="form_turma" method="post" action="turma.php">
                    <label for="id">ID</label>
                    <input type="number" id="id"  value="<?=$_REQUEST['id']??'0'?>"  name="id" value="0" readonly="readonly">
                    <br>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" value="<?=$_REQUEST['nome']??''?>" size="50" maxlength="50" required="required">
                    <button type="reset" onclick="limparForm();">Novo</button>
                    <button type="submit" name="action" value="salvar">Salvar</button>
                </form>
            </p>
        </header>
        <article>
            
             <h4><?php echo !empty( $_REQUEST['mensagem']) ? $_REQUEST['mensagem']: null;?></h4>

             <?php
               
               $registros_por_pagina  = 10;
               $pagina = $_REQUEST['pagina'] ?? 1;
               $offset = ($pagina -1 ) * 10 ;
               
               $res = CON::connect()->query("select count(*) total_registros from TURMA");
               $total_registros = $res->fetch()['total_registros'];

               $turmas = CON::connect()->query("select * from TURMA limit $offset, $registros_por_pagina");
               $paginas = ceil ($total_registros / $registros_por_pagina) ?? 1;

                echo "<div style='margin: 0 auto;padding: 10px;'>Página: ";
                for($i=1;$i <= $paginas;++$i):
                      echo "<a style='margin: 4px;padding:3px 12px;  border:2px outset lightgray;' href='?pagina={$i}'><strong>$i</strong></a>";
                endfor;
                echo "</div>";


               ?>


            <table width="100%" border="1" cellpadding="5" cellspacing="4" rules="both">
                <caption>.:: Listagem de Turmas ::..</caption>

                <thead>
                    <tr>
                        <th width="30">ID</th>
                        <th>Nome</th>
                        <th width="120">Opções</th> 
                    </tr>
                </thead>
                <tbody>

                    <?php foreach( $turmas as $turma ): ?>
                    <tr>
                        <td><?=$turma['id']?></td>
                        <td><?=$turma['nome']?></td>
                        <td>
                        <a href="?action=editar&id=<?=$turma['id']?>&nome=<?=$turma['nome']?>">Editar</a>| <a href="?action=excluir&id=<?=$turma['id']?>">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- Para completar as linhas restantes para compor o layout fixo em 10 registros-->
                    <?php 
                    if ( $turmas->rowCount() < $registros_por_pagina):
                        for( $i=0; $i < ( $registros_por_pagina - $turmas->rowCount() ); $i++):
                          echo '<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>';
                        endfor;  
                    endif; ?> 
                    

                </tbody>

                <tfoot>
                    <tr>
                        <th align="left" colspan="3">Total página: <?=$pagina?> | de | <?=$paginas?> #Registros: <?=$turmas->rowCount()?></th>
                    </tr>
                </tfoot>

            </table>


        </article>
        <footer>

        </footer>

    </div>

</body>

</html>