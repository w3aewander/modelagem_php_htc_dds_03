<?php
/**
 * Class: GenerateTable
 * @author Wanderlei Silva do Carmo <wander.silva@gmail.com>
 * @version 1.0
 */

namespace Utils;

use \Persistence\Connection as CON;

class GenerateTable
{

 /**
  * Gera a tabela a partir do nome informado
  * @param string $table O nome da tabela
  * @return mixed  $html_table
  */
 public static function generate(string $table, string $border = '1', $rules = 'all', $css = 'table'): string
 {

  $html = "<table cellpadding='2' cellspacing='2' border='{$border}' rules='{$rules}' class='{$css}'>";
  $html .= "<caption classs='caption'>Listagem da Tabela {$table}</caption>";
  $html .= self::mountTableHeader($table);
  $html .= self::mountTableBody($table);
  $html .= self::mountTableFooter($table);

  $html .= "</table>";
  return $html;

 }

 /**
  * Monta o THEAD da tabela
  * @param string $table o nome da tabela
  * @param array $columns Um array contendo o nome das colunas a serem exibidas
  *              se não informado exibirá todas as colunas
  * @param string $border informa se terá borda (1) ou não (0)
  * @param string $css informa a classe css que será utilizada no html gerado
  */
 public static function mountTableHeader(string $table, array $columns = [], string $theadclass = 'thead', string $trclass = 'tr', string $thclass = 'th'): string
 {

  $stm = CON::connect()->query("show columns from {$table} ");

  if (!$columns):

   $res = $stm->fetchAll(\PDO::FETCH_OBJ);
   $headers = $res;

  else:
   $headers = $columns;

  endif;

  $thead = "<thead class='{$theadclass}'><tr class='{$trclass}'>";

  foreach ($headers as $header):
   $thead .= "<th class='{$thclass}'>{$header->Field}</th>";
  endforeach;

  $thead .= "<th width='180' class='{$thclass}'>Opções</th>";
  $thead .= "</tr></thead>";

  return $thead;
 }


 
 /**
  * mountTableBody
  *
  * /**
  * Monta o corpo da tabela
  * @param  string $table
  * @param  array $columns
  * @param  array $where
  * @param  int $offset
  * @param  int $recordsPerPage
  * @param  string $tbodyclass
  * @param  string $trclass
  * @param  string $tdclass
  *
  * @return string
  */
 public static function mountTableBody(string $table, array $columns = [], array $where = [], int $offset = 0, int $recordsPerPage = 10, string $tbodyclass = 'tbody', string $trclass = 'tr', string $tdclass = 'td'): string
 {

  $stm = null;
  if ($where):
   $stm = CON::connect()->prepare("select * from {$table} {$where} limit {$offset},{$recordsPerPage} ");
   foreach ($where as $key => $value):
    $stm->bindParam($key, $value);
   endforeach;

   $rows = $stm->fetchAll(\PDO::FETCH_BOTH);

  else:
   $stm = CON::connect()->query("select * from {$table} limit {$offset},{$recordsPerPage} ");

   endif;

   $stm->execute();

  $rows = $stm->fetchAll(\PDO::FETCH_BOTH);

  $tbody = "<tbody class='{$tbodyclass}'>";

  foreach ($rows as $row):

   $tbody .= "<tr class='{$trclass}'>";
   
   for ($i = 0; $i < $stm->columnCount(); ++$i):
    $tbody .= "<td class='{$tdclass}'>{$row[$i]}</td>";
   endfor;

   $tbody .= "<td class='{$tdclass} text-center' >
               <a class='link' href='?action=editar&id={$row["0"]}'>Editar</a>
               <a class='link' href='?action=excluir&id={$row["0"]}'>Excluir</a>
             </td>";

   $tbody .= "</tr>";
  endforeach;

   if ( self::getRecordCount($table) < $recordsPerPage ):
         for($i=0;$i <= ($recordsPerPage - self::getRecordCount($table)  ) ;++$i):
            $tbody .=  "<tr class='{$trclass}'>";
            for ($j = 0 ; $j <= self::getColumnCount($table); ++$j):
               $tbody .= "<td class='{$tdclass}'>&nbsp;</td>";
            endfor;
            $tbody .= "</tr>";
         endfor;           
   endif;


  $tbody .= "</tbody>";

  return $tbody;

 }

 /**
  * 
  */
 public static function mountTableFooter(string $table, string $tfootclass = 'tfoot', string $trclass = 'tr', string $thclass = 'td'): string
 {

    $colsCount = self::getColumnCount($table) +1;
    $recordCount = self::getRecordCount($table);

    $tfoot = "<tfoot class='{$tfootclass}'><tr>";
    $tfoot .= "<th class='{$thclass}' colspan='{$colsCount}'>#Registros: {$recordCount} </th>";
    $tfoot .= "</tr></tfoot>";

    return $tfoot;
 }

 
 /**
  * getRecordCount
  *
  * @param  string $table O nome da tabela
  *
  * @return int
  */
 public static function getRecordCount(string $table): int {
    $stm = CON::connect()->prepare("select count(*) total_registros from  {$table}");
    $stm->execute();
    return $stm->fetch()['total_registros'];
 }

 
 /**
  * getColumnCount
  *
  * @param  mixed $table
  *
  * @return int
  */
 public static function getColumnCount(string $table): int {
   $stm = CON::connect()->query("select * from  {$table} limit 1");
   return $stm->columnCount();
}


/**
 * tableCaption
 *
 * @param  mixed $caption
 *
 * @return string
 */
public static function tableCaption(string $caption="Titulo da tabela"):string
{
    return strtoupper($caption);
}

}