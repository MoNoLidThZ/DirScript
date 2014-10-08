<!doctype html>
<html>
<head>
<link href="//static.monolidthz.com/jquery/css/start/jquery-ui-1.10.2.custom.css" rel="stylesheet">
<link href="//static.monolidthz.com/bootstrap-v3/css/bootstrap.min.css" rel="stylesheet">
<link href="//static.monolidthz.com/bootstrap-v3/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="//static.monolidthz.com/popcorn/css/popcorn-sdl.css" rel="stylesheet">
<link href="//static.monolidthz.com/lightbox/css/lightbox.css" rel="stylesheet">
<link href="//static.monolidthz.com/silkicons/silk-sprite.css" rel="stylesheet">
<link href="//static.monolidthz.com/SPKZDirScript/css/core.css" rel="stylesheet">
<script src="//static.monolidthz.com/jquery/js/jquery-1.11.1.min.js"></script>
<script async src="//static.monolidthz.com/jquery/js/jquery-ui-1.10.2.custom.min.js"></script>
<script async src="//static.monolidthz.com/jquery/js/jquery.lazyload.min.js"></script>
<script async src="//static.monolidthz.com/jquery/js/jquery.animateNumber.min.js"></script>
<script async src="//static.monolidthz.com/bootstrap-v3/js/bootstrap.min.js"></script>
<script async src="//static.monolidthz.com/popcorn/js/popcorn.js"></script>
<script async src="//static.monolidthz.com/SPKZDirScript/js/SPKZDirListingScript.js"></script>
<script async src="//static.monolidthz.com/lightbox/js/lightbox-2.6.min.js"></script>
</head>
<body  itemscope itemtype="//schema.org/WebPage">
<?php
include("config_advanced.php");
$root = '../';

$time = microtime(true);
$Directory = new RecursiveDirectoryIterator($root);
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^[^\_]+.+(\.jpg|\.png|\.gif)$/i', RecursiveRegexIterator::GET_MATCH);
$i = 0;

foreach ($Regex as $k => $v) {
	// echo "<div class=\"image item\"><img class=\"lazy ".$class."\" src=\"/_res/grey.gif\" data-original=\"".str_replace("..\\","",$v[0])."\" width=$THUMBNAIL_WIDTH 	height=$THUMBNAIL_HEIGHT alt=\"Image\"></div>";
	// echo "<div class=\"image item\"><img class=\"lazy ".$class."\" src=\"/_res/grey.gif\" data-original=\"/?img=";
	// echo str_replace("..\\","",$k);
	// echo "\" width=$THUMBNAIL_WIDTH	height=$THUMBNAIL_HEIGHT alt=\"Image\"></div>";
	// print_r($v);
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $_SERVER['HTTP_HOST']."?imgE=".base64_encode(str_replace("..\\","",$k))); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_exec($ch);
	curl_close($ch);      
	flush();
	$i++;
}
echo '<br><pre>';
echo 'Page Generated in '.(microtime(true)-$time).' seconds'.PHP_EOL;
echo 'Total: '.$i.' Images';
echo '</pre>';
?>
<script>
// $("img.lazy").lazyload({ 
		// effect : "fadeIn"
	// });
</script>
</body>
</html>