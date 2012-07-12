$(document).ready(function () {
  $(".search-input").focus();
  	$("#result").html('');
	$("#result").html("<div style='height:300px;'><br /><br /><br /><p><center><span id='looking' class='glow'>Pulling some trending Stuff from Instagram!</span></center></p><br /> \
	<div class='progress progress-striped active' style='width :300px; margin:0 auto;'> \
	<div class='bar' style='width: 100%;'></div></div></div><br />");
	if (window.location.hash.substr(1).length) {
		$(".search-input").trigger('keyup');
		$("#result").html("<br /><br /><br /><br /><p><center><span id='looking'>Looking...</span></center></p><br /> \
		<div class='progress progress-striped active' style='width :300px; margin:0 auto;'> \
		<div class='bar' style='width: 100%;'></div></div></div><br />");	
	} else {
      $.ajax({
      type: "GET",
      url: 'http://pocket-radio.com/ajax/popular.php?popular', // url of the request
      dataType: "jsonp",
      success: function (response) {
		$("#result").html('');
		$.each(response, function (i, data) {
			//console.log(data);
			var final = "<div id='thumbs'><a class='group2' rel='group2' target='_blank' href='p.php?id="+ data.pid +"' title="+ data.filter +" alt="+ data.filter +"> \
			<img id='img' src="+ data.thumbnail +"></a><span style='padding-left:10px; font-size:11px;'><b>"+ data.filter +"</b></span> \
			<span style='float:right; font-size:12px; padding-right:6px; margin-top:3px;' id='comments'>" + data.comments + "</span> \
			<img src='img/instaComment.png' style='float:right; padding-right:2px; height:18px; width:18px;'> \
			<span style='float:right; font-size:12px; padding-right:3px; margin-top:3px;' id='likes'>" + data.likes + "</span> \
			<img src='img/glyph-heart-liked.png' style='float:right; padding-right:2px; height:18px; width:18px;'></div>";
            $("#result").append(final);
			//$(".group2").colorbox({rel:'group2', transition:"fade"});
	    });
	   }
	  });
	}

  var options = {
	callback: function(){
    var search_input = $("#query").val();
	document.title = "#" + search_input.replace("+"," ") + " - Tag Results | Winstagram";
	var select = search_input.charAt(0);
	$("#result").html('');
	if (A_look == "tags" || A_look == "location") {
		$("#result").html("<br /><br /><br /><p><center><span id='looking'>Looking for <span class='glow'>#"+ search_input +"</span>...</span></center></p><br /> \
		<div class='progress progress-striped active' style='width :300px; margin:0 auto;'> \
		<div class='bar' style='width: 100%;'></div></div>");
	} else if(A_look == "users") {
		$("#result").html("<br /><br /><br /><p><center><span id='looking'>Looking for <span class='glow'>@"+ search_input +"</span>...</span></center></p><br /> \
		<div class='progress progress-striped active' style='width :300px; margin:0 auto;'> \
		<div class='bar' style='width: 100%;'></div></div>");
	}
    var keyword = search_input.replace(" ","+");
	var searchURL = S_url + "" + keyword ;
	window.location.hash = search_input.replace(" ","+");
	console.log(searchURL);
    $.ajax({
      type: "GET",
      url: searchURL, // url of the request
      dataType: "json",
      success: function (response) {
		if (A_look == "tags" || A_look == "location") {
		var QTerm = search_input.replace(/ /g,"+");
		var feedHeight = roundUpToAny(response.data.length);
		$("#result").css("height", feedHeight + "px");
        if (1 <= response.data.length) {
		$("#result").html("<span id='headerName' style='padding-left:12px; font-size:16px;'>Showing " + response.data.length + " results for #" + search_input + "</span><br /><br />");
          $.each(response.data, function (i, data) {
			var final = "<div id='thumbs'><a class='group2' rel='group2' target='_blank' href='p.php?id="+ data.id +"' title="+ data.filter +"> \
			<img id='img' src="+ data.images.thumbnail.url +"></a><span style='padding-left:10px; font-size:12px;'><b>"+ data.filter +"</b></span> \
			<span style='float:right; font-size:12px; padding-right:6px; margin-top:3px;' id='comments'>" + data.comments.count + "</span> \
			<img src='img/instaComment.png' style='float:right; padding-right:2px; height:18px; width:18px;'> \
			<span style='float:right; font-size:12px; padding-right:3px; margin-top:3px;' id='likes'>" + data.likes.count + "</span> \
			<img src='img/glyph-heart-liked.png' style='float:right; padding-right:2px; height:18px; width:18px;'></div>";
            $("#result").append(final);
			//$(".group2").colorbox({rel:'group2', transition:"fade"});
          });
        } else {
          $("#result").html("<br /><br /><br /><div class='notfound'><center>No results</center></div>");
        }
       } else {
		$("#result").html('');
		document.title = "@" + search_input.replace("+"," ") + " - Users Search | Winstagram";
		if (1 <= response.data.length) {
		var QTerm = search_input.replace(/ /g,"+");
		var feedHeight = roundUpToAny(response.data.length);
		$("#result").html("<span id='headerName' style='padding-left:12px; font-size:16px;'>Showing " + response.data.length + " results for #" + search_input + "</span><br /><br />");
		$("#result").css("height", feedHeight + "px");
		$.each(response.data, function (i, data) {
			console.log(data);
			var final = "<div id='thumbs' style='height: 200px;'><a class='group2' rel='group2' target='_blank' href='profile.php?id="+ data.id +"' title="+ data.full_name +"> \
			<img id='img' src="+ data.profile_picture +" title="+ data.full_name +" alt="+ data.full_name +"></a><span style='padding-left:10px; font-size:12px;'><b>"+ data.full_name +"</b></span>";
            $("#result").append(final);
		});
		} else {
			$("#result").html("<br /><br /><br /><div class='notfound'><center>No results</center></div>");
		}
	   }
	  }
    });
  },
		wait: 750,
		highlight: true,
		captureLength: 2
	}
	
	$(".search-input").typeWatch( options );

	var url_query = window.location.hash.substr(1);
	if (url_query.length) {
		$(".search-input").val(url_query.replace("+"," "));
		$(".search-input").trigger('keyup');
	}
});