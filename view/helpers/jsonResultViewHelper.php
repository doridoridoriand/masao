<?php

require ('../../logic/jsonParser.php');

class jsonResultViewHelper {

	public function loadJSON() {
		$source = $jsonParser->parseJSON();
		var_dump($source);
	}
}

$jsonResultViewHelper = new jsonResultViewHelper;
$jsonResultViewHelper->loadJSON();
