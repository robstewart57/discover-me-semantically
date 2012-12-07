<!--
Copyright (C) 2012  Rob Stewart <robstewart57@gmail.com>, SerenA <http://www.serena.ac.uk>

This file is part of Discover-me-Semantically.

Discover-me-Semantically is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>
-->

   <?php
   
   error_reporting(E_ALL);
              setlocale(LC_ALL, 'en_US.UTF8'); // for toAscii function
              
              include("include/Serializer.php");
              define("RDFAPI_INCLUDE_DIR", "include/rdfapi-php/api/");
              include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
              include(RDFAPI_INCLUDE_DIR . "syntax/RdfSerializer.php");
              include( RDFAPI_INCLUDE_DIR . 'vocabulary/RDFS_C.php');
              include( RDFAPI_INCLUDE_DIR . 'vocabulary/DC_C.php');
              include( RDFAPI_INCLUDE_DIR . 'vocabulary/FOAF_C.php');
              include("readConf.php");
              
              $domain=getDomain("config.ini");
              
function toAscii($str, $replace = array(), $delimiter = '-') {
  if (!empty($replace)) {
    $str = str_replace((array) $replace, ' ', $str);
  }
                
  $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
  $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
  $clean = strtolower(trim($clean, '-'));
  $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

  return $clean;
}

function generateFileName($name) {
  $i = 0;
  $fname = toAscii($name . $i) . ".rdf";
  while (file_exists("rdf/" . $fname)) {
    $i++;
    $fname = toAscii($name . $i) . ".rdf";
  }
  return $fname;
}

function toSerenAURI($filename) {
  global $domain;
    
  return $domain."rdf/" . $filename;
}

function startsWith($haystack, $needle) {
  $length = strlen($needle);
  return (substr($haystack, 0, $length) === $needle);
}

function mapGoalFields($userURI, $varJS) {

  $encoded = urldecode($_POST[$varJS]);
  $json = json_decode($encoded, true);

  $stmts = array();
  $userRes = new resource($userURI);

  foreach ($json as $elem) {
    $goalPredicate = $_POST[$elem['goalType']];
    $propRes = new resource($goalPredicate);
    $goalURI = $_POST[$elem['field']];
    if ($goalURI != ''){
      if (startsWith($goalURI, "http://")) {
        $stmt = new Statement($userRes, $propRes, new resource($goalURI));
      }
      else {
        $stmt = new Statement($userRes, $propRes, new Literal($goalURI));
      }
      array_push($stmts, $stmt);
    }
  }
  return $stmts;
}

function mapSingleFormField($userURI, $varJS, $property, $prepend, $isURI) {

  $stmts = array();

  $userRes = new resource($userURI);
  $propRes = new resource($property);
  $obj = $_POST[$varJS];

  $objURI = $prepend . $obj;
  if ($objURI != '') {
    if ($isURI){
      if (startsWith($objURI, "http://") || startsWith($objURI, "https://") || startsWith($objURI, "mailto:")) {
        $stmt = new Statement($userRes, $propRes, new resource($objURI));
        array_push($stmts, $stmt);
      }
    }
    else {
      $stmt = new Statement($userRes, $propRes, new Literal($objURI));
      array_push($stmts, $stmt);
    }
  }
  return $stmts;
}

function mapSerializedFormField($userURI, $varJS, $property) {

  $encoded = urldecode($_POST[$varJS]);
  $json = json_decode($encoded, true);

  $stmts = array();
  $userRes = new resource($userURI);
  $propRes = new resource($property);

  foreach ($json as $elem) {
    $objURI = $_POST[$elem['field']];

    if ($objURI != ''){
      if (startsWith($objURI, "http://")) {
        $stmt = new Statement($userRes, $propRes, new resource($objURI));
      }
      else {
        $stmt = new Statement($userRes, $propRes, new Literal($objURI));
      }
      array_push($stmts, $stmt); 
    }
  }
  return $stmts;
}

// $model is mutable.
function addStmtsToModel($model, $stmts) {
  foreach ($stmts as $stmt) {
    $model->add($stmt);
  }
}

define("FOAF", "http://xmlns.com/foaf/0.1/");
define("CCO", "http://purl.org/ontology/cco/mappings#");
define("SERENA", "http://www.serena.ac.uk/property/");
define("RDFS", "http://www.w3.org/2000/01/rdf-schema#");
define("RDF", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
define("OWL", "http://www.w3.org/2002/07/owl#");


$model = ModelFactory::getDefaultModel();

$name = $_POST["name"];

$fileName = generateFileName($name);
$userURI = toSerenAURI($fileName);

$stmtsAll = array();

/* First specify foaf:Person type */
$subjRes = new resource($userURI);
$predicateRes = new resource(RDF . "type");
$objRes = new resource(FOAF . "Person");
$stmt = new Statement($subjRes,$predicateRes,$objRes);
$stmtsAll = array($stmt);

/* Now get the singleton fields from the form */
$stmts = mapSingleFormField($userURI, "name", FOAF . "name", "", false);
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSingleFormField($userURI, "name", RDFS . "label", "", false);
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSingleFormField($userURI, "institute", FOAF . "Organization", "", true);
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSingleFormField($userURI, "homepage", FOAF . "homepage", "", true);
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSingleFormField($userURI, "location", FOAF . "based_near", "", true);
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSingleFormField($userURI, "dblp_uri", OWL . "sameAs", "", true);
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSingleFormField($userURI, "about_me_text", RDFS . "comment", "", false);
$stmtsAll = array_merge($stmtsAll, $stmts);


/* Now for the properties that can have multiple instances */
$stmts = mapSerializedFormField($userURI, "interests_serialized", CCO . "interest");
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSerializedFormField($userURI, "expertise_serialized", CCO . "expertise");
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSerializedFormField($userURI, "findOutAbout_serialized", SERENA . "goalFindOutAbout");
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSerializedFormField($userURI, "meetPerson_serialized", SERENA . "goalMeet");
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSerializedFormField($userURI, "attendConf_serialized", SERENA . "goalAttendConference");
$stmtsAll = array_merge($stmtsAll, $stmts);

$stmts = mapSerializedFormField($userURI, "visitPlace_serialized", SERENA . "goalVisitPlace");
$stmtsAll = array_merge($stmtsAll, $stmts);


addStmtsToModel($model, $stmtsAll);

$ser = new RdfSerializer();
$ser->addNamespacePrefix("foaf", FOAF);
$ser->addNamespacePrefix("cco", CCO);
$ser->addNamespacePrefix("serena", SERENA);
$ser->addNamespacePrefix("rdfs", RDFS);
$ser->addNamespacePrefix("rdf", RDF);
$ser->addNamespacePrefix("owl", OWL);

$rawRDF = $ser->serialize($model);

$ser->saveAs($model, $fileName);

$options = array(
                 "indent" => "    ",
                 "linebreak" => "\n",
                 "typeHints" => false,
                 "addDecl" => true,
                 "encoding" => "UTF-8",
                 "rootName" => "rdf:RDF",
                 "rootAttributes" => array("version" => "0.91"),
                 "defaultTagName" => "item",
                 "attributesArray" => "_attributes"
                 );

$serializer = new XML_Serializer($options);
$serializer->serialize($rawRDF);
$serializedRDF = $serializer->getSerializedData();

?>
