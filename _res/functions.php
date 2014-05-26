<?php
////// FUNCTIONS /////
//Basic Check File Type
function CheckFileType( $fn ){
$fn = strtolower( $fn );
if(IsImage($fn)){
	return "image";
}elseif(IsVideo($fn)){
	return "video";
}elseif(IsAudio($fn)){
	return "audio";
}else{
	return "file";
}
}
//Newer version of CheckFileType
function CheckFileTypeHTML5( $fn ){
$fn = strtolower( $fn );
if(IsImage($fn)){
	return "image";
}elseif(IsVideoHTML5($fn)){
	return "video_h";
}elseif(IsVideo($fn)){
	return "video";
}elseif(IsAudioHTML5($fn)){
	return "audio_h";
}elseif(IsAudio($fn)){
	return "audio";
}else{
	return "file";
}
}
//Is $i an Image?
function IsImage( $i )
{
$i = strtolower( $i );

if ( substr_count( $i, ".jpg" ) > 0 ||
substr_count( $i, ".jpeg" ) > 0 ||
substr_count( $i, ".gif" ) > 0 ||
substr_count( $i, ".png" ) > 0 )
{
return true;
}
return false;
}
//Is $i a Video?
function IsVideo( $i )
{
$i = strtolower( $i );

if ( substr_count( $i, ".mp4" ) > 0 ||
substr_count( $i, ".webm" ) > 0 ||
substr_count( $i, ".ogv" ) > 0 ||
substr_count( $i, ".avi" ) > 0 ||
substr_count( $i, ".mpg" ) > 0 ||
substr_count( $i, ".mkv" ) > 0 ||
substr_count( $i, ".3gp" ) > 0 ||
substr_count( $i, ".divx" ) > 0 ||
substr_count( $i, ".rmvb" ) > 0 ||
substr_count( $i, ".wmv" ) > 0 ||
substr_count( $i, ".flv" ) > 0 )
{
return true;
}

return false;
}

//Is $i an Audio?
function IsAudio( $i )
{
$i = strtolower( $i );

if ( substr_count( $i, ".mp3" ) > 0 ||
substr_count( $i, ".ogg" ) > 0 ||
substr_count( $i, ".aac" ) > 0 ||
substr_count( $i, ".ac3" ) > 0 ||
substr_count( $i, ".aif" ) > 0 ||
substr_count( $i, ".amr" ) > 0 ||
substr_count( $i, ".flac" ) > 0 ||
substr_count( $i, ".wav" ) > 0 ||
substr_count( $i, ".m4a" ) > 0 )
{
return true;
}

return false;
}

function IsVideoHTML5( $i )
{	
$i = strtolower( $i );

if ( substr_count( $i, ".mp4" ) > 0 || substr_count( $i, ".webm" ) > 0 || substr_count( $i, ".ogv" ) > 0 && IsVideo($i))
{
return true;
}
return false;
}


function IsAudioHTML5( $i )
{	
$i = strtolower( $i );

if ( substr_count( $i, ".mp3" ) > 0 || substr_count( $i, ".ogg" ) > 0 && IsAudio($i))
{
return true;
}
return false;
}

function MakeError( $title, $data )
{
$GLOBALS["error"] = true;
return '<div id="error" class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">Error: '.$title.'</h3>
  </div>
  <div id="error-b" class="panel-body">'.$data.'</div></div>';
}
function MakeErrorJSON( $title, $data )
{
$GLOBALS["error"] = true;
return json_encode(array(Success => false,Data => '<div id="error" class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">Error: '.$title.'</h3>
  </div>
  <div id="error-b" class="panel-body">'.$data.'</div></div>'));
}

function Redirect($url){
header( 'Location: '.$url ) ;
}
?>