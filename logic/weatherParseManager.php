<?php

require_once('./livedoorXmlParser.php');

class weattherParseManager {

  #livedoorXmlParseのラッパー地点定義表に掲載されているxmlを全てパースする
  public function loadAllSpotWeather() {
    $livedoorWeatherParser = new livedoorWeatherParser;
    $livedoorWeatherParser->chiefManager('allspotdefinition', NULL);
  }

  #livedoorXmlParserのラッパー災害情報を全てパースする
  public function loadAllDisaster() {
    $livedoorWeatherParser = new livedoorWeatherParser;
    $livedoorWeatherParser->chiefManager('alldisaster', NULL);
  }
}
$weatherParseManager = new weattherParseManager;
//$weatherParseManager->loadAllSpotWeather();
