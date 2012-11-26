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
        <link rel="stylesheet" href="css/style.css">

        <link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/urlEncode.js"></script>
        <script src="js/jquery.ez-pinned-footer.js"></script>

        <link href="css/prettify.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="js/prettify.js"></script>
        <script type="text/javascript" src="js/jquery.infieldlabel.js"></script>

        <script>            
            var goalOptionsMap = {};
        </script>

        <script type="text/javascript" src="js/auto-complete-configs.js"></script>

        <script>

            $(document).ready(function() {

		var interestsArray = new Array();
		var expertiseArray = new Array();
		var goalsArray = new Array();
                
                var personalInterestsTable = $("#tableInterests");
                var professionalExpertiseTable = $("#tableExpertise");
                var goalsTable = $("#tableGoals");

                var addExpertiseFunc = function() {
                      addElem(expertiseArray,
                              "expertise_serialized",
                              "professional_expertise",
                              "expertiseLbl",
                              "Add an area of expertise...",
                              professionalExpertiseTable,
                              autoCompleteDBpediaConfig);
                    };
                
                var addInterestFunc  = function() {
                      addElem(interestsArray,
                              "interests_serialized",
                              "personal_interest",
                              "interestLbl",
                              "Add an interest...",
                              personalInterestsTable,
                              autoCompleteDBpediaConfig);
                    };

                function addElem(arrayVal, serializedArray, fieldVal, labelVal, inputText, tableVal, autoCompleteCfg){
                    var i = arrayVal.length + 1;
                    var fieldVar = fieldVal + i;
		    var labelVar = labelVal + i;
                    var newRow = $("<tr><td>"+i+") </td><td><p><input id=\"" + fieldVar + "\" name=\"" + fieldVar + "\" size=\"50\" type=\"text\"/><label id=\"" + labelVar + "\" for=\"" + fieldVar + "\">" + inputText + "</label></p></td></tr>");
                    tableVal.append(newRow);
                    arrayVal.push( { item: i, field: fieldVar } );
                    document.getElementById(serializedArray).value=encodeURIComponent(JSON.stringify(arrayVal));
                    $("input#" + fieldVar).autocomplete( autoCompleteCfg );
		    $("#" + labelVar).inFieldLabels();
                }

                var addGoalFunc = function() {
                    var i = goalsArray.length + 1;
                    var goalOptionField = "goalOption" + i;
                    var goalTextField = "goalText" + i;

                    var newRow = $("<tr><td><select name=\"" + goalOptionField + "\" id=\"" + goalOptionField + "\" ></td><td><input id=\"" + goalTextField + "\" name=\""+ goalTextField + "\" size=\"30\" class=\"auto-hint\" /></td></tr>");
                    goalsTable.append(newRow);

                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalFindOutAbout\">find out about</option>");
                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalMeet\">meet</option>");
                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalAttendConference\">attend conference</option>");
                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalVisitPlace\">visit place</option>");

                    goalsArray.push( { item: i, goalType: goalOptionField, field: goalTextField } );
                    document.getElementById('goals_serialized').value=encodeURIComponent(JSON.stringify(goalsArray));
                    var optionBox=jQuery("#" + goalOptionField);
                    goalOptionsMap[goalOptionField]=goalTextField;
                    optionBox.change( goalChanged );
                    optionBox.trigger('change');
                }
                
                /* $("input#autocomplete").autocomplete( autoCompleteDBpediaConfig ); */
                $("input#institute").autocomplete( autoCompleteDBpediaConfig );
                $("input#location").autocomplete( autoCompleteDBpediaLocationConfig );
                $("input#dblp_uri").autocomplete( autoCompleteDBLPAuthorConfig ); 

		/* Add the grey input prompts to all input text boxes */
		$("label").inFieldLabels();

                $("#btnAddInterest").ready( addInterestFunc );
                $("#btnAddExpertise").ready( addExpertiseFunc );
                $("#btnAddGoal").ready( addGoalFunc );

		/* Create one input box for each */
                $("#btnAddInterest").click( addInterestFunc );
                $("#btnAddExpertise").click( addExpertiseFunc );
                $("#btnAddGoal").click( addGoalFunc );

                /* Used to pin footer */
                $(window).resize(function() {
                    $("#footer").pinFooter("relative");
                });

                $('#dblp_uri').focus(function () {
                    var elemName = jQuery("#name") ;
                    jQuery("#dblp_uri").val(elemName.val());
                    jQuery("#dblp_uri").trigger("keydown");
                });
                
                $("#footer").pinFooter();

            });


        </script>

<script type="text/javascript">
			    
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-4596898-5']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

    </head>

    <body>

<a href="https://github.com/robstewart57/discover-me-semantically" target="_blank"><img style="z-index: 5; position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub"></a>

        <form name="input" id="inputForm" action="process.php" method="post" >

            <img class="topLogo" src="img/logo.png"/>

            <table class="inputTable">

                <tr>

                    <td class="mainTableCell">

                        <h3>About Me</h3>

                        <table>
                            <tr>
                                <td>Name:</td><td>
                     <p>
                     <input id="name" name="name" type="text" size="50" />
                     <label for="name">Your full name...</label>
                     </p>
                                </td>
                            </tr>
                            <tr>
                                <td>Institute:</td><td>
                     <p>
                     <input id="institute" name="institute" size="50" type="text" />
                     <label for="institute">Your academic institute...</label>
                     </p>
                                </td>
                            </tr>
                            <tr>
                                <td>Homepage:</td><td>
                      <p>
                      <input id="homepage" name="homepage" size="50" type="text"/>
                      <label for="homepage">http://</label>
                      </p>
                                </td>
                            </tr>

                            <tr>
                                <td>Location:</td><td>
                      <p>
                      <input id="location" name="location" size="50" type="text" />
                      <label for="location">Where do you live...</label>
                      </p>
                                </td> 
                            </tr>

                            <tr>
                                <td>DBLP:</td><td>
                      <p>
                      <input id="dblp_uri" name="dblp_uri" size="50" type="text"/>
                      <label for="dblp_uri">Search for your DBLP URI by name...</label>
                      </p>
                                </td>
                            </tr>
                        </table>
                        <br>

                        <h3>Text about me</h3>

                        <textarea rows="4" cols="40" id="about_me_text" name="about_me_text" ></textarea>

                    </td>

                    <td class="mainTableCell">

                        <h3>Professional Expertise</h3>

                        Enter your areas of expertise...
                        <table id="tableExpertise"></table>

                        <button type="button" id="btnAddExpertise">Add another...</button>

                        <br><br>

                        <h3>Personal and/or Academic Interests</h3>

                        Enter your areas of interest...
                        <table id="tableInterests">
                        </table>

                        <button type="button" id="btnAddInterest">Add another...</button>

                        <br><br>

                        <h3>Goals</h3>
                        I would like to...
                        <table id="tableGoals"></table>

                        <button class="styled-button" type="button" id="btnAddGoal">Add another...</button>

                        <br><br>

                        <input type="hidden" name="interests_serialized" id="interests_serialized" value="">
                        <input type="hidden" name="expertise_serialized" id="expertise_serialized" value="">
                        <input type="hidden" name="goals_serialized" id="goals_serialized" value="">

                    </td>
                </tr>
            </table>

            <br>

            <!-- Keeping this separate as I amm pinning the "Process" button to the footer -->
            <div id="footer">
            <div class="footerWrapper">
                <div class="footerTDiv">
                    <table>
                        <tbody class="footerTBody">
                            <tr>
                                <td colspan="4" class="footerTableCell">
                                <input class="inputProcess" type="submit" value="Process" />
                                </td>
                            </tr>
                            <tr>
                                <td class="footerTableCell"><a class="footerLink" target="_blank" href="https://github.com/robstewart57/discover-me-semantically">Source code @ github</a></td>
                                <td><img src="img/logoepsrc.jpg" /></td>
                                <td><img src="img/logoSerenA.png" /></td>
                                <td class="footerTableCell"><a class="footerLink" href="http://www.serena.ac.uk" target="_blank">What is SerenA?</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </form>

    </body>

</html>