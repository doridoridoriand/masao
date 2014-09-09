<?php
//パースした結果をパース先に分けて表示

require('../logic/contentsSorter.php');

class parseResultViewHelper {

	/* parseListGeneratorから渡された配列をHTMLに変換する。
	   サイドバー用のヘルパー関数
	*/
	public function parseListHTMLConverter() {
		$parseList = $this->parseListGenerator();

		foreach ($parseList as $element) {
			echo '<li>';
			echo '<a href="#';
			print_r($element);
			echo '">';
			print_r($element);
			echo '</a>';
			echo '</li>';
		}
	}

	/* loadParseContentから受け取ったコンテンツの配列をHTMLに変換する
	*/
	public function parseContentHTMLConverter($contentName, $AllorLatestFlag) {
		$parseListArray = $this->loadParseContent($contentName, $AllorLatestFlag);
		//var_dump($parseListArray);
		foreach ($parseListArray as $element) {
			//var_dump($element);
			//echo '<br>';
			echo '<tr>';
			echo '<td>';
			print($element['title']);
			echo '</td><td>';
			print($element['content']);
			echo '</td><td><button type="button" class="btn btn-default"><a href="';
			print($element['link']);
			echo '" target="_blank"> ';
			echo 'リンク先へ';
			echo '</a></button>';
			echo '</td><td>';
			print($element['updated']);
			echo '</td>';
			echo '</tr>';
		}
	}

	/* contentSorter.phpからallContent()もしくはlatestContent()のどちらかを使用してコンテンツの内容を取得する。
	   どちらかを使用するかは$AllorLatestFlagを使用して判定する
	   ねむい
	*/
	private function loadParseContent($contentName, $AllorLatestFlag) {
		$contentReader = new contentReader;

		if ($AllorLatestFlag == 'ALL') {
			$source = $contentReader->allContent($contentName);
			return $source;
		} elseif ($AllorLatestFlag == 'LATEST') {
			$source = $contentReader->latestContent($contentName);
			return $source;
		}
	}

	/* サイドバーにパースリスト表示する用のhelper関数
	   parseResultにあるファイル数を確認してそのパースした結果を配列として返す
	   parseList.csvから読み込んだ結果では無くあくまで実際にクロール出来た結果を用いる
	*/
	private function parseListGenerator() {
		$parseContentCountResult = array();
		$scanDirectoryArray = scandir('../parseResult/');

		foreach ($scanDirectoryArray as $element) {
			if (is_file('../parseResult/' . $element)) {
				array_push($parseContentCountResult, $element);
			}
		}
		return $parseContentCountResult;
	}
}

$parseResultViewHelper = new parseResultViewHelper;
