/*
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
*/

function dbpediaGenericLookup(request, response) { 
    var uriArray = new Array();
    editBox = document.activeElement;
    var ID = editBox.id;
    var elem = jQuery("#"+ID) ;
    elem.addClass("ui-autocomplete-loading");
    jQuery.ajax({
        url: "http://lookup.dbpedia.org/api/search.asmx/PrefixSearch?QueryClass=&MaxHits=20&QueryString=" + jQuery("#"+ID).val(),
        dataType: "xml",
        success: function (xml) {
            $('ArrayOfResult',xml).children('Result').each(function(){
                var uri = decodeURI($(this).find(">URI").text());
                var lbl = $(this).find(">Label").text();
                var elem = {
                    value: uri, 
                    label: lbl
                }
                uriArray.push(elem);
            });
            response(uriArray);
            elem.removeClass("ui-autocomplete-loading");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            // alert(textStatus);
        }
    });
}


function dbpediaPlaceLookup(request, response) { 
    var uriArray = new Array();
    editBox = document.activeElement;
    var ID = editBox.id;
    var elem = jQuery("#"+ID) ;
    elem.addClass("ui-autocomplete-loading");
    jQuery.ajax({
        url: "http://lookup.dbpedia.org/api/search.asmx/PrefixSearch?QueryClass=Place&MaxHits=20&QueryString=" + jQuery("#"+ID).val(),
        dataType: "xml",
        success: function (xml) {
            $('ArrayOfResult',xml).children('Result').each(function(){
                var uri = decodeURI($(this).find(">URI").text());
                var lbl = $(this).find(">Label").text();
                var elem = {
                    value: uri, 
                    label: lbl
                }
                uriArray.push(elem);
            });
            response(uriArray);
            elem.removeClass("ui-autocomplete-loading");
        }
    });
}


function dblpAuthorLookup(request, response) {
    
    var uriArray = new Array();
    editBox = document.activeElement;
    //	     editBox
    var ID = editBox.id;
    var elem = jQuery("#"+ID) ;
    elem.addClass("ui-autocomplete-loading");     	     
	     
    var url = "http://api.sindice.com/v3/search?fq=class:foaf:Agent&format=json&fq=domain:dblp.l3s.de&field=link&q=" + elem.val();
    $.getJSON(url, function(data) {
		       
        $.each(data.entries, function(i, entry) {
            var uri = entry.link;
            var title = entry.title;
            var lbl = "";
            $.each(title, function(i, titleEntry) {
                lbl = titleEntry.value.replace(/"/g, "");
            });
            var elem = {
                value: uri, 
                label: lbl
            }
            uriArray.push(elem);
        });

        elem.removeClass("ui-autocomplete-loading");
        response(uriArray);
    });
}

function dblpConferenceLookup(request, response) {
    
    var uriArray = new Array();
    editBox = document.activeElement;
    //	     editBox
    var ID = editBox.id;
    var elem = jQuery("#"+ID) ;
    elem.addClass("ui-autocomplete-loading");     	     
	     
    var url = "http://api.sindice.com/v3/search?fq=class:swrc:Conference&format=json&fq=domain:dblp.l3s.de&field=link&q=" + elem.val();
    $.getJSON(url, function(data) {
		       
        $.each(data.entries, function(i, entry) {
            var uri = entry.link;
            //var title = entry.title;
            //var lbl = "";
            // $.each(title, function(i, titleEntry) {
            //    lbl = titleEntry.value.replace(/"/g, "");
            // });
            var elem = {
                value: uri, 
                label: uri
            }
            uriArray.push(elem);
        });

        elem.removeClass("ui-autocomplete-loading");
        response(uriArray);
    });
}

var autoCompleteDBpediaConfig = {
    source: dbpediaGenericLookup,
    minChars: 3,
    select: function( event, ui ) { 
    /* turns it into a hyperlink */
    /* window.location = ui.item.value; */
    }
};

var autoCompleteDBpediaLocationConfig = {
    source: dbpediaPlaceLookup,
    minChars: 3,
    select: function( event, ui ) { 
    /* turns it into a hyperlink */
    /* window.location = ui.item.value; */
    }
};
            
var autoCompleteDBLPAuthorConfig = {
    source: dblpAuthorLookup,
    minChars: 3,
    select: function( event, ui ) { 
    /* turns it into a hyperlink */
    /* window.location = ui.item.value; */
    }
};

var autoCompleteDBLPConferenceConfig = {
    source: dblpConferenceLookup,
    minChars: 3,
    select: function( event, ui ) { 
    /* turns it into a hyperlink */
    /* window.location = ui.item.value; */
    }
};


function goalChanged(){
    var optID = $(this).attr("id");
    var goalURI = jQuery("#"+optID).val();
    var inputField = jQuery("#"+goalOptionsMap[optID]);  

    switch(goalURI)
    {
        case "http://www.serena.ac.uk/property/goalFindOutAbout":
            inputField.autocomplete( autoCompleteDBpediaConfig );
            break;
        case "http://www.serena.ac.uk/property/goalAttendConference":
            inputField.autocomplete( autoCompleteDBLPConferenceConfig );
            break;
        case "http://www.serena.ac.uk/property/goalVisitPlace":
            inputField.autocomplete( autoCompleteDBpediaLocationConfig );
            break;
        case "http://www.serena.ac.uk/property/goalMeet":
            inputField.autocomplete( autoCompleteDBLPAuthorConfig );
            break;
        default:
            alert("unknown goal");
    }
}

function addHint(elem){
    elem.focus(focusHint);
    elem.blur(focusBlur);
    elem.each(focusEach);
}

function focusHint(){
    if($(this).val() == $(this).attr('title')){
        $(this).val('');
        $(this).removeClass('auto-hint');
    }
}

function focusBlur(){
    if($(this).val() == '' && $(this).attr('title') != ''){
	$(this).val($(this).attr('title'));
	$(this).addClass('auto-hint');
    }
}

function focusEach(){
    if($(this).attr('title') == ''){ return; }
    if($(this).val() == ''){ $(this).val($(this).attr('title')); }
    else { $(this).removeClass('auto-hint'); }
}


/*
$('input').live('blur change',function(){
  var val = $(this).val();
  if(val.indexOf("http://")===0){
    var anchor = $("<a class='infoAnchor' href='#dummy'>[i]</a>");
    anchor.click(function(){
      return function(uri){
       $.ajax({
            url:uri,
            success:function(){
	    //             show in a dialog o in a div the info of the resource
	     }
	     })
//	  alert('info (like title or description) of the document retrieved via jsonp just as lodlive does, it\'s easy to do for me (if you need/want an help)');
          return false;
      }
	(val)});

      $(this).parent().children('a.infoAnchor').remove();
      $(this).parent().append(anchor);
  }
});
*/
