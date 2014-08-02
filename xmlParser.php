<?php
//コストコのgooglealertを読み込んでシリアライズしてcostco.txtとして保存
class parseXML {
  public function loadXML() {
    $xml = simplexml_load_file('https://www.google.com/alerts/feeds/05546308791182870999/12557010243017956011');
    foreach($xml->entry as $value) {
      $result[] = array('title' => (string)$value->title, 
        'link' => (string)$value->link, 
        'updated' => (string)$value->updated
      );
    }

    $fileAccess = fopen('costco.txt', 'w');
    fwrite($fileAccess, serialize($result));
    fclose($fileAccess);
  }
}

$parseXML = new parseXML;
$parseXML->loadXML();
?>
