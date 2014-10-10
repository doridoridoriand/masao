<?php

class livedoorWeatherParser {

  public function loadXML($targetURL) {
  }

  public function generateDisasterXMLAccessURL($targetXML) {
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
}
$livedoorWeatherParser = new livedoorWeatherParser;
$livedoorWeatherParser->generateDisasterXMLAccessURL('tsunami');
