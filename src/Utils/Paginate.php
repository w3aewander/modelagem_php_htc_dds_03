<?php
/**
 * Utils: Paginação
 * @author Wanderlei Silva do Carmo <wander.silva@gmail.com>
 * @version 1.0
 * @license GPL 3.0
 */

 namespace Utils;

 use \Persistence\Connection as CON;

 class Paginate {

    /**
     * Obtém o total de registros de uma determinada tabela
     * @param string $table Nome da tabela
     * @return int $total_registros
     */
    public static function getRecordCount(string $table){
        $pdo = CON::connect()->query("select count(*) as total_registros from {$table}");
        $res = $pdo->fetch(\PDO::FETCH_OBJ);
        return $res->total_registros;
    }

    /**
     * Monta links para as páginas de dados
     * @param string $tabel O nome da tabela 
     * @param int $recordsPerPage Qtde de registros que será exibida por página
     */
    public static function getLinks(
        string $table,
        int $recordsPerPage=10)
    {
        $recordCount = self::getRecordCount($table, $css='pagination');
        $pagesCount = ceil( $recordCount / $recordsPerPage) ?? 1;
        $links = "";
        for($i=1;$i<=$pagesCount;++$i):
            $links .= "<a class='{$css}' href='?page={$i}'>$i<a>";
        endfor;

        return $links;

    }
 }