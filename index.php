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

                var addInterestFunc = function() {
                    var i = interestsArray.length + 1;
                    var interestField = "personal_interest" + i;
                    var newRow = $("<tr><td>"+i+") </td><td><input id=\"" + interestField + "\" name=\"" + interestField + "\" size=\"40\" /></td></tr>");
                    personalInterestsTable.append(newRow);
                    interestsArray.push( { item: i, field: interestField } );
                    document.getElementById('interests_serialized').value=encodeURIComponent(JSON.stringify(interestsArray));
                    $("input#" + interestField).autocomplete( autoCompleteDBpediaConfig );
                }

                var addExpertiseFunc = function() {
                    var i = expertiseArray.length + 1;
                    var expertiseField = "professional_expertise" + i;
                    var newRow = $("<tr><td>"+i+") </td><td><input id=\"" + expertiseField + "\" name=\"" + expertiseField + "\" size=\"40\" /></td></tr>");
                    professionalExpertiseTable.append(newRow);
                    expertiseArray.push( { item: i, field: expertiseField } );
                    document.getElementById('expertise_serialized').value=encodeURIComponent(JSON.stringify(expertiseArray));
                    $("input#" + expertiseField).autocomplete( autoCompleteDBpediaConfig );
                }

                var addGoalFunc = function() {
                    var i = goalsArray.length + 1;
                    var goalOptionField = "goalOption" + i;
                    var goalTextField = "goalText" + i;

                    var newRow = $("<tr><td><select name=\"" + goalOptionField + "\" id=\"" + goalOptionField + "\" ></td><td><input id=\"" + goalTextField + "\" name=\""+ goalTextField + "\" size=\"30\" /></td></tr>");
                    goalsTable.append(newRow);

                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalFindOutAbout\">find out about</option>");
                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalMeet\">meet</option>");
                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalAttendConference\">attend conference</option>");
                    $('#'+goalOptionField).append("<option value=\"http://www.serena.ac.uk/property/goalVisitPlace\">visit place</option>");

                    goalsArray.push( { item: i, goalType: goalOptionField, field: goalTextField } );
                    document.getElementById('goals_serialized').value=encodeURIComponent(JSON.stringify(goalsArray));
                    var optionBox=jQuery("#" + goalOptionField);
                    /* var textBox=jQuery("#" + goalTextField);  */
                    goalOptionsMap[goalOptionField]=goalTextField;
                    optionBox.change( goalChanged );
                    optionBox.trigger('change');
                }
                
                $("input#autocomplete").autocomplete( autoCompleteDBpediaConfig );
                $("input#institute").autocomplete( autoCompleteDBpediaConfig );
                $("input#location").autocomplete( autoCompleteDBpediaLocationConfig );
                $("input#dblp_uri").autocomplete( autoCompleteDBLPAuthorConfig ); 

                $("#btnAddInterest").ready( addInterestFunc );
                $("#btnAddExpertise").ready( addExpertiseFunc );
                $("#btnAddGoal").ready( addGoalFunc );

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

    </head>

    <body>

        <form name="input" action="process.php" method="post" >

            <img class="topLogo" src="img/logo.png"/>


            <table class="inputTable">

                <tr>

                    <td class="mainTableCell">

                        <h3>About Me</h3>

                        <table>
                            <tr>
                                <td>Name:</td><td><input id="name" name="name" /></td>
                            </tr>
                            <tr>
                                <td>Institute:</td><td><input id="institute" name="institute" size="40" /></td>
                            </tr>
                            <tr>
                                <td>Homepage:</td><td><input id="homepage" name="homepage" size="40" /></td>
                            </tr>

                            <tr>
                                <td>Location:</td><td><input id="location" name="location" size="40" /></td> 
                            </tr>

                            <tr>
                                <td>DBLP:</td><td><input id="dblp_uri" name="dblp_uri" size="40" /></td>
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