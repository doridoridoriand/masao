<?php
/*
require('simple_html_dom.php');

$source = file_get_html('http://ja.wikipedia.org/wiki/%E3%83%95%E3%82%A1%E3%83%83%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%96%E3%83%A9%E3%83%B3%E3%83%89%E4%B8%80%E8%A6%A7');
//var_dump($source);

$listArray = $source->find('li');

var_dump($listArray);
*/

//$source = file_get_contents('http://ja.wikipedia.org/wiki/%E3%83%95%E3%82%A1%E3%83%83%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%96%E3%83%A9%E3%83%B3%E3%83%89%E4%B8%80%E8%A6%A7');
$source = file_get_contents('http://zozo.jp/brand/default.html?c=SwitchType&ts=2');

$DOMDocument = new DOMDocument();
$sourceHTML = $DOMDocument->loadHTML($source);
$sourceXML = $DOMDocument->saveXML($sourceHTML);

$xmlPHPArray = simple_xml_load_string($sourceXML);

var_dump($xmlPHPArray);

/*　やることwikipedia_brandList.txtから英語表記, 日本語表記というような構造を持つcsvを作成する。
*/
/*
$source = stream_get_contents(fopen('wikipedia_brandList.txt', 'r'), true);
var_dump($source);
fclose(fopen('wikipedia_brandList.txt', 'r'));
*/