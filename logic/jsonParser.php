<?php
//やんごとなき理由によりJSONをパースできるように機能を追加する

//ねむい起きてから実装するうんこちんこまんこ


//ああああああああ

/*メモ
APIを自動で叩くためにワードリストを作成。
XMLパーサーとの互換性を保つために、保存形式を統一(シリアライズしましょう。ファイル名も同様の命名規則で)
パーシャル化した部分を最大限活用出来るように
まあでもentryの部分ってか全然違うからあんま再利用出来ないんだけどｗｗｗｗｗｗｗｗｗｗｗｗｗ
*/


class jsonParser {

	public function parseJSON() {
		$this->devideJSONObject(); 
	}

	private function devideJSONObject() {
		$source = json_decode(stream_get_contents(fopen('../parseResult/test.json', 'r')), true);

		//var_dump($source);
		foreach ($source as $element) {
			var_dump($element);
		}
	}
}

$jsonParser = new jsonParser;
$jsonParser->parseJSON();