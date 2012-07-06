<?php
if (isset($_REQUEST['id'])) {
	require 'ajax/config.php';
	$id = trim($_REQUEST['id']);
	$url = "https://api.instagram.com/v1/users/".$id."/?access_token=" . ACCESS_TOKEN;
	//$url = "http://localhost/instagram/basic.json";
	try {
		$basicInfo = file_get_contents($url);
		if (empty($basicInfo)) {
			throw new Exception("[\"empty\"]");
		}
	} catch (Exception $e) {
		include 'error.php'; exit();
	}
	$basicData = json_decode($basicInfo);
	if (isset($basicData->meta->code) != '200') {
		include 'error.php'; exit();
	} else {
		$feedUrl = "https://api.instagram.com/v1/users/".$id."/media/recent/?access_token=" . ACCESS_TOKEN;
		//$feedUrl = "http://localhost/instagram/recent.json";
		try {
		$contents = file_get_contents($feedUrl);
		if (empty($contents)) {
			throw new Exception("[\"empty\"]");
		}
	} catch (Exception $e) {
		include 'error.php'; exit();
	}
		$data = json_decode($contents);
	}
} else {
	include 'error.php'; exit();
}
	function roundUpToAny($n,$x=5) {
		if ($n % 5 == 0) { return((($n/5)*200)+ 110); }
		$rounded = round(($n+$x/2)/$x)*$x;
		$height = (($rounded / 5) * 200)+110;
		return $height;
	}
?>
<?php require 'meta.php'; ?> 
<?php if(!strlen(isset($basicData->data->full_name))) { $title = $basicData->data->full_name; } else { $title = $basicData->data->username; } ?>
<title><?php echo $title; ?> | Profile on Winstagram</title>

<!-- Twitter cards -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@winstagramApp">
<meta name="twitter:creator" content="@bkvirendra">
<meta name="twitter:url" content="<?php echo "http://winstagram.net".$_SERVER['PHP_SELF']; ?>">
<meta name="twitter:title" content="<?php echo $title; ?> | Profile on Winstagram">
<meta name="twitter:description" content="<?php echo $title; ?>'s Profile on Winstagram | Exploring Instagram in a Instant & awesome way! Browse, search the most popular photos on Instagram. Search User profiles on Instagram.">
<meta name="twitter:image" content="<?php echo $basicData->data->profile_picture; ?>">

<!-- OG Meta Tags -->
<meta property="og:title" content="<?php echo $title; ?> | Profile on Winstagram" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo "http://winstagram.net".$_SERVER['PHP_SELF']; ?>" />
<meta property="og:image" content="<?php echo $basicData->data->profile_picture; ?>" />
<meta property="og:site_name" content="Winstagram" />
<meta property="fb:admins" content="100000109274242" />

<?php require 'css/style.php'; ?>
	<link href="css/profile.css" rel="stylesheet" media="screen" />
</head>
<body style="background-color: #C0DEED;">
<?php require 'header.php'; ?> 
	
	<div class="container">
		<div id="profile" class="well">
			<img id="profile_pic" src="<?php echo $basicData->data->profile_picture; ?>">
			<div id="basicInfo">
				<span id="headerName"><?php echo $basicData->data->full_name; ?></span><br />
				<span id="headerUserName"><?php echo "@".$basicData->data->username; ?></span><br />
				<span id="headerBio"><?php echo $basicData->data->bio; ?></span><br /><br />
				<span id="headerWeb"><?php if(isset($basicData->data->website)) { echo "<a href=".$basicData->data->website." target='_blank'>".$basicData->data->website."</a>"; } ?></span>
			</div>
			<?php 
				if ($basicData->data->counts->followed_by < 999) {
					echo "<div id='counts' style='margin-left:760px;'>";
				} else {
					echo "<div id='counts' style='margin-left:710px;'>";
				}
			?>
				<div class="count1">
					<span class="counting"><?php echo $basicData->data->counts->media , " "; ?></span><span>Media</span>
				</div>
				<div class="count1">
					<span class="counting"><?php echo $basicData->data->counts->followed_by , " "; ?></span><span>Followers</span>
				</div>
				<div class="count2">
					<span class="counting"><?php echo $basicData->data->counts->follows , " "; ?></span><span>Follows</span>
				</div>
			</div>
		</div>

		<div id="feed" class="well" style="height: <?php echo roundUpToAny(count($data->data)); ?>px;">
			<span id="headerName" style="padding-left:10px; font-size:20px;">Recent Photos</span><br /><br />
			<?php foreach ($data->data as $item) { ?>
				<div id='thumbs'>
					<a class='group2' rel='group2' href="#" title="<?php if(isset($item->caption) != null) { echo $item->caption->text; } ?>">
						<img id='img' src="<?php echo $item->images->thumbnail->url; ?>" title="<?php echo $item->filter; ?>"></a>
						<span class='filterName'><b><?php echo $item->filter; ?></b></span>
						<span class='commentsCount' id='comments'><?php echo $item->comments->count; ?></span>
						<img src='img/instaComment.png' class='commentsIcon' title="Comments">
						<span class='likesCount' id='likes'><?php echo $item->likes->count; ?></span>
						<img src='img/glyph-heart-liked.png' class='likesIcon' title="Likes">
				</div>
			<?php } 
			if (!count($data->data)) {
				echo "<br /><br /><p><center><span style='font-size:20px; margin-top:20px;'>Empty Media !! :(</span></center></p>";
			}
			?>
		</div>
	</div>

<?php require 'js/scripts.php'; ?>

</body>
</html>