<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
require("config.php"); 
require("file_icons.php");
require("functions.php");
require("class_lister.php");
require("handlers.php");
if($_GET["b"]){
$Browse = $_GET["b"] ;
}else{
$Browse = substr($_GET["href"], 3);
}
$Directory = array_values(array_filter(explode("/",$_GET["b"])));
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
echo MakeError("What do you think you're doing?","You don't have permission to access upper level folder!");
//exit();
}elseif(preg_match( "[".implode('|',$HIDDEN_DIRS)."]", $safedir ) > 0){
echo MakeError("Access Denied","You don't have permission to access this folder!");
}else{

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
}
switch($_GET['ajax']){

case "breadcrumb"; //Get Breadcrumb Navigation
?>
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
<?php
break;
case "article";?>
<?php

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
?>
<?php
break;
case "navbar";?>
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
<?php
break;
default;?>
Invaild Method
<?php var_dump($_REQUEST); ?>
<?php 
break;
}
}else{
exit("This url is an ajax webservice – direct access is denied");	
}
?>