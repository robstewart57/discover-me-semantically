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

include("downloadFile.php");
include("readConf.php");
error_reporting(E_ALL);
$domain=getDomain("config.ini");

    saveToFile($_POST['rawRDF'], $_POST['fileName']);

    $uri = $_POST['fileLoc'];

    include("sindicePing.php");

    doPing("", $uri);
    ?>

    <body >

        <img class="topLogo" src="img/logo.png"/>
        <br><br><br><br>

        <div class="centerDiv">

            <h3>Confirmation</h3>
            <center>
                The document <a href="<?php echo $uri; ?>"> <?php echo $uri; ?> </a> has been added to Sindice.
            </center>

            <br><br>    

            <h3>What next?</h3>

            <h4>Find yourself on Sindice</h4>
            
		Go to <a target="_blank" href="http://sindice.com/">http://sindice.com/</a> and search for your document.
            <br><br>
            
            <h4>Remove your RDF from Sindice</h4>
            
            If you ever feel the need to remove your RDF document from Sindice, simply copy and paste this
            into your web browser:

            <center>
                <a href="<?php echo $domain . "remove-me.php?uri=" . $uri; ?>"><?php
    global $domain, $uri;
    echo $domain . "remove-me.php?uri=" . $uri;
    ?></a>
            </center>

        </div>


<?php
    include("footer.php");
?>


    </body>
</html>