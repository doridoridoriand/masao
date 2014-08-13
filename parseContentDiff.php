<?php
//xmlAutoParserNewから出力された、シリアライズ化されたパース結果を読み取って今日の日付のものが合ったらそのentryの配列を返す

class compareContent {
	public function compare($content) {
		$this->loadContent($content);
		//parseResultにある
	}

	private function loadContent($contentName) {
		//parseResultにあるシリアライズかされた結果を読み取ってデシリアライズする
		$source = fopen('./parseResult/' . $contentName, 'r');
		$content = fread($source, filesize('./parseResult/' . $contentName));
		$phpArray = unserialize($content);
		fclose($source);
		var_dump($phpArray);
	}
}

$compareContent = new compareContent;
$compareContent->compare($argv[1]);

?>