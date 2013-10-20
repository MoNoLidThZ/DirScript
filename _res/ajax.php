<?php
require("config.php"); 
require("file_icons.php");
require("functions.php");
require("class_lister.php");
require("handlers.php");
$Browse = $_GET["b"] ;
$Directory = array_values(array_filter(explode("/",$_GET["b"])));
$safedir = implode("/",$Directory);
if ( $Browse )
{
$Browse .= "/";
}
$dirs = count($Directory) - 1;
$DIR = "../" . $safedir;
$d = dir( $DIR );
switch($_GET['ajax']){

case "breadcrumb"; //Get Breadcrumb Navigation
?>
<ul class="breadcrumb well well-sm">
  <?php if($dirs == -1)
{ echo('<li class="active">Root</li>'); }else{
echo('<li class="active"><a href="?b=">Root</a></li>'); }?>
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
<?php
break;
case "navbar";?>

<?php
break;
default;?>
Invaild Method
<?php var_dump($_REQUEST); ?>
<?php 
break;
}
?>