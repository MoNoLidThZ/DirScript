<?php
error_reporting(0); //Not a real solution to a problem
require("config_basic.php"); 
require("config_advanced.php"); 
require("functions.php");
require("class_lister_json.php");
require("handlers.php");
if($_GET["b"]){
$Browse = rawurldecode($_GET["b"]);
}else{
$Browse = substr(rawurldecode($_GET["href"]), 3);
}
$Directory = array_values(array_filter(explode("/",rawurldecode($_GET["b"]))));
$safedir = implode("/",$Directory);
if ( $Browse )
{
$Browse .= "/";
}
$dirs = count($Directory) - 1;
$DIR = "../" . $safedir;
$d = dir( $DIR );
// Stop them accessing higher level folders
if ( substr_count( $Browse, ".." ) > 0 )
{
exit(MakeErrorJSON("What do you think you're doing?","You don't have permission to access upper level folder!"));
//exit();
}elseif(preg_match( "[".implode('|',$HIDDEN_DIRS)."]", $safedir ) > 0){
exit(MakeErrorJSON("Access Denied","You don't have permission to access this folder!"));
}else{

while (false !== ($entry = $d->read()))
{
if ($entry[0] == '.') continue;
if ( in_array( $entry, $HIDDEN_FILES) ) continue;
if ( in_array( $entry, $HIDDEN_DIRS) ) continue;

if ( is_dir( $DIR . "/" . $entry ) ) {$dirdata['folder'][] = array( filemtime( $DIR . "/" . $entry ), $entry ); continue;}
$dirdata[CheckFileType($entry)][$entry] = array( filemtime( $DIR . "/" . $entry ), $entry , filesize($DIR . "/" . $entry) );
}
}
//switch($_GET['ajax']){
$data = array();
$data['Success'] = true;
$data['Data'] = array();
$Breadcrumb[] = '<ul class="breadcrumb well well-sm">';
if($dirs == -1){
	$Breadcrumb[] = ('<li class="active">Root</li>'); 
}else{
	$Breadcrumb[] = ('<li><a href="?b=">Root</a></li>'); 
}
foreach($Directory as $k => $v){ 
if($k == $dirs){ 
	$Breadcrumb[] = '<li class="active">'.$v.'</li>';
}elseif($k > 0){
	$Breadcrumb[] = '<li><a href="?b='; 
	for ($i = 0; $i <= $k; $i++) {
		$Breadcrumb[] = (rawurlencode($Directory[$i])."/");
	}
	$Breadcrumb[] = '">'.$v.'</a></li>';
}else{
	$Breadcrumb[] = '<li><a href="?b='.$v.'">'.$v.'</a></li>';
}
}
$Breadcrumb[] = '</ul>';
$data['Data']['Breadcrumb'] = implode("",$Breadcrumb);
$uid = 0; $filecount = 0;
foreach($CONTENT_SORT as $category){
	if(!count($dirdata[$category[0]])) continue;
	$filecount += count($dirdata[$category[0]]);
	$lister = new JSONLister($category[0],$category[1]);
	$lister->SetCategoryContent($dirdata[$category[0]]);
	$data['Data']['Article'] = $data['Data']['Article'].$lister->Draw();
	$uid++;
} unset($lister,$category);
if($filecount < 1){
	exit(MakeErrorJSON("Empty Folder","This folder is Empty."));
} unset($filecount);
$data['Data']['Navbar'] = <<<NAVBAR

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
NAVBAR;
	  $k=0;
	  foreach($CONTENT_SORT as $category) {
	  $key = $category[0];
		  if(count( $dirdata[$key] ) == 0) { continue; } 
$data['Data']['Navbar'] = $data['Data']['Navbar'].'<li><a href="#'.$k.'">'.$category[1].'s <span class="itemcount label label-'.$BOOTSTRAP_CLASS[$key."s"].'" data-count="'.count( $dirdata[$key] ).'">0</span></a></li>';
$k++;}
	  unset($k,$key,$category);
$data['Data']['Navbar'] = $data['Data']['Navbar'].'</ul></div>';
exit(json_encode($data));
?>