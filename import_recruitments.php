<?php
include("../credentials.php");
include("config.php");
include("import.class.php");
require("logger.class.php");

// Setting URLs
$test_url =  VISMA_BASE_URL . "/ping";
$recruitments_url = VISMA_BASE_URL . "/openings";

// Load xml-file
$import = new Import(RECRUITMENTS_COLLECTION);

// Check if Visma webservice is up
$test = $import->getUrl($test_url);
$import->ifUp($test);


// Load recruitments xml
$imp_str = $import->getUrl($recruitments_url);

// Load xml as simplexml array
$xml = $import->loadXml($imp_str);

// Loop through job openings
foreach($xml->opening as $opening) {

	// Skip internal openings
	if ($opening->internal == "true") {
		continue;
	}

	$job['jobid'] = (int) $opening->attributes()->jobId;
	Logger("INFO", "Found $job[jobid]");

	$job['companyName'] = (string) $opening->companyName;
	$job['locationId'] = (int) $opening->location->attributes()->id;
	$job['locationName'] = (string) $opening->location->attributes()->name;
	$job['published'] = (string) $opening->published;
	$job['deadline'] = (string) $opening->deadline;
	$job['title'] = (string) $opening->headline;
	$job['link'] = (string) $opening->link;
	$job['positionType'] = (string) $opening->positionType;

	$result[] = $job;

	unset($job);
}

/* Output json for debugging
$import->outputJson($result);
*/

// Drop collection
$import->mDrop();

// Insert array to database
$import->mInsert($result);

?>
