<?php

require ('./twitterPoster.php');
//このクラスで実装すべきこと
//acocuntList.csvからつぶやくのに必要な$sConsumerKey,$sConsumerSecret,$sAccessToken,$sAccessTokenSecretを
//読みとり、さらにコンテンツ名を読み取って、poster関数に入れる

class tsubuyakiManager {
	public function chiefManager() {
		$source = $this->loadAccountList();

		for ($i = 0; $i < count($source); $i++) {
			$twitterposter = new twitterPoster;
			$twitterposter->poster($source[$i][0], $source[$i][1], $source[$i][2], $source[$i][3], $source[$i][4]);
		}
	}

	//この関数が、parseManagerを実行するトリガーにもなっているので、
	public function loadAccountList() {
		$accountListSource = fopen('./accountList.csv', 'r');
		$accountListArray = array();

		while ($accountList = fgetcsv($accountListSource)) {
			array_push($accountListArray, $accountList);
		}
		unset($accountList);
		return $accountListArray;
	}
}

$tsubuyakiManager = new tsubuyakiManager;
$tsubuyakiManager->chiefManager();