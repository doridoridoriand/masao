<?php
//parseList.phpに書かれたパース先を順番に読み取って(配列かして、要素を指定して順番に読み取る)、それぞれの定数の名前のファイルに出力

class parseXML {

  public function loadXML() {
    //xmlSelectorから渡されたXMLのURLを読み取りパースして、指定の定数値のフィある名で保存する
    $this->xmlSelector();
  }

  private function xmlSelector() {
    //parseList.csvに書かれたパース先を順番に読み取り、loadXMLに渡す
    $source = fopen('parseList.csv', 'r');
    while($parseListArray = fgetcsv($source)) {
      var_dump($parseListArray);
    }
  }
}
$parseXML = new parseXML;
$parseXML->loadXML();
?>
