<?php
//parseList.csvに書かれたパース先を順番に読み取って、要素1を保存名、要素2をパース先のURLとして、xmlAutoParser.phpに渡す
include('xmlAutoParser.php');

class parseManager {
  /* loadParseListから渡された引数を元にxmiAutoParserを実行する 
   */
  public function parserRunnner() {
    $parseList = $this->loadParseList();

    for ($i = 0; $i < count($parseList); $i++) {
      $saveName = $parseList[$i][1];
      $parseURL = $parseList[$i][2];

      //xmlAutoParserのメソッドを呼び出し
      $parseXML = new parseXML;
      $parseXML->loadXML($saveName, $parseURL);
    }
  }

  /* parseList.csvを読み取り、要素二つを引数とする
   */
  private function loadParseList() {
    $source = fopen('../masterAccountList.csv', 'r');
    $parseListArray = array();

    while ($parseList = fgetcsv($source)) {
      array_push($parseListArray, $parseList);
    }
    unset($parseList);
    return $parseListArray;
  }
}

$parseManager = new parseManager;
$parseManager->parserRunnner();
