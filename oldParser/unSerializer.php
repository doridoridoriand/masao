<?php
//シリアライズ化されたcostxo.txtのデーターをアンシリアライズしてphpの配列に戻す
class unSerialize {
  public function unSerialize() {
    $source = fopen('costco.txt', 'r');
    $content = fread($source, filesize('costco.txt'));
    $phparr = unserialize($content);
    fclose($source);
    var_dump($phparr);
  }
}

$unSeriarize = new unSerialize;
$unSeriarize->unSerialize();
