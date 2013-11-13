<?php 
$THUMBNAIL_FOLDER = "_thumbnails";
//Files to be Hidden
$HIDDEN_FILES[] = "Thumbs.db";
$HIDDEN_FILES[] = "index.php";
$HIDDEN_FILES[] = ".htaccess";
$HIDDEN_FILES[] = ".htpasswd";
$HIDDEN_FILES[] = "favicon.ico";
//Dirs to be hidden
$HIDDEN_DIRS[] = "_res";
$HIDDEN_DIRS[] = $THUMBNAIL_FOLDER;
$HIDDEN_DIRS[] = "FATE_INTERNAL";
$THUMBNAIL_WIDTH = 160;
$THUMBNAIL_HEIGHT = 90;

$name = "$!nG1_ePl[A]yErZ";	//Your name here
$pagetitle = $name." - Index of /";
//Use Randomly selcected header or page title?
$showmydongers = true;
//These are randomly selected header.
$dong[] = "ヽ༼ຈل͜ຈ༽ﾉ your dongers seem raised ヽ༼ຈل͜ຈ༽ﾉ";
$dong[] = "ヽ༼ຈل͜ຈ༽ﾉ raise your dongers ヽ༼ຈل͜ຈ༽ﾉ";
$dong[] = "ヽ༼ຈل͜ຈ༽ﾉ raise your cauldrons ヽ༼ຈل͜ຈ༽ﾉ";
$dong[] = "ノ(ಠ_ಠノ ) ʟᴏᴡᴇʀ ʏᴏᴜʀ ᴅᴏɴɢᴇʀs ノ(ಠ_ಠノ)";
$dong[] = "ᕦ༼ຈل͜ຈ༽ᕤ flex your dongers ᕦ༼ຈل͜ຈ༽ᕤ";
$dong[] = "ლ(ಠ_ಠლ) Screw this donger ლ(ಠ_ಠლ)";
$dong[] = "(ง ͠° ͟ل͜ ͡°)ง ᴍᴀsᴛᴇʀ ʏᴏᴜʀ ᴅᴏɴɢᴇʀ, ᴍᴀsᴛᴇʀ ᴛʜᴇ ᴇɴᴇᴍʏ (ง ͠° ͟ل͜ ͡°)ง";
$dong[] = "ᕙ༼ຈل͜ຈ༽ᕗ do you even lift your﻿ dongers ᕙ༼ຈل͜ຈ༽ᕗ";
$dong[] = "༼ ºل͟º ༽ raise your mudgolems! ༼ ºل͟º ༽";
$dong[] = "༼ ºل͟º ༽ YOU EITHER DIE A DONG OR LIVE LONG ENOUGH TO BECAME A DONGER ༼ ºل͟º ༽";
$dong[] = "༼ つ ◕_◕ ༽つ Give DIRETIDE";
//Color Class for Category Container
/*Available colors:
	"default" = Gray
	"primary" = Dark Blue
	"success" = Green
	"info" = Light Blue
	"warning" = Yellow
	"danger" = Red
*/
$BOOTSTRAP_CLASS["folders"] = "warning";
$BOOTSTRAP_CLASS["images"] = "success";
$BOOTSTRAP_CLASS["video_hs"] = "primary";
$BOOTSTRAP_CLASS["videos"] = "primary";
$BOOTSTRAP_CLASS["audio_hs"] = "info";
$BOOTSTRAP_CLASS["audios"] = "info";
$BOOTSTRAP_CLASS["files"] = "default";
//Content Sorting: What will be shown first 
//For example: folder then html5 video then non-html5 video then html5 audio then non-html5 audio then image then file
$CONTENT_SORT[] = array("folder","Folder");
$CONTENT_SORT[] = array("video_h","Video");
$CONTENT_SORT[] = array("video","Video");
$CONTENT_SORT[] = array("audio_h","Audio");
$CONTENT_SORT[] = array("audio","Audio");
$CONTENT_SORT[] = array("image","Image");
$CONTENT_SORT[] = array("file","File");
//HTML5 MIME Types
$MIME['mp4'] = "video/mp4";
?>