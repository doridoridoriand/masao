<?php
//parseList.txtに書かれたパース先を読み込んで、配列化してそれぞれの定数の名前のファイルに出力

class parseXML {
	public function loadXMLContent() {
		//xmlSelectorからXMLのURLを読み取る
		$parseScope = $this->xmlParseListReader();
		//var_dump($parseScope);
		for ($i = 0; $i < count($parseScope); $i++) {
			$xml = simplexml_load_file($parseScope[$i][1]);
			var_dump($xml);
		}
	}

	private function xmlParseListReader() {
		//parseList.csvに書かれたパース先を順番に読み取る
		$source = fopen('parseList.csv', 'r');
		$parseListArray = array();
		while ($parseList = fgetcsv($source)) {
			array_push($parseListArray, $parseList);
		}
		return $parseListArray;
	}

	private function contentSaver() {
		//loadXMLContentから読み取った内容を保存する。
	}
}

$parseXML = new parseXML;
$parseXML->loadXMLContent();

?>