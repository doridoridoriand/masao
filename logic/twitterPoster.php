<?php

require_once('./twitteroauth/twitteroauth.php');
require('./contentsSorter.php');
//実装する機能
//contentsSorterから受け取った最新記事の配列をentryごとに、twitterの文面としておかしくないように形成し、
//twitteContentの形で変数に入れる

class twitterPoster {

  public function poster($contentName, $sConsumerKey, $sConsumerSecret, $sAccessToken, $sAccessTokenSecret) {
    $apiURL = 'https://api.twitter.com/1.1/statuses/update.json';

    $tweetContentArray = $this->tweetContentArrayGenerator($contentName);
    $twObj = $this->twitterConfigure($sConsumerKey, $sConsumerSecret, $sAccessToken, $sAccessTokenSecret);
    //$tweetContent = $tweetContentArray[0];
    for ($i = 0; $i < count($tweetContentArray); $i++) {
      $tweetContent = $tweetContentArray[$i];
      var_dump(json_decode($twObj->OAuthRequest($apiURL,"POST",array("status" => $tweetContent))));
    }
  }

  //contentSorterから受け取った配列を分解して、content項目とlinkをを取り出して、つぶやく内容とする
  private function tweetContentArrayGenerator($contentName) {
    $source = $this->contentArrayMerger($contentName);
    $newArray = array();

    for ($i = 0; $i < count($source); $i++) {
      $stringElement = strip_tags($source[$i][0]['title']) . ' ' . $source[$i][1];
      array_push($newArray, $stringElement);
    }
    return $newArray;
  }

  //記事のオリジナルの配列とregulatorから渡されたURLの配列をマージする
  private function contentArrayMerger($contentName) {
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
  private function twitterConfigure($sConsumerKey, $sConsumerSecret, $sAccessToken, $sAccessTokenSecret) {
    $twObj = new TwitterOAuth($sConsumerKey,$sConsumerSecret,$sAccessToken,$sAccessTokenSecret);
    return $twObj;
  }
}