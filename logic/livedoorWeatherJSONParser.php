<?php

class livedoorWeatherJSONParser {

  //市町村コードとlivedoor天気予報APIの地点定義表との紐付けをおこなう。地点定義表はライブドアのRSSから読み取る
  //地点定義表の読み込みが読み込みに時間がかかるので、内部でオブジェクトとしてパース結果を保持する
  public function areaMapper() {
    $spotDefinitionList = 'http://weather.livedoor.com/forecast/rss/primary_area.xml';
    $parseURLEncoded = file_get_contents($spotDefinitionList);
    $parsedSource = simplexml_load_string(preg_replace("/<([^>]+?):(.+?)>/", "<$1_$2>", $parseURLEncoded), 'SimpleXMLElement', LIBXML_NOCDATA);

    foreach ($parsedSource->channel->ldWeather_source->pref as $value) {
      $prefectureContentArray[] = array(
        'pref' => (object)$value
        );
    }
    //var_dump($prefectureContentArray[0]['pref']->city[3]);
    for ($i = 0; $i < count($prefectureContentArray); $i++) {
      for ($j = 0; $j < count($prefectureContentArray[$i]['pref']->city); $j++) {
        $spotDefinitionListObjectArray[] = array(
          'city' => $prefectureContentArray[$i]['pref']->city[$j]);
      }
    }
    //var_dump($spotDefinitionListObjectArray[11]['city']['title']);
    for ($i = 0; $i < count($spotDefinitionListObjectArray); $i++) {
      $spotDefinitionListArray[] = array(
        'title'  => (string)$spotDefinitionListObjectArray[$i]['city']['title'],
        'id'     => (string)$spotDefinitionListObjectArray[$i]['city']['id'],
        'source' => (string)$spotDefinitionListObjectArray[$i]['city']['source']
        );
    }
      var_dump($spotDefinitionListArray);
  }
  //APIアクセスに使用するターゲットアドレスを都道府県番号から判定して生成する
  private function apiAccessAdressGenerator($targetArea) {
  }

}
$livedoorWeatherJSONParser = new livedoorWeatherJSONParser;
$livedoorWeatherJSONParser->areaMapper();