<?php
require_once('./livedoorWeatherJSONParser.php');

class livedoorWeatherParser extends livedoorWeatherJSONParser {

  //災害情報をとってくるのか、一時細分区域のXMLをとってくるのかを第一引数で判定し、
  //災害情報であれば、ターゲットのxml名'earthquake'とかを第二引数に入れる
  //一時細分区域の天気を持ってくるのであれば、第二引数に一時細分区域の値を代入する
  public function chiefManager($whichXML, $targetXML) {
    if ($whichXML == 'disaster') {
      $this->loadDisasterXML($targetXML);
    } else if ($whichXML == 'spotdefinition') {
      $this->loadSpotDefinitionXML($targetXML);
    }
  }

  //generateDisasterXMLAccessURL->loadXMLからパースしたXMLを読み取り、つぶやく内容を抽出し、配列として返す
  private function loadDisasterXML($targetXML) {
    $source = $this->loadXML($targetXML);
  }

  //loadDefinitedXML->loadXMLからパースしたXMLを読み取り、つぶやく内容を抽出し、配列として返す
  private function loadSpotDefinitionXML($targetSpot) {
    $source = $this->loadDefinitedXML($targetSpot);
    $weatherItemContents = $source->channel->item;
    for ($i = 0; $i < count($weatherItemContents); $i++) {
      $weatherContentsArray[] = array(
        'title' => (string)$weatherItemContents[$i]->title,
        'description' => (string)$weatherItemContents[$i]->description,
        'link' => (string)$weatherItemContents[$i]->link
      );
    }
    $this->saveParsedContent($targetSpot, $weatherContentsArray);
    //var_dump($weatherContentsArray);
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
    return $this->loadXML($targetURL);
  }

  //一時細分区域の番号を入力すると、該当するXMLのURLを返し、loadXML()に渡す
  public function loadDefinitedXML($targetSpotNumber) {
    $spotDefinitionListArray = parent::areaMapper();
    //var_dump($spotDefinitionListArray);
    for ($i = 0; $i < count($spotDefinitionListArray); $i++) {
      if ($spotDefinitionListArray[$i]['id'] == $targetSpotNumber) {
        $matched = preg_replace("/_/", ":", ($spotDefinitionListArray[$i]['source']));
      }
    }
    //var_dump($matched);
    return $this->loadXML($matched);
  }

  //第一引数にXMLのURLを渡されると、xMLをオブジェクトとして返す
  private function loadXML($targetURL) {
    $xmlContentStream = file_get_contents($targetURL);
    //var_dump(simplexml_load_string($xmlContentStream));
    return simplexml_load_string($xmlContentStream);
  }

  //それぞれの関数から渡された配列をシリアライズ化して渡す
  private function saveParsedContent($contentName, $sourceContent) {
    $fileAccess = fopen('../parseResultWeather/' . $contentName, 'w');
    fwrite($fileAccess, serialize($sourceContent));
    fclose($fileAccess);
  }
}
$livedoorWeatherParser = new livedoorWeatherParser;
//$livedoorWeatherParser->generateDisasterXMLAccessURL('tsunami');
//$livedoorWeatherParser->loadDefinitiedXML('440030');
$livedoorWeatherParser->chiefManager('spotdefinition', '440030');
