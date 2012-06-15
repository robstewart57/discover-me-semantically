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
            $('ArrayOfResult',xml).children('Result').children('URI').each(function(){
                var uri = decodeURI($(this).text());
                var elem = {
                    value: uri, 
                    label: uri
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
            $('ArrayOfResult',xml).children('Result').children('URI').each(function(){
                var uri = $(this).text();
                var elem = {
                    value: uri, 
                    label: uri
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
            var uri = entry['link'];
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
            var uri = entry['link'];
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