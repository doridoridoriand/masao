<?php

require('simple_html_dom.php');

$source = file_get_html('http://ja.wikipedia.org/wiki/%E3%83%95%E3%82%A1%E3%83%83%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%96%E3%83%A9%E3%83%B3%E3%83%89%E4%B8%80%E8%A6%A7');
//var_dump($source);

$listArray = $source->find('ul', 0)->find('li', 0)->find('text');

var_dump($listArray[0]);

