<?php
set_include_path('.:/usr/share/php:/usr/share/pear');
require_once('./logic/PHPExcel/Classes/PHPExcel.php');
require_once('./logic/PHPExcel/Classes/PHPExcel/IOFactory.php');

class loadExcelFile {
  public function loadExcelSource() {
    $excelSource = './20141013_twitter_lnb.xlsx';
    var_dump(readXlsx($excelSource));
  }
}
$loadExcelSource = new loadExcelFile;
$loadExcelSource->loadExcelSource();
