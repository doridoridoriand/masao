<?php
//parseResultディレクトリに入っているパース結果のファイル名を指定されたら、
//コンテンツ要素のupdatedの日付を見て、contentSolterを実行した日付と合致する要素の配列を返す

class contentSorter {

	/* unSerializeより受け取ったファイルの内容のupdatedの日付と実行時のマシンの日付と比較して、
	一致する要素があったら配列として返す

	@param デシリアライズしたファイルの内容
	@return 条件に合致した要素を含んだ配列
	*/
	public function sorter($contentName) {
		$contentData = $this->unSerialize($contentName);

		foreach ($contentData as $value) {
			preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $value['updated'], $contentUpdatedDate);
			
			if ($contentUpdatedDate[0] == date('Y-m-d')) {
				return $value;
			}
		}
	}

	/* 第一引数からファイル名を読み取り、ファイルの内容をphpの配列に戻す

	　　@param ファイル名
	　　@return コンテンツ内容の配列
	*/
	private function unSerialize($contentName) {
		$source = fopen('./parseResult/' . $contentName, 'r');
		$content = fread($source, filesize('./parseResult/' . $contentName));
		$phpArray = unserialize($content);
		fclose($source);
		return $phpArray;
	}
}

$contentSorter = new contentSorter;
$contentSorter->sorter($argv[1]);