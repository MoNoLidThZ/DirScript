<?php 
//HandleImageOutput is a CPU Intensive Function! that's why we need caching and stuff (aka "_thumbnails" folder)
function HandleImageOutput()
{
global $THUMBNAIL_FOLDER, $THUMBNAIL_WIDTH, $THUMBNAIL_HEIGHT;
$img = $_GET['imgE'] ? base64_decode($_GET['imgE']) : $_GET['img'];
$image = implode("/",array_filter(explode("/",$img)));
// $image = $_GET["img"];
if (!$image) return;

$imagecache = $THUMBNAIL_FOLDER . "/" . $THUMBNAIL_WIDTH . "x" . $THUMBNAIL_HEIGHT. "_" . md5_file( $image ) . ".jpg";

error_reporting(0);
$im = @imagecreatefromjpeg( $imagecache );
if ( $im )
{
header("Content-type: image/jpg");
header('Cache-Control: "max-age=31557600, public"');
imagejpeg($im);
imagedestroy($im);
exit();
}

$imgsize = getimagesize ( $image );

switch ($imgsize[2])
{
case 1: // GIF
$im = imagecreatefromgif( $image );
break;
case 2: // JPG
$im = imagecreatefromjpeg( $image );
break;
case 3: // PNG
$im = imagecreatefrompng( $image );
break;
default: // UNKNOWN!
echo "Unknown Image!";
exit();
}

header("Content-type: image/jpg");

$img_thumb = imagecreatetruecolor( $THUMBNAIL_WIDTH, $THUMBNAIL_HEIGHT );

$dsth = ($THUMBNAIL_WIDTH / ImageSX($im)) * ImageSY($im);

imagecopyresampled( $img_thumb, $im, 0,($THUMBNAIL_HEIGHT-$dsth)/2, 0,0, $THUMBNAIL_WIDTH, $dsth, ImageSX($im), ImageSY($im) );

imagejpeg( $img_thumb );

if ( $im && $img_thumb )
{
@imagejpeg( $img_thumb, $imagecache, 95 );
}

imagedestroy( $img_thumb );
imagedestroy( $im );
exit();
}

function HandleDownloadFile()
{
global $ALLOWED_AGENTS;
$file = implode("/",array_filter(explode("/",$_GET["download"]))); 
if (!$file) return;
if (in_array($_SERVER["HTTP_USER_AGENT"],$ALLOWED_AGENTS)){
	Redirect($file);
}
require("class_resumedownload.php");
set_time_limit(0);
$download = new ResumeDownload($file,0);
$download->process();
}
HandleImageOutput();
HandleDownloadFile();
?>