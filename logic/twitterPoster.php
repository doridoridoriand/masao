<?php

require_once('./twitteroauth/twitteroauth.php');
require('./contentsSorter.php');
//実装する機能
//contentsSorterから受け取った最新記事の配列をentryごとに、Ｔｗｉｔｔｅｒの文面としておかしくないように形成し、
//twitteContentの形で変数に入れる

class twitterPoster {

	//contentSorterから受け取った配列を分解して、content項目とlinkをを取り出して、つぶやく内容とする
	public function tweetContentArrayGenerator($contentName) {
		$source = $this->contentArrayMerger($contentName);
		$newArray = array();

		for ($i = 0; $i < count($source); $i++) {
			$stringElement = $source[$i][0]['content'] . ' ' . $source[$i][1];
			array_push($newArray, $stringElement);
		}
		return $newArray;
	}

	//記事のオリジナルの配列とregulatorから渡されたURLの配列をマージする
	public function contentArrayMerger($contentName) {
		$newContentArray = array();
		$newContentArrayElement = array();

		$originalContentArray = $this->postContentProvider($contentName);
		$regulatedContentURLArray = $this->regulator($contentName);

		for ($i = 0; $i < count($originalContentArray); $i++) {
			array_push($newContentArrayElement, $originalContentArray[$i], $regulatedContentURLArray[$i]);
			array_push($newContentArray, $newContentArrayElement);
			array_pop($newContentArrayElement);
			array_pop($newContentArrayElement);
		}
		return $newContentArray;
	}

	//本当はcontentsURLRequlatorクラスを用意していたのでそこで処理したかったが、
	//別にわざわざ他のクラスを通す必要も無いかもと思ったのでこちらにも実装
	private function regulator($contentName) {
		$postContentURLRegulatedArray = array();
		$source = $this->postContentProvider($contentName);

		foreach ($source as $element) {
			$rowArray = str_replace('https://www.google.com/url?rct=j&sa=t&url=', '', $element['link']);
			$adjustedArray = explode('&ct=ga&cd=', $rowArray);
			array_push($postContentURLRegulatedArray, $adjustedArray[0]);
		}
		return ($postContentURLRegulatedArray);
	}

	//contentSorterのwrapperです
	private function postContentProvider($contentName) {
		$contentReader = new contentReader;
		$source = $contentReader->allContent($contentName);
		return $source;
	}

	//設定項目
	//テストアカウント用。本番は引数に入れ込んでアカウントごとにキーを入れ替える
	private function twitterConfigure() {	
		$sConsumerKey = "wQweDmqn5P8VVudjllUTdwvP8";
		$sConsumerSecret = "Ru3q3ezT1slKEldcHK1By8kmG781Sc0UjTfRIF0v7DHW2u45q2";
		$sAccessToken = "265649845-b4ymqy21JtGO4kNXPQp0KrcU0B6xR2cANPYsAYxe";
		$sAccessTokenSecret = "2933lzh85hDHzhJb9hhwLiCHMePA5h5IQFT43qvGMY2XH";

		$twObj = new TwitterOAuth($sConsumerKey,$sConsumerSecret,$sAccessToken,$sAccessTokenSecret);
	}
}
$twitterposter = new twitterPoster;
$twitterposter->tweetContentArrayGenerator(COSTCO);