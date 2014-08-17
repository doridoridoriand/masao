<?php
//パースした結果をパース先に分けて表示

class parseResultViewHelper {


	private function loadParseContent() {

	}

	/* view側で何のパースした結果を押されているかを判定し、それを受け取ったら
	　　　parseResultに格納されている該当するパース結果を読み込む
	*/
	private function parseContentSelector() {

	}

	/* サイドバーにパースリスト表示する用のhelper関数
	   parseResultにあるファイル数を確認してそのパースした結果を配列として返す
	   parseList.csvから読み込んだ結果では無くあくまで実際にクロール出来た結果を用いる
	*/
	public function parseListGenerator() {
		$parseContentCountResult = array();
		$scanDirectoryArray = scandir('../../parseResult/');

		foreach($scanDirectoryArray as $element) {
			if (is_file('../../parseResult/' . $element)) {
				array_push($parseContentCountResult, $element);
			}
		}
		var_dump($parseContentCountResult);

	}
}

$parseResultViewHelper = new parseResultViewHelper;
$parseResultViewHelper->parseListGenerator();