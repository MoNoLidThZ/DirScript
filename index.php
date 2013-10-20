<?php //If you want to edit config, Please go to Config.php in _res folder!
//Don't touch the code below this line unless you know what you're doing!
$тиме = microtime(true);
require("_res/config.php");
require("_res/file_icons.php");
require("_res/functions.php");
require("_res/class_lister.php");
require("_res/handlers.php");
$VERSION = "2.1.2";
// Handlers
$num = rand(0,(count($dong) - 1));

$error = false;

$Browse = $_GET["b"] ;
$Directory = array_values(array_filter(explode("/",$_GET["b"])));
$safedir = implode("/",$Directory);
if ( $Browse )
{
$Browse .= "/";
}
$dirs = count($Directory) - 1;
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo($pagetitle.$_GET["b"]); ?></title>
<link href="_res/css/start/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
<link href="_res/css/bootstrap.min.css" rel="stylesheet">
<link href="_res/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="_res/css/popcorn.css" rel="stylesheet">
<link href="_res/css/core.css" rel="stylesheet">
<script src="_res/js/jquery-1.9.1.js"></script>
<script async src="_res/js/jquery-ui-1.10.3.custom.min.js"></script>
<script async src="_res/js/jquery.lazyload.min.js"></script>
<script async src="_res/js/bootstrap.min.js"></script>
<script async src="_res/js/popcorn.min.js"></script>
<script async src="_res/js/dir_ls.js"></script>
</head>
<body>
<div class="container" id="body">
<h1 style="text-align:center;"><?php echo($showmydongers ? $dong[$num] : $pagetitle); ?></h1>
<div id="breadcrumb">
<ul class="breadcrumb well well-sm">
  <?php if($dirs == -1)
{ echo('<li class="active">Root</li>'); }else{
echo('<li><a href="?b=">Root</a></li>'); }?>
  <?php
foreach($Directory as $k => $v){ 
if($k == $dirs){ ?>
  <li class="active"><?php echo($v); ?></li>
<?php }elseif($k > 0){ ?>
<li><a href="?b=<?php 
for ($i = 0; $i <= $k; $i++) {
    echo(urlencode($Directory[$i])."/");
}?>"><?php echo($v); ?></a></li>
<?php }else{ ?>
<li><a href="?b=<?php echo($v); ?>"><?php echo($v); ?></a></li>
<?php }
} ?>
</ul>
</div>
<article> <h1 hidden><?php echo("Index of /".$_GET["b"]); ?></h1>
<?php
// Stop them accessing higher level folders
if ( substr_count( $Browse, ".." ) > 0 )
{
echo MakeError("What do you think you're doing?","You don't have permission to access upper level folder!");
//exit();
}elseif(preg_match( "[".implode('|',$HIDDEN_DIRS)."]", $safedir ) > 0){
echo MakeError("Access Denied","You don't have permission to access this folder!");
}else{

$DIR = "./" . $safedir;
$d = dir( $DIR );

while (false !== ($entry = $d->read()))
{
if ($entry[0] == '.') continue;
if ( in_array( $entry, $HIDDEN_FILES) ) continue;
if ( in_array( $entry, $HIDDEN_DIRS) ) continue;

// Don't list the folder if it has an index!
if ($entry == 'index.html') exit();
if ($entry == 'index.htm') exit();
if ($entry == 'index.php') exit();
if ($entry == 'index.asp') exit();
if ( is_dir( $DIR . "/" . $entry ) ) {$dirdata['folder'][] = array( filemtime( $DIR . "/" . $entry ), $entry ); continue;}
$dirdata[CheckFileType($entry)][] = array( filemtime( $DIR . "/" . $entry ), $entry , filesize($DIR . "/" . $entry) );
}
$uid = 0; $filecount = 0;
foreach($CONTENT_SORT as $category){
	if(!count($dirdata[$category[0]])) continue;
	$filecount += count($dirdata[$category[0]]);
	$lister = new Lister($category[0],$category[1]);
	$lister->SetCategoryContent($dirdata[$category[0]]);
	$lister->Draw();
	$uid++;
	flush();
} unset($lister,$category);
if($filecount < 1){
	echo(MakeError("Empty Folder","This folder is Empty."));
} unset($filecount);
}
?>
</article>
<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<h1 hidden>Navigation Bar</h1>
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?b=">Back to Root</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
          <ul class="nav navbar-nav">
      <?php  
	  $i=0; $k=0;
	  foreach($CONTENT_SORT as $category) {
		  if(count( $dirdata[$CONTENT_SORT[$i][0]] ) == 0) {$i++; continue; } 
		   ?>
      <li><a href="#<?php echo $k ?>"><?php echo $CONTENT_SORT[$i][1] ?>s <span class="badge"><?php echo count( $dirdata[$CONTENT_SORT[$i][0]] ) ?></span></a></li>
      <?php $i++; $k++;}
	  unset($i,$k,$category);?>
    </ul>
        </div>
      </nav>
</div>

<div id="footer"><span class="container">
</span>Dir Listing Script by <a href="http://spkz.monolidthz.com">$!nG1_ePl[A]yErZ</a> V.<?php echo($VERSION);?></div>
<div id="loading" class="overlay">
 <h1 class="text-center"> <img id="loading-image" src="_res/ajax-loader.gif" alt="Loading..." />Loading...</h1> 
</div>
<!--<div id="pageoverlay" class="overlay" style="display:none;">
	<button type="button" class="close" id="closeoverlay">&times;</button> 
	<button	id="resizevideo"	title="Toggle Screen Size"	type="button"	class="close glyphicon glyphicon-resize-full"></button>-->
<div id="videoWrap" title="Video Player" style="display:none;">
    <video id="mainVideo" src="" preload="metadata">
	Your Browser Does not Support HTML5 Video Tag
    </video>
    
    <div id="controlsOptions">
    
        <button class="videoBtn" id="playPausebtn"> 
        <i class="icon-play"></i>
        </button> 
        
        <span id="curtimetext">00:00</span>

        <input id="slider" type="range" min="0" max="100" value="0" step="1"> 
        <span id="durtimetext">00:00</span>

        <button class="videoBtn" id="fullscreenbtn"> 
        <i class="icon-full"></i>
        </button>
        
        <button class="videoBtn" id="mutebtn"> 
        <i class="icon-unmute"></i>
        </button>
    </div>
</div>
<!--	<div id="playerbox">
    <video id="player" width="640" height="360" controls></video><br>
    </div>
<div class="btn-group" style="display:none;">
  <button	id="playvideo"	title="Play"	type="button"	class="btn btn-primary glyphicon glyphicon-play"></button>
  <button	id="pausevideo"	title="Pause"	type="button"	class="btn btn-primary glyphicon glyphicon-pause" style="display:none;"></button>
  <button	id="volupvideo"	title="Volume Up"	type="button"	class="btn btn-success glyphicon glyphicon-volume-up"></button>
  <button	id="voldnvideo"	title="Volume Down"	type="button"	class="btn btn-warning glyphicon glyphicon-volume-down"></button>
  <button	id="resizevideo"	title="Big Screen"	type="button"	class="btn btn-default glyphicon glyphicon-resize-full"></button>
  <button	id="unresizevideo"	title="Normal Screen"	type="button"	class="btn btn-default glyphicon glyphicon-resize-small" style="display:none;"></button>
  <button	id="fsvideo"	title="Full Screen"	type="button"	class="btn btn-info glyphicon glyphicon-fullscreen"></button>
</div>

</div>-->
<script>
var CurDir = "<?php echo($safedir ? $safedir."/" : NULL); ?>";
var PageTitle = "<?php echo $pagetitle ?>";
  $(window).load(function() {
    $('#loading').hide();
	setTimeout(function() {$("img.lazy").lazyload({ 
		effect : "fadeIn"
	})},1000);
$("div.panel:hidden").show( <?php if($safedir) {?>"slide", { direction:"right" }<?php }else{ ?>"drop", { direction:"down" }<?php } ?> ,1500 );
	<?php if($_GET['v'] || $_GET['V']){ ?>
	ViewVideo(<?php echo($_GET['v'] ? $_GET['v'] : $_GET['V']); ?>);
	<?php }?>
});
<?php /*for ($i = 0; $i <= $uid-1; $i++) { ?>
$( "#close-<?php echo $i ?>" ).click(function() {
$("div#<?php echo $i ?>-b").hide( "blind", { direction:"up" } ,1000 );
$( "#close-<?php echo $i ?>" ).hide( "blind", { direction:"up" } ,500 ,function(){
	$("#open-<?php echo $i ?>").show( "blind", { direction:"up" } ,500 );
});
});
$( "#open-<?php echo $i ?>" ).click(function() {
$("div#<?php echo $i ?>-b").show( "blind", { direction:"up" } ,1000 );
$( "#open-<?php echo $i ?>" ).hide( "blind", { direction:"up" } ,500 ,function(){
	$("#close-<?php echo $i ?>").show( "blind", { direction:"up" } ,500 );
});
});
<?php } */?>

</script>
</body>
</html>