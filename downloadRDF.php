<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("include/Serializer.php");
define("RDFAPI_INCLUDE_DIR", "include/rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
include(RDFAPI_INCLUDE_DIR . "syntax/RdfSerializer.php");
include( RDFAPI_INCLUDE_DIR . 'vocabulary/RDFS_C.php');
include( RDFAPI_INCLUDE_DIR . 'vocabulary/DC_C.php');
include( RDFAPI_INCLUDE_DIR . 'vocabulary/FOAF_C.php');

header("Content-Type: application/rdf+xml");
header("Content-Disposition: attachment; filename=" . $_POST['fileName']);

function saveToFile($rawRDF, $fileName) {

  $myFile = "rdf/" . $fileName;
  $fh = fopen($myFile, 'w') or die("can't open file");
  fwrite($fh, urldecode($rawRDF));
  fclose($fh);
}

saveToFile($_POST['rawRDF'], $_POST['fileName']);

readfile($_POST['fileLoc']);

unlink("rdf/" . $_POST['fileName']);
?>