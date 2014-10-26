<?php

class livedoorWeatherJSONParser {

  //APIアクセスに使用するターゲットアドレスを都道府県番号から判定して生成する
  public function apiAccessAdressGenerator($targetArea) {
    $spotDefinitionArray = $this->areaMapper();
    $endpoint = '';
  }

  public function jsonContentDiscriptionReader($targetCityNumber) {
    $sourceJSON = $this->loadWeatherJSON($targetCityNumber);
    //var_dump($sourceJSON->description->text);
    $contentDescription = $sourceJSON->description->text;
    $contentLink = $sourceJSON->link;
    $modifiedDescription = mb_substr($contentDescription, 0, 100, 'UTF-8') . '…';
    return $modifiedDescription . " " . $contentLink;
  }

  private function loadWeatherJSON($targetCityNumber) {
    $endpoint = 'http://weather.livedoor.com/forecast/webservice/json/v1?city=';
    //var_dump($endpoint . $targetCityNumber);
    return json_decode(stream_get_contents(fopen($endpoint . $targetCityNumber, 'r')));
  }

  //市町村コードとlivedoor天気予報APIの地点定義表との紐付けをおこなう。地点定義表はライブドアのRSSから読み取る
  //地点定義表の読み込みが読み込みに時間がかかるので、内部でオブジェクトとしてパース結果を保持する
  private function areaMapper() {
    $spotDefinitionList = 'http://weather.livedoor.com/forecast/rss/primary_area.xml';
    $parseURLEncoded = file_get_contents($spotDefinitionList);
    $parsedSource = simplexml_load_string(preg_replace("/<([^>]+?):(.+?)>/", "<$1_$2>", $parseURLEncoded), 'SimpleXMLElement', LIBXML_NOCDATA);

    foreach ($parsedSource->channel->ldWeather_source->pref as $value) {
      $prefectureContentArray[] = array(
        'pref' => (object)$value
        );
    }
    for ($i = 0; $i < count($prefectureContentArray); $i++) {
      for ($j = 0; $j < count($prefectureContentArray[$i]['pref']->city); $j++) {
        $spotDefinitionListObjectArray[] = array(
          'city' => $prefectureContentArray[$i]['pref']->city[$j]);
      }
    }
    for ($i = 0; $i < count($spotDefinitionListObjectArray); $i++) {
      $spotDefinitionListArray[] = array(
        'title'  => (string)$spotDefinitionListObjectArray[$i]['city']['title'],
        'id'     => (string)$spotDefinitionListObjectArray[$i]['city']['id'],
        'source' => (string)$spotDefinitionListObjectArray[$i]['city']['source']
        );
    }
    return $spotDefinitionListArray;
  }
}
//$livedoorWeatherJSONParser = new livedoorWeatherJSONParser;
//$livedoorWeatherJSONParser->apiAccessAdressGenerator();
//$livedoorWeatherJSONParser->jsonContentDiscriptionReader('011000');
