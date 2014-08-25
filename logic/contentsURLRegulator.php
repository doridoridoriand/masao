<?php
//そもそもこれはパースする段階で行う処理なわけですが、パース先がアレなので、万が一の事を考えてオリジナルURLを残しておくことにしました
//こいつは単純にコンテンツ内部に内包されているURLからgoogle.comにいったんリダイレクトされるのを防止するために、URL文字列から省くだけの
//クラスを作成しただけです
//当たり前だけどgoogleAlert専用です

class contentsURLRegulator {

	/* 色々ゴニョゴニョして最終的に出力された配列の要素のゼロ番を返している
	*/
	public function regulator($contentName) {
		$source = $this->unSerialize($contentName);

		foreach ($source as $element) {
			$rowArray = str_replace('https://www.google.com/url?rct=j&sa=t&url=', '', $element['link']);
			$adjustedArray = explode('&ct=ga&cd=', $rowArray);
			//var_dump($adjustedArray[0]);
		}
		return $adjustedArray[0];
	}

	/* 本来こいつをパーシャル化するべきだよね。オレマジでうんこ
	*/
	private function unSerialize($contentName) {
		$source = fopen('../parseResult/' . $contentName, 'r');
		$content = fread($source, filesize('../parseResult/' . $contentName));
		$phpArray = unserialize($content);
		fclose($source);
		return $phpArray;
	}
}

$contentURLRegulator = new contentsURLRegulator;
$contentURLRegulator->regulator($argv[1]);
