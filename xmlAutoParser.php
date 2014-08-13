<?php
//parseList.phpに書かれたパース先を順番に読み取って(配列かして、要素を指定して順番に読み取る)、それぞれの定数の名前のファイルに出力
//第1引数に保存名、第2引数にパース先のURLを指定する形で実行する
class parseXML {

    public function loadXML() {
      //readParseURLからパース先を読み取って第1引数の名前で保存する
      $source = $this->readParseURL();
      //yotta
    }

    private function readParseURL() {
      // 実行時に指定された第2引数からURLを読み取り、パース先とする
      return simplexml_load_file($argv[2]);
    }
}


$parseXML = new parseXML;
$parseXML->loadXML();

?>