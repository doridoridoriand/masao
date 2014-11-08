<?php

require ('./twitterPoster.php');
require ('./livedoorWeatherJSONParser.php');

class tsubuyakiManager {

  public function chiefManager($postContentSelectFlag) {
    if ($postContentSelectFlag == 'news') {
      $this->newsPoster();
    } else if ($postContentSelectFlag == 'weather') {
      $this->weatherPoster();
    }
  }

  //acocuntList.csvからつぶやくのに必要な$sConsumerKey,$sConsumerSecret,$sAccessToken,$sAccessTokenSecretを
  //読みとり、さらにコンテンツ名を読み取って、poster関数に入れる
  private function newsPoster() {
    $source = $this->loadAccountList();

    for ($i = 0; $i < count($source); $i++) {
      $twitterposter = new twitterPoster;
      $twitterposter->poster($source[$i][0],
                             $source[$i][1],
                             $source[$i][2],
                             $source[$i][3],
                             $source[$i][4],
                             NULL,
                             'news');
    }
  }

  private function weatherPoster() {
    $accountList = $this->loadAccountList();
    $parseList = $this->loadParseList();
    //var_dump($parseList);
    foreach ($parseList as $element) {
      //var_dump($element[0]);
      // メモ
      //　本来は市町村コードに基づいてAPIのエンドポイントを生成してJSONを読み取る様な実装にしていたけれど、
      // レスポンスに時間が掛かるのと、本当に全部の天気がとれているのか確認できないので実装を変更。
      // 元から実装してあったJSONをシリアライズ化して保存するのを利用して
      //$livedoorWeatherJSONParser = new livedoorWeatherJSONParser;
      //$content = $livedoorWeatherJSONParser->jsonContentDiscriptionReader($element[0]);

      //var_dump($accountList);
      for ($i = 0; $i < count($accountList); $i++) {
        $twitterposter = new twitterPoster;
        $twitterposter->poster($accountList[$i][0],
                               $accountList[$i][1],
                               $accountList[$i][2],
                               $accountList[$i][3],
                               $accountList[$i][4],
                               $parseList[$i][0],
                               'weather');
      }
    }
  }

  private function loadAccountList() {
    $accountListSource = fopen('./accountList.csv', 'r');
    $accountListArray = array();

    while ($accountList = fgetcsv($accountListSource)) {
      array_push($accountListArray, $accountList);
    }
    unset($accountList);
    return $accountListArray;
  }

  private function loadParseList() {
    $source = fopen('../parseList.csv', 'r');
    $parseListArray = array();

    while ($parseList = fgetcsv($source)) {
      array_push($parseListArray, $parseList);
    }
    unset($parseList);
    return $parseListArray;
  }

}

$tsubuyakiManager = new tsubuyakiManager;
$tsubuyakiManager->chiefManager('news');
//$tsubuyakiManager->chiefManager('weather');
