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
            <h2>Cadastro de Turmas</h2>
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

            <table width="100%" border="1" cellpadding="5" cellspacing="4" rules="both">
                <caption>#Qtde:registros</caption>

                <thead>
                    <tr>
                        <th width="30">ID</th>
                        <th>Nome</th>
                        <th width="120">Opções</th> 
                    </tr>
                </thead>
                <tbody>

              <?php
                 $turmas = CON::connect()->query("select * from TURMA ");
              
               ?>
                    <?php foreach( $turmas as $turma ): ?>
                    <tr>
                        <td><?=$turma['id']?></td>
                        <td><?=$turma['nome']?></td>
                        <td>
                        <a href="?action=editar&id=<?=$turma['id']?>&nome=<?=$turma['nome']?>">Editar</a>| <a href="?action=excluir&id=<?=$turma['id']?>">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3">&nbsp;</th>
                    </tr>
                </tfoot>

            </table>


        </article>
        <footer>

        </footer>

    </div>

</body>

</html>