<?php
if (isset($_REQUEST['id'])) {
	require 'ajax/config.php';
	$id = trim($_REQUEST['id']);
	$url = "https://api.instagram.com/v1/media/".$id."?access_token=" . ACCESS_TOKEN;
	//$url = "http://localhost/instagram/id.json";
	try {
		$contents = file_get_contents($url);
		if (empty($contents)) {
			throw new Exception("[\"empty\"]");
		}
	} catch (Exception $e) {
		include 'error.php'; exit();
	}
	$data = json_decode($contents);
	//var_dump($data);
	if (isset($data->meta->code) != '200') {
		include 'error.php'; exit();
	} else {
		$pic = $data->data->images->standard_resolution->url;
		$likesCount = $data->data->likes->count;
		$commentsCount = $data->data->comments->count;
	}
} else {
	include 'error.php'; exit();
}
?>
<?php require 'meta.php'; ?> 
<?php 
if ($data->data->caption != null) { $title = $data->data->caption->text." | Photo by ". $data->data->user->username ; } else { $title = "Photo by ". $data->data->user->username; }
?>
<title><?php echo $title ?> | Winstagram</title>

<!-- Twitter cards -->
<meta name="twitter:card" content="photo">
<meta name="twitter:site" content="@winstagramApp">
<meta name="twitter:creator" content="@bkvirendra">
<meta name="twitter:url" content="<?php echo "http://winstagram.net".$_SERVER['PHP_SELF']; ?>">
<meta name="twitter:title" content="">
<meta name="twitter:description" content="<?php echo $title; ?>">
<meta name="twitter:image" content="<?php echo $data->data->images->standard_resolution->url; ?>">

<!-- OG Meta Tags -->
<meta property="og:title" content="<?php echo $title ?> | Winstagram" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo "http://winstagram.net".$_SERVER['PHP_SELF']; ?>" />
<meta property="og:image" content="<?php echo $data->data->images->thumbnail->url; ?>" />
<meta property="og:site_name" content="Winstagram" />
<meta property="fb:admins" content="100000109274242" />

<?php require 'css/style.php'; ?>
	<link href="css/p.css" rel="stylesheet" media="screen" />
</head>
<body style="background-color: #C0DEED;">
	<div id="header">
		<p><center>
			<img style="padding-top: 10px;" src="img/logo.png" />
		</center></p>
	</div>

<div class="container">
	<div class="picture">
		<img src="<?php echo $data->data->images->standard_resolution->url; ?>" style="-webkit-border-radius: 7px 0px 0px 7px; border-radius: 7px 0px 0px 7px; border: 2px solid #CCC; height:612px; width:612px; -webkit-box-shadow:inset 0 0 0 1px rgba(0, 0, 0, 0.1), inset -1px 0 0 0 rgba(6, 54, 95, 0.1), inset 0 0 0 2px rgba(255, 255, 255, 0.10), 1px 0 1px rgba(0, 0, 0, 0.05); box-shadow:inset 0 0 0 1px rgba(0, 0, 0, 0.1), inset -1px 0 0 0 rgba(6, 54, 95, 0.1), inset 0 0 0 2px rgba(255, 255, 255, 0.10), 1px 0 1px rgba(0, 0, 0, 0.05);" title="" alt="">
	</div>
	<div class="love">
		<div id="countBox">
			<div style="display: inline; width:140px;">
				<img src="img/glyph-heart.png" class="instalike" title="Like" alt="Like"><span id="likesNum" class="commentsText"><?php echo $likesCount; ?></span>
			</div>
			<div style="display: inline;">
				<img src="img/glyph-comment.png" class="instaComment" title="Comment" alt="Comment"><span class="commentsText"><?php echo $commentsCount; ?></span><br />
			</div>
		</div>
		<div id="likeBox">
			<?php
				$i = 0;
				foreach ($data->data->likes->data as $item) {
					echo "<img class='likeImages' src=". $item->profile_picture ." title=". $item->username .">";
					if ($i < 6) { $i++; } else { break; }
				}
			?>
		</div>
		<div id="commentBox">
			<?php
				$k = 0;
				foreach ($data->data->comments->data as $item) {
					echo "<div class='comment'><img src=". $item->from->profile_picture ." class='commenter' alt=".$item->from->username." title=". $item->from->username .">";
					echo "<span class='commentText'><b>". $item->from->username ."</b></span><br /><div class='comments'>".$item->text."</div></div>";
					if ($k < 5) { $k++; } else { break; }
				}
			?>
			<div class="fb-comments" href="http://winstagram.net" data-num-posts="1" data-width="245" data-colorscheme="light"></div>
		</div>
	</div>
	
</div>
<?php include 'footer.php'; ?>
<?php require 'js/scripts.php'; ?>

</body>
</html>