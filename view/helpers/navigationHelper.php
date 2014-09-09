<?php
/*　ミニマムな機能として、header.php内部のnavBar制御を行う。
   - メニューの数
   - リンクの生成
   - class = 'active'などの制御
   おちんちん
*/

define(VIEWS_PATH, './');

class navigationHelper {

	public function navigate() {
		$menuCount = $this->pagesCounter();
		$pageLinksArray = $this->pagesLinkGenerator();

		for ($i = 0; $i < $menuCount; $i++) {
			echo '<li><a href="';
			print_r($pageLinksArray[$i]);
			echo '">';
			print_r(str_replace('.php', '', (str_replace(VIEWS_PATH, '', $pageLinksArray[$i]))));
			echo '</a></li>';
		}
	}

	/* viewsフォルダにあるview用phpファイルの数をカウントする
	   まずscadir()でディレクトリも含めた数(ファイル・フォルダ名)を配列として取得する
	   次に取得した配列をもう一度ディレクトリ構造を再現して、is_file()に突っ込む
	   trueとなった物を条件分岐で配列にarray_pushする
	   最後に作成した配列の要素をカウントする
	*/
	private function pagesCounter() {
		$directoryScanResult = array();
		$scanDirectoryArray = scandir(VIEWS_PATH);

		foreach($scanDirectoryArray as $element) {
			if (is_file(VIEWS_PATH . $element)) {
				array_push($directoryScanResult, $element);
			}
		}
		return count($directoryScanResult);
	}

	/* viewsフォルダにあるview用phpファイルに飛べるようにリンク用の相対パスを生成する
	*/
	private function pagesLinkGenerator() {
		$scanDirectoryArray = scandir(VIEWS_PATH);
		$directoryScanResult = array();		

		foreach ($scanDirectoryArray as $element) {
			if (is_file(VIEWS_PATH . $element)) {
				array_push($directoryScanResult, VIEWS_PATH . $element);
			}
		}
		return $directoryScanResult;
	}
}

$navigationHelper = new navigationHelper;
