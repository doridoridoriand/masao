<?php

class livedoorWeatherJSONParser {

  //APIアクセスに使用するターゲットアドレスを都道府県番号から判定して生成する
  public function apiAccessAdressGenerator($targetArea) {
    $spotDefinitionArray = $this->areaMapper();
    $endpoint = '';
  }

  //市町村コードを引数とし、generateprimarysubdivisionareacode()でアクセス先のAPIを作成->loadweatherjson()で必要なdescriptionを読み取り、
  //読み取り先のページのリンクを付与して、stringとして返す
  //市町村コードで指定できない(一時細分区域のような独自の数字になっている)ので、暫定的に一時細分区域のコードを生成する処理をはさんでいる
  public function jsonContentDiscriptionReader($targetCityNumber) {
    $sourceJSON = $this->loadWeatherJSON($this->generatePrimarySubdivisionAreaCode($targetCityNumber));
    $contentDescription = $sourceJSON->description->text;
    $contentLink = $sourceJSON->link;
    $modifiedDescription = mb_substr($contentDescription, 0, 100, 'UTF-8') . '…';

    //var_dump( '【今日の天気】' . $modifiedDescription . " " . $contentLink);
    return '【今日の天気】' . $modifiedDescription . " " . $contentLink;
  }

  //機械的に一次細分区域を生成。一次細分区域の番号に一部イレギュラーな部分があるので、これを条件分岐で処理する。
  //それ以上の細分化は今のところ対応できない
  private function generatePrimarySubdivisionAreaCode($targetCityNumber) {
    
    $prefectureNumber = substr($targetCityNumber, 0, strlen($targetCityNumber) - 4);

    switch ($prefectureNumber) {
      case 01:
        $targetAreaCode = $prefectureNumber . '1000';
        break;
      case 27:
        $targetAreaCode = $prefectureNumber . '0000';
        break;
      case 47:
        $targetAreaCode = $prefectureNumber . '1010';
        break;
      default:
        $targetAreaCode = $prefectureNumber . '0010';
        break;
    }

    return $targetAreaCode;
  }

  private function loadWeatherJSON($targetCityNumber) {
    $endpoint = 'http://weather.livedoor.com/forecast/webservice/json/v1?city=';
    return json_decode(stream_get_contents(fopen($endpoint . $targetCityNumber, 'r')));
  }

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
//$livedoorWeatherJSONParser->jsonContentDiscriptionReader('201000');
