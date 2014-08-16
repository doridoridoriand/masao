<?php
//parseList.csvに書かれたパース先を順番に読み取って(配列かして、要素を指定して順番に読み取る)、それぞれの定数の名前のファイルに出力
//第1引数に保存名、第2引数にパース先のURLを指定する形で実行する
class parseXML {

	/*パース先のXMLから必要な情報を持ってきてシリアライズ化して保存する

	　　readParseURLからパース先を読み取って第1引数の名前で保存する

	　　@param string パース内容の保存名称　パース先のURL
	  @return string シリアライズ化したパース内容
	 */
    public function loadXML($parseURLName, $parseURL) {
      	$source = $this->readParseURL($parseURL);
    
      	foreach ($source->entry as $value) {
      		$parseResult[] = array('title'    => (string)$value->title,
      								'link'    => (string)$value->link,
      								'updated' => (string)$value->updated
      								);
      	}
      	$fileAccess = fopen('./parseResult/' . $parseURLName, 'w');
      	fwrite($fileAccess, serialize($parseResult));
      	fclose($fileAccess);
    }

    /*実行時に指定された第2引数からURLを読み取る

      第2引数のURLを読み取り、xmlをphpのオブジェクトに変換する

      @param string パース先のURL
      @return string パース後のオブジェクト
    */
    private function readParseURL($parseURL) {
      return simplexml_load_file($parseURL);
    }
}

//$parseXML = new parseXML;
//$parseXML->loadXML($argv[1], $argv[2]);
