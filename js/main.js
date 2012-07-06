$(document).ready(function () {
  $(".search-input").focus();
  	$("#result").html('');
	$("#result").html("<div style='height:300px;'><h2><center>Getting Some Popular Stuff</center></h2><br /> \
	<div class='progress progress-striped active' style='width :300px; margin:0 auto;'> \
	<div class='bar' style='width: 100%;'></div></div></div><br />");
	if (window.location.hash.substr(1).length) {
		$(".search-input").trigger('keyup');
		$("#result").html("<br /> \
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
			var final = "<div id='thumbs'><a class='group2' rel='group2' href="+ data.standard_resolution +" title="+ data.filter +" alt="+ data.filter +"> \
			<img id='img' src="+ data.thumbnail +"></a><span style='padding-left:10px; font-size:11px;'><b>"+ data.filter +"</b></span> \
			<span style='float:right; font-size:12px; padding-right:6px; margin-top:3px;' id='comments'>" + data.comments + "</span> \
			<img src='img/instaComment.png' style='float:right; padding-right:2px; height:18px; width:18px;'> \
			<span style='float:right; font-size:12px; padding-right:3px; margin-top:3px;' id='likes'>" + data.likes + "</span> \
			<img src='img/glyph-heart-liked.png' style='float:right; padding-right:2px; height:18px; width:18px;'></div>";
            $("#result").append(final);
			$(".group2").colorbox({rel:'group2', transition:"fade"});
	    });
	   }
	  });
	}
 
  var options = {
	callback: function(){
    var search_input = $("#query").val();
	var select = search_input.charAt(0);
	$("#result").html('');
	$("#result").html("<div class='progress progress-striped active' style='width :300px; margin:0 auto;'> \
	<div class='bar' style='width: 100%;'></div></div>");
    var keyword = encodeURIComponent(search_input);
	var searchURL = S_url + "" + keyword ;
	console.log(searchURL);
	window.location.hash = keyword;
    $.ajax({
      type: "GET",
      url: searchURL, // url of the request
      dataType: "json",
      success: function (response) {
        $("#result").html('');
		var QTerm = search_input.replace(/ /g,"+");
		document.title = "#" + QTerm + " - Search Results | Winstagram";
		var feedHeight = roundUpToAny(response.data.length);
		$("#result").css("height", feedHeight + "px");
        if (response.data) {
          $.each(response.data, function (i, data) {
			console.log(data);
			var final = "<div id='thumbs'><a class='group2' rel='group2' href="+ data.images.standard_resolution.url +" title="+ data.filter +"> \
			<img id='img' src="+ data.images.thumbnail.url +"></a><span style='padding-left:10px; font-size:12px;'><b>"+ data.filter +"</b></span> \
			<span style='float:right; font-size:12px; padding-right:6px; margin-top:3px;' id='comments'>" + data.comments.count + "</span> \
			<img src='img/instaComment.png' style='float:right; padding-right:2px; height:18px; width:18px;'> \
			<span style='float:right; font-size:12px; padding-right:3px; margin-top:3px;' id='likes'>" + data.likes.count + "</span> \
			<img src='img/glyph-heart-liked.png' style='float:right; padding-right:2px; height:18px; width:18px;'></div>";
            $("#result").append(final);
			$(".group2").colorbox({rel:'group2', transition:"fade"});
          });
        } else {
          //$("#result").html("<div id='no'>No results</div>");
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
		url_query = url_query.replace(/[^\w\s]/gi, ' ');
		$(".search-input").val(url_query);
		$(".search-input").trigger('keyup');
	}
});