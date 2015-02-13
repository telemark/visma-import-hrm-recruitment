<?php

class Import {

	public $collection = "";

	public function __construct($collect) {
		try{
		$m = new MongoClient();
		Logger("INFO", "Connecting to database");
		$db = $m->{DB_NAME};
		$this->collection = $db->$collect;
		}catch(MongoException $mongoException){
			Logger("ERR", $mongoException);
			exit;
		}
	}

	function getUrl($url) {
		Logger("INFO", "Getting data from $url");
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			Logger("ERR", curl_error($ch));
		}
		curl_close($ch);
		if (empty($output)) {
			Logger("ERR", "No data from URL");
		}
		return $output;
	}

	function ifUp($test) {
		if ($test != "Pong!") {
			Logger("ERR", "Visma webservice down");
		} else {
			Logger("INFO", "Visma webservice up");
		}
	}


	function loadXml($string) {
		Logger("INFO", "Loading xml string");
		$output = simplexml_load_string($string) or Logger("ERR", "Cannot create object from XML");
		return $output;
	}

	function loadXmlFile($file) {
		Logger("INFO", "Loading xml-file: $file");
		$output = simplexml_load_file($file) or Logger("ERR", "Cannot create object from XML-file");
		return $output;
	}

        // Insert to mongo
        function mInsert($array) {
		// Insert array to database
		$this->collection->batchInsert($array);
		Logger("INFO", "Inserting to database");
	}

	function mDrop() {
		$this->collection->drop();
		Logger("INFO", "Dropping collection");

	}

	// Function to get recruitmenttext from opening
	function scrapeOpening($data) {
		$html = new simple_html_dom();
		$html->load($data);
		$single = $html->find('#OPENINGS_DESCRIPTION', 0);
		$output = array();
		$output['html'] = $single->innertext;
		$output['text'] = $single->plaintext;
		return $output;
	}


	// Output to json for debugging
	function outputJson($array) {
 		$json = json_encode($array, JSON_PRETTY_PRINT);
		echo $json;
		die();
	}

}
?>
