<?php
//parseList.phpに書かれたパース先を順番に読み取って(配列かして、要素を指定して順番に読み取る)、それぞれの定数の名前のファイルに出力
//こいつもううんこだから放棄
class parseXML {

  public function loadXML() {
    //xmlSelectorから渡されたXMLのURLを読み取りパースして、指定の定数値のフィある名で保存する
    $parseScope = $this->xmlSelector();
    var_dump($parseScope);
  }

  private function xmlSelector() {
    //parseList.csvに書かれたパース先を順番に読み取り、loadXMLに渡す
    $source = fopen('parseList.csv', 'r');
    while ($parseListArray = fgetcsv($source)) {
      $parseContent = simplexml_load_file($parseListArray[1]);

      foreach ($parseContent->entry as $value) {
        $result[] = array('title' => (string)$value->title,
                          'link' => (string)$value->link,
                          'updated' => (string)$value->updated
                          );
        var_dump($result);
      }
    }
    unset($parseListArray);
  }
}

$parseXML = new parseXML;
$parseXML->loadXML();

?>