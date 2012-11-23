<!DOCTYPE html>
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

<html>

    <head>
        <title>Discover Me Semantically</title>
        <link rel="stylesheet" href="css/style.css" type="text/css">

        <link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.ez-pinned-footer.js"></script>

        <link href='css/prettify.css' type='text/css' rel='stylesheet' />
        <script type="text/javascript" src="js/prettify.js"></script>

        <script>
            $(window).resize(function() {
                $("#footer").pinFooter("relative");
            });

            $(document).ready(function() {
                $("#footer").pinFooter();
            });

        </script>

    </head>

<?php

include("readConf.php");

error_reporting(E_ALL);
$domain=getDomain("config.ini");

function fromURI($uri){
    global $domain;
    
    if (substr($uri, 0, strlen($domain) ) == $domain) {
    $uri = substr($uri, strlen($domain), strlen($uri) );
    } 
    
    return $uri;
}

$uri=$_GET['uri'];

$file=fromURI($uri);

// Remove file from server
unlink($file);

// Now ping URI to Sindice to get 404 error
// This removes the document from Sindice database
include("sindicePing.php");

doPing("",$uri);

?>

<body >

        <img class="topLogo" src="img/logo.png"/>
        <br><br><br><br>
        
        <center>
        The document <code><?php echo $uri ; ?></code> has been removed.
        <br><br>
        For more information about Sindice, see their <a href="http://sindice.com/main/about">about page</a>.
        
        </center>

    <div id="footer">
            <div class="footerWrapper">
                <div class="footerTDiv">
                    <table>
                        <tbody class="footerTBody">
                            <tr>
                                <td class="footerTableCell"><a class="footerLink" href="#">Source code @ github</a></td>
                                <td><img src="img/logoepsrc.jpg" /></td>
                                <td><img src="img/logoSerenA.png" /></td>
                                <td class="footerTableCell"><a class="footerLink" href="http://www.serena.ac.uk" target="_blank">What is SerenA?</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    
</body>
</html>