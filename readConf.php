<?php

function getDomain($file){
  $domain = "";

  if (file_exists($file) && is_readable($file))
    {
      $settings=parse_ini_file($file);
      $domain=$settings["domain"];
      
    }
  else
    {
      // If the configuration file does not exist or is not readable, DIE php DIE!
      die("Sorry, the $file file doesnt seem to exist or is not readable!");
    }
  return $domain;
}

?>