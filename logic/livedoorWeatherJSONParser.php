<?php

class livedoorWeatherJSONParser {

  //市町村コードとlivedoor天気予報APIの地点定義表との紐付けをおこなう。地点定義表はライブドアのRSSから読み取る
  //地点定義表の読み込みが読み込みに時間がかかるので、内部でオブジェクトとしてパース結果を保持する
  public function areaMapper() {
    $spotDefinitionList = 'http://weather.livedoor.com/forecast/rss/primary_area.xml';
    $parseURLEncoded = file_get_contents($spotDefinitionList);
    $parsedSource = simplexml_load_string(preg_replace("/<([^>]+?):(.+?)>/", "<$1_$2>", $parseURLEncoded), 'SimpleXMLElement', LIBXML_NOCDATA);
    $contentArray = array();

    foreach ($parsedSource->channel->ldWeather_source->pref as $value) {
      //var_dump($value->city);
      foreach ($value->city as $element) {
        array_push($contentArray, (array)$value);
      }
    }
 //   var_dump($contentArray[0]['city'][0]['id']);
 //   foreach ($contentArray) {
 //     $spotDefinitionListArray[] = array(
 //       ''
  }

  //APIアクセスに使用するターゲットアドレスを都道府県番号から判定して生成する
  private function apiAccessAdressGenerator($targetArea) {
  }

}
$livedoorWeatherJSONParser = new livedoorWeatherJSONParser;
$livedoorWeatherJSONParser->areaMapper();
