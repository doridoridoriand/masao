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
    } else if ($whichXML == 'allspotdefinition') {
      $this->loadAllSpotDefinitedXML();
    } else if ($whichXML == 'alldisaster') {
      $this->loadAllDisasterXML();
    }
  }

  //generateDisasterXMLAccessURL->loadXMLからパースしたXMLを読み取り、つぶやく内容を抽出し、配列として返す
  private function loadDisasterXML($targetXML) {
    $source = $this->generateDisasterXMLAccessURL($targetXML);
    $contentItems = $source->channel->item;

    for ($i = 0; $i < count($contentItems); $i++) {
      $contentItemsArray[] = array(
        'title'    => (string)$contentItems[$i]->title,
        'link'     => (string)$contentItems[$i]->link,
        'category' => (string)$contentItems[$i]->category,
        'updated'  => (string)$contentItems[$i]->pubDate
      );
    }
    var_dump($contentItemsArray);
    $this->saveParsedContent($targetXML, $contentItemsArray);
  }

  //loadDefinitedXML->loadXMLからパースしたXMLを読み取り、つぶやく内容を抽出し、配列として返す
  private function loadSpotDefinitionXML($targetSpot) {
    $source = $this->loadDefinitedXML($targetSpot);
    $weatherItemContents = $source->channel->item;

    for ($i = 0; $i < count($weatherItemContents); $i++) {
      $weatherContentsArray[] = array(
        'title'       => (string)$weatherItemContents[$i]->title,
        'description' => (string)$weatherItemContents[$i]->description,
        'link'        => (string)$weatherItemContents[$i]->link,
        'updated'     => (string)$weatherItemContents[$i]->pubDate
      );
    }
    var_dump($weatherContentsArray);
    $this->saveParsedContent($targetSpot, $weatherContentsArray);
  }

  //一時細分区域の定義表に記載されている全ての地域のXMLを読み取り、細分区域の番号のloadspotdefinitionxml()に渡す
  private function loadAllSpotDefinitedXML() {
    $spotDefinitionListArray = $this->loadAreaMapper();

    foreach ($spotDefinitionListArray as $element) {
      $this->loadSpotDefinitionXML($element['id']);
    }
  }

  //全ての災害情報のXMLを取得する。loadDisasterXMLに対して順番にXMLを叩く
  private function loadAllDisasterXML() {
    $sourceArray = array('earthquake', 'tsunami', 'volucano', 'warn');

    foreach ($sourceArray as $element) {
      $this->loadDisasterXML($element);
    }
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
  private function loadDefinitedXML($targetSpotNumber) {
    $spotDefinitionListArray = $this->loadAreaMapper();
    for ($i = 0; $i < count($spotDefinitionListArray); $i++) {
      if ($spotDefinitionListArray[$i]['id'] == $targetSpotNumber) {
        $matched = preg_replace("/_/", ":", ($spotDefinitionListArray[$i]['source']));
      }
    }
    return $this->loadXML($matched);
  }

  //第一引数にXMLのURLを渡されると、xMLをオブジェクトとして返す
  private function loadXML($targetURL) {
    $xmlContentStream = file_get_contents($targetURL);
    return simplexml_load_string($xmlContentStream);
  }

  //それぞれの関数から渡された配列をシリアライズ化して渡す
  private function saveParsedContent($contentName, $sourceContent) {
    $fileAccess = fopen('../parseResultWeather/' . $contentName, 'w');
    fwrite($fileAccess, serialize($sourceContent));
    fclose($fileAccess);
  }

  private function loadAreaMapper() {
    $spotDefinitionListArray = parent::areaMapper();
    return $spotDefinitionListArray;
  }
}
$livedoorWeatherParser = new livedoorWeatherParser;
//$livedoorWeatherParser->chiefManager('spotdefinition', '440030');
//$livedoorWeatherParser->chiefManager('disaster', 'volucano');
//$livedoorWeatherParser->chiefManager('allspotdefinition', NULL);
$livedoorWeatherParser->chiefManager('alldisaster', NULL);
