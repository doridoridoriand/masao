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
		//var_dump($this->mergeListandTimeStamp());

		foreach ($parseListArray as $element) {
			echo '<tr>';
			echo '<td>';
			print($element[1]);
			echo '</td><td>';
			echo '<a href="';
			print($element[2]);
			echo '">';
			print($element[2]);
			echo '</a>';
			echo '</td><td>';
			echo '</td><td>';
			echo '<h4><span class="label label-danger">';
			echo 'ENGAGED';
			echo '</span></h4></td>';
			echo '</tr>';
			;
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

	private function mergeListandTimeStamp() {

		$sourceParseList = $this->loadParseList();
		$sourceFilemTime = $this->loadFilemTime();

		for ($i = 0; $i < count($sourceParseList); $i++) {
		}
		//$mergedArray = array_merge($sourceParseList, $sourceFilemTime);
		//return $mergedArray;
	}

	/* 取得したRSSのデーターの更新日時を取得する。
	   とりあえずファイルの更新日時でおｋ
	*/
	private function loadFilemTime() {
		$fileTimeStampArray = array();
		$fileTimeStampArrayElement = array();
		$source = $this->parseFilePathGenerator();

		for ($i = 2; $i < count($source); $i++) {
			//var_dump(date('Y-m-d H:i:s e', filemtime($source[$i])));
			$fileTimeStamp = date('Y-m-d H:i:s e', filemtime($source[$i]));
			array_push($fileTimeStampArrayElement, $source[$i], $fileTimeStamp);
			array_push($fileTimeStampArray, $fileTimeStampArrayElement);
			array_pop($fileTimeStampArrayElement);
			array_pop($fileTimeStampArrayElement);
		}
		return $fileTimeStampArray;
	}

	/* パース結果の保存ファイルのパスを生成する
	*/
	private function parseFilePathGenerator() {
		$parseFilePathArray = array();
		$scanDirectryResult = scandir('../parseResult/');

		foreach ($scanDirectryResult as $element) {
			if (is_file('../parseResult/') . $element) {
				array_push($parseFilePathArray, '../parseResult/' . $element);
			}
		}
		return $parseFilePathArray;
	}
}

$parseListViewHelper = new parseListViewHelper;
