<?php

class contentReader {
	//xmlAutoParserNewから出力された、シリアライズ化されたパース結果を読み取って今日の日付のものが合ったらそのentryの配列を返す
	public function findLatestContent($content) {
		$this->loadContentAll($content);
		//parseResultにある
	}

	public function loadContentAll($contentName) {
		//parseResultにあるシリアライズかされた結果を読み取ってデシリアライズする
		$source = fopen('../parseResult/' . $contentName, 'r');
		$content = fread($source, filesize('../parseResult/' . $contentName));
		$phpArray = unserialize($content);
		fclose($source);
		return $phpArray;
	}
}

$contentReader = new contentReader;
