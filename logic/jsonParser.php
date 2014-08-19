<?php
//やんごとなき理由によりJSONをパースできるように機能を追加する

/*メモ(深夜テンション)
APIを自動で叩くためにワードリストを作成。
XMLパーサーとの互換性を保つために、保存形式を統一(シリアライズしましょう。ファイル名も同様の命名規則で)
パーシャル化した部分を最大限活用出来るように
まあでもentryの部分ってか全然違うからあんま再利用出来ないんだけどｗｗｗｗｗｗｗｗｗｗｗｗｗ
*/
/* ひとまずJSONを保存する機能は実装しない
*/

class jsonParser {

	public function parseJSON() {
		$source = $this->contentElementAdjuster(); 
		var_dump($source);
	}

	/* ミニマム機能
	   検索結果のみを配列に入れたいので、その他のパラメーターによって出来た要素はいったん削除する
	   0~10に関しては削除
	*/
	private function contentElementAdjuster() {
		$source = $this->devideJSONObject();
		for ($i = 0; $i <= 10; $i++) {
			unset($source[$i]);
		}
		return $source;
	}

	/* JSONを読み込んで要素を配列として返す
	*/
	private function devideJSONObject() {
		
		$contentArray = array();
		$source = json_decode(stream_get_contents(fopen('../parseResult/test.json', 'r')), true);

		foreach ($source as $element) {
			foreach ($element as $parts) {
				array_push($contentArray, $parts);
			}
		}
		return $contentArray;
	}

	/* 今は必要ないけれど、将来的に必要になりそうなので実装
	   parseResultに格納されているJSONをのファイル名を全て配列として返す
	*/
	public function jsonSelector() {

		$targetDirectoryArray = array();
		$tagetDirectory = scandir('../../parseResult/');

		foreach ($tagetDirectory as $element) {
			if (is_file('../parseResult/' . $element))	{
				if (preg_match('/.json/', $element, $result)) {
					array_push($targetDirectoryArray, $element);	
				} 
			}
		}
		return $targetDirectoryArray;
	}
}
