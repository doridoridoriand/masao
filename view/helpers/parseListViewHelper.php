<?php
/* # 必要な機能
   - parseList.csvからパース先のリストを読み込んでhtmlとしてはき出す(為にキレイに形成する)
*/
class parseListViewHelper {

	/* loadParseListから読み込んだパースリストの配列を要素ごとに分ける(とりあえず)
	   parseListConverter から受け取った要素の配列をマークアップで返す
	*/
	public function parseListConverter() {
		$parseListArray = $this->loadParseList();

		foreach ($parseListArray as $element) {
			echo '<tr>';
			echo '<td>';
			print($element[0]);
			echo '</td><td>';
			echo '<a href="';
			print($element[1]);
			echo '">';
			print($element[1]);
			echo '</a>';
			echo '</td>';
			echo '</tr>';
		}

	}

	/* parseList.csv から読み込んだパース先をphpの配列に変換する
	*/
	public function loadParseList() {
		$source = fopen('../parseList.csv', 'r');
		$parseListArray = array();

		while ($parseList = fgetcsv($source)) {
			array_push($parseListArray, $parseList);
		}
		unset($parseList);
		return $parseListArray;
	}
}

$parseListViewHelper = new parseListViewHelper;
