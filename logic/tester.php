<?php

#ツイッターのポスト内容に何か新機能として入れ込みたいときに、現状のクラスを操作するのは色々と危険なので、専用のサンドボックス的なクラスを作成。
#何かpost内容を検証したい場合は、必ずこのクラスを使用する

require ('./contentsSorter.php');
require ('./twitterPoster.php');
require_once('./twitteroauth/twitteroauth.php');

class twitterPostSandbox {

  public function dateStringer() {
    $dateString = '';
    $weekJapanese = array('日曜', '月曜', '火曜', '水曜', '木曜', '金曜', '土曜');
    $dateString = '【' . date('m/d') . ' ' . $weekJapanese[date('w')] . '】';
    return $dateString;
  }

  #テスト用アカウントをぶったたく
  public function sandbox($AllorLatest, $contentName) {
  $apiURL = 'https://api.twitter.com/1.1/statuses/update.json';
  $twObj = new TwitterOAuth('WXxWaBi8w75HEXoYmAXRNg1Z6','w8q7eZtCnnKVg4YLZXjkAXO1LfrsXwuDMY7OqSNfvDnVe7WYzH','2468980268-Fcn699mDMJi5wJkTSMxPoQwgjubJf0BugxaTNH7','uBDLsLBrNTGeVTm0V6PMabJ3VvQc8QtTW9DrWgjO1iPWx');

    //$source = $this->loadContent($AllorLatest, $contentName);
    $source = $this->callProductionContentArrayGenerator($contentName);
    $dateString = $this->dateStringer();
    //$modifiedSource = $dateString . strip_tags($source[3]['title'] . ' ' . $source[3]['link']);

    for ($i = 0; $i < count($tweetContentArray); $i++) {
      $tweetContent = $tweetContentArray[$i];
      var_dump(json_decode($twObj->OAuthRequest($apiURL,"POST",array("status" => $tweetContent))));
    }
      //var_dump(json_decode($twObj->OAuthRequest($apiURL,"POST",array("status" => $modifiedSource))));
  }

  public function callProductionContentArrayGenerator($contentName) {
    $twitterPoster = new twitterPoster;
    $tweetDataString = $twitterPoster->tweetContentArrayGenerator($contentName);
    var_dump($tweetDataString);
  }

  #contentsSorterからコンテンツパースしたコンテンツを読み込む。
  #このとき引数にAllかLatestを指定することによって関数の呼び出しを切り替える
  private function loadContent($AllorLatest, $contentName) {
    $contentReader = new contentReader;
    if ($AllorLatest == 'all') {
      return $contentReader->allContent($contentName);
    } else if ($AllorLatest == 'latest') {
      return $contentReader->latestContent($contentName);
    }
  }
}
$twitterPostSandbox = new twitterPostSandbox;
//$twitterPostSandbox->dateStringer();
$twitterPostSandbox->sandbox(all, osaka_osaka);
