<?php

require ('../logic/jsonParser.php');

class jsonResultViewHelper {

	/* loadJSONから渡された配列を要素ごとに分けて、HTMLとして形成する
	*/
	public function jsonObjectDevider() {
		$source = $this->loadJSON();

		foreach ($source as $element) {
			echo '<tr>';
			echo '</tr>';
			echo '<tr>';
			echo '</tr>';
			echo '<tr>';
			echo '</tr>';
		}
	}

	/* parseJSONから受け取った配列を読みこむ
	*/
	private function loadJSON() {
		$jsonParser = new jsonParser;
		$source = $jsonParser->parseJSON();

		return $source;
	}
}

$jsonResultViewHelper = new jsonResultViewHelper;
$jsonResultViewHelper->jsonObjectDevider();
