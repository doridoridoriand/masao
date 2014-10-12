<?php
require_once('./livedoorWeatherJSONParser.php');

class livedoorWeatherParser extends livedoorWeatherJSONParser {

  //一時細分区域の番号を入力すると、該当するXMLのURLを返す
  public function loadDefinitiedXML($targetSpotNumber) {
    $spotDefinitionListArray = parent::areaMapper();
    //var_dump($spotDefinitionListArray);
    for ($i = 0; $i < count($spotDefinitionListArray); $i++) {
      if ($spotDefinitionListArray[$i]['id'] == $targetSpotNumber) {
        $matched = preg_replace("/_/", ":", ($spotDefinitionListArray[$i]['source']));
      }
    }
    return $this->loadXML($matched);
  }

  private function generateDisasterXMLAccessURL($targetXML) {
  $baseURL = 'http://weather.livedoor.com/forecast/rss/';

    //防災情報関連
    //地震速報
    $earthQuake = 'earthquake.xml';
    //津波側方
    $tsunami = 'tsunami.xml';
    //火山情報
    $volucano = 'volcano.xml';
    //全国の警報・注意報発表情報
    $warningAllArea = 'warn.xml';

    switch ($targetXML) {
    case 'earthquake':
      $targetURL = $baseURL . $earthQuake;
      break;
    case 'tsunami':
      $targetURL = $baseURL . $tsunami;
      break;
    case 'volucano':
      $targetURL = $baseURL . $volucano;
      break;
    case 'warn':
      $targetURL = $baseURL . $warningAllArea;
      break;
    }
    return var_dump($targetURL);
  }

  private function loadXML($targetURL) {
    $xmlContentStream = file_get_contents($targetURL);
    var_dump(simplexml_load_string($xmlContentStream));
    //return simplexml_load_string($xmlContentStream);
  }
}
$livedoorWeatherParser = new livedoorWeatherParser;
//$livedoorWeatherParser->generateDisasterXMLAccessURL('tsunami');
$livedoorWeatherParser->loadDefinitiedXML('440030');