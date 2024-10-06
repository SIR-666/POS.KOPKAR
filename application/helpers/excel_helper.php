<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/PHPExcel-1.8/Classes/PHPExcel.php';

/**
 * Fungsi untuk membaca file Excel
 * 
 * @param string $filename nama file Excel
 * @return array data dari file Excel
 */
function read_excel($filename) {
  $objPHPExcel = PHPExcel_IOFactory::load($filename);

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  $data = array();

  for ($row = 1; $row <= $highestRow; $row++) {
    $rowData = array();
    for ($col = 'A'; $col <= $highestColumn; $col++) {
      $value = $sheet->getCell($col.$row)->getValue();
      $rowData[] = $value;
    }
    $data[] = $rowData;
  }

  return $data;
}

function read_sheet($filename,$sheetNo = 0) {
  $objPHPExcel = PHPExcel_IOFactory::load($filename);

  $sheet = $objPHPExcel->getSheet($sheetNo);
  return $sheet;
}
?>
