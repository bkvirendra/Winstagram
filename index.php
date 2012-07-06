<?php require 'meta.php'; 
if (empty($_COOKIE['first_time'])) {
    //show_welcome_message();
    setcookie("first_time", 1, time()+157680000);  /* expire in 5 years */
}
?>
<title>Winstagram | Explore @Instagram In a amazing way using!</title>

<!-- Twitter cards -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@winstagramApp">
<meta name="twitter:creator" content="@bkvirendra">
<meta name="twitter:url" content="http://winstagram.net">
<meta name="twitter:title" content="Winstagram | Explore @Instagram In a amazing way using!">
<meta name="twitter:description" content=" Exploring Instagram in a amazing way! Browse, search, view the most popular photos on Instagram. Search User profiles on Instagram.">
<meta name="twitter:image" content="http://winstagram.net/img/logo.png">

<!-- OG Meta Tags -->
<meta property="og:title" content="Winstagram | Explore @Instagram In a amazing way using!" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://winstagram.net" />
<meta property="og:image" content="http://winstagram.net/img/logo.png" />
<meta property="og:site_name" content="Winstagram" />
<meta property="fb:admins" content="100000109274242" />
<meta property="og:description" content=" Exploring Instagram in a amazing way! Browse, search, view the most popular photos on Instagram. Search User profiles on Instagram.">

<?php require 'css/style.php'; ?>
</head>
<body style="background-image:url('http://a0.twimg.com/profile_background_images/577045933/2ihjcay8elhp4p8xw9qk.jpeg');">
<?php require 'header.php'; ?> 

<div class="container">
	<form action="javascript:void(0);">
    <input type="text" class="search-input" autocomplete="off" autofocus id="query" placeholder="Search by {tag}, {username} & {location}"><br />
	<p><center>
	<select id="drop" name="pretty" tabindex="1" class="pretty dk">
		<option id="tags" value="tags"># Tags</option>
		<option id="users" value="users">@ Users</option>
		<option id="location" value="location">Location</option>
	</select>
	</center></p><br />
	</form>
	<div class="well" id="result">
		
	</div>
</div>

<a href="#inline_content" style='display:none' id="#cookieWelcome"></a>
<div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'>
	<p><strong>This content comes from a hidden element on this page.</strong></p>
	<p>The inline option preserves bound JavaScript events and changes, and it puts the content back where it came from when it is closed.</p>
	<p><strong>If you try to open a new ColorBox while it is already open, it will update itself with the new content.</strong></p>
	</div>
</div>


<?php require 'js/scripts.php'; ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script>
	
	$("#inline_content").colorbox({inline:true, width:"50%"});
	
	var A_look = 'tags'
	var A_url = "ajax/search.php?tags=";
	var S_url = "ajax/search.php?tags=";

	$('#drop').dropkick({
		change: function (value, label) {
			switch (value) {
			case 'tags':
				A_look = 'tags';
				A_url = "ajax/suggestions.php?tags=";
				S_url = "ajax/search.php?tags=";
			break;
			case 'users':
				A_look = 'users';
				A_url = "ajax/suggestions.php?users=";
				S_url = "ajax/search.php?users=";
			break;
			case 'location':
				A_look = 'location';
				A_url = "ajax/suggestions.php?location=";
				S_url = "ajax/location.php?address=";
			break;
			default:
				A_look = 'tags';
				A_url = "ajax/suggestions.php?tags=";
				S_url = "ajax/search.php?tags=";
				break;
			}
		}
	});
	
	$('#query').keyup(function() {
	switch (A_look) {
		case 'tags':
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"tags" : request.term
			},
			success: function( data ) {
            var terms = [];

            for (var i = 0; i < data[1].length; i++) {
                terms.push(data[1][i][0]);
            }

            response(terms);
			}
			});
		},
		minLength: 2
		});
		break;
		case 'users':
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"users" : request.term
			},
			success: function( data ) {
				related = data[1];
				response(data[1]);
			}
			});
		},
		minLength: 2
		});
		break;
		case 'location':
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"location" : request.term
			},
			success: function( data ) {
				related = data[1];
				response(data[1]);
			}
			});
		},
		minLength: 2
		});
		break;
		default:
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"tags" : request.term
			},
			success: function( data ) {
				related = data[1];
				response(data[1]);
			}
			});
		},
		minLength: 2
		});
		break;
	}
	});
	</script>
</body>
</html>