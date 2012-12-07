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
        <link rel="icon"  type="image/png" href="img/serena_logo.png">
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


    <body >

<a href="https://github.com/robstewart57/discover-me-semantically" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub"></a>

        <img class="topLogo" src="img/logo.png"/>

        <div class="centerDiv">
            <h3>Step 1 - Download the RDF file</h3>

            <div class="centerButton">
                <form name="input" target="_blank" action="downloadRDF-ToBrowserMemory.php" method="post" >

                    <input type="hidden" name="fileName" id="fileName" value="<?php echo $_POST['fileName']; ?>">
                    <input type="hidden" name="fileLoc" id="fileLoc" value="<?php echo $_POST['fileLoc']; ?>">
                    <input type="hidden" name="rawRDF" id="rawRDF" value="<?php echo $_POST['rawRDF']; ?>">

                    <button type="submit" id="btnDownload">Download RDF</button>

                </form>
            </div>

            <h3>Step 2 - Edit the document URI</h3>

            ... to where ever you save your RDF file to e.g.  <code>http://www.mydomain.com/joe-bloggs.rdf</code>
            <br><br>
            <img class="something" src="img/rdf_output.png" />
        </div>


<?php
   include("footer.php");
?>

    </body>
</html>