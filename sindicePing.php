<!DOCTYPE html>
<!-- Taken from http://sindice.com/developers/pingApi -->

<?php

function doPing($title, $URI) {
    
    include("include/xmlrpc.inc");
    
    $client = new xmlrpc_client("http://sindice.com/xmlrpc/api");
    $payload = new xmlrpcmsg("weblogUpdates.ping");
   
    $payload->addParam(new xmlrpcval($title));
    $payload->addParam(new xmlrpcval($URI));
   
    $response = $client->send($payload);
    $xmlresponsestr = $response->serialize();
   
    $xml = simplexml_load_string($xmlresponsestr);
    $result = $xml->xpath("//value/boolean/text()");
     if($result) {
        if($result[0] == "0"){
	  // echo "<p>Submitting $URI to $servicetitle succeeded.</p>";
            return;
        }
    }
    else {
        $err = "Error Code: " 
        .$response->faultCode() 
        ."<br /> Error Message: " 
        .$response->faultString();
        // echo "<p>Failed to submit $URI to $servicetitle.</p>";
    }
}

?>
