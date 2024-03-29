<?php include 'meta.php'; ?>
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
<body style="background-image:url('');">
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
	</center></p>
	</form>
	<div class="well" id="result">
	</div>
	<?php include 'footer.php'; ?>
</div>

<?php require 'js/scripts.php'; ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/a_c.js"></script>
</body>
</html>