<?php

function saveToFile($rawRDF, $fileName) {
  $myFile = "./rdf/" . $fileName;
  $fh = fopen($myFile, 'w') or die("can't open file");
  fwrite($fh, urldecode($rawRDF));
  fclose($fh);
}

?>