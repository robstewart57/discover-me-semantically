<?php
/* This file stores the specified RDF content temporarily
   on the server, to be served to the browser, and is then
   immediately removed from the server. Typical usage: "Download my RDF file" button */

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("downloadFile.php");
include("include/Serializer.php");
define("RDFAPI_INCLUDE_DIR", "include/rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
include(RDFAPI_INCLUDE_DIR . "syntax/RdfSerializer.php");
include( RDFAPI_INCLUDE_DIR . 'vocabulary/RDFS_C.php');
include( RDFAPI_INCLUDE_DIR . 'vocabulary/DC_C.php');
include( RDFAPI_INCLUDE_DIR . 'vocabulary/FOAF_C.php');

header("Content-Type: application/rdf+xml");
header("Content-Disposition: attachment; filename=" . $_POST['fileName']);

saveToFile($_POST['rawRDF'], $_POST['fileName']);
readfile($_POST['fileLoc']);
unlink("rdf/" . $_POST['fileName']);

?>