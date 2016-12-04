<?php 
$THUMBNAIL_FOLDER = "_thumbnails";
//Files to be Hidden
$HIDDEN_FILES[] = "Thumbs.db";
$HIDDEN_FILES[] = "index.php";
$HIDDEN_FILES[] = ".htaccess";
$HIDDEN_FILES[] = ".htpasswd";
$HIDDEN_FILES[] = ".gitattributes";
$HIDDEN_FILES[] = ".gitignore";
$HIDDEN_FILES[] = "favicon.ico";
$HIDDEN_FILES[] = "readme.md"; //Will going to add markdown folder info feature soon...
$HIDDEN_FILES[] = "web.config"; //Damn you IIS 7.0
//Dirs to be hidden
$HIDDEN_DIRS[] = "_res";
$HIDDEN_DIRS[] = $THUMBNAIL_FOLDER;
$THUMBNAIL_WIDTH = 160;
$THUMBNAIL_HEIGHT = 90;

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
//User agent to redirect
$ALLOWED_AGENTS[] = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)"; //Internet Download Manager Version 6.19

//File icons, Add your extension here
$ICON_EXT['exe'] = "ui-silk-application-xp";
$ICON_EXT['bat'] = "ui-silk-application-xp-terminal";
$ICON_EXT['cmd'] = "ui-silk-application-xp-terminal";
$ICON_EXT['c'] = "ui-silk-page-white-c";
$ICON_EXT['cpp'] = "ui-silk-page-white-cplusplus";
$ICON_EXT['cs'] = "ui-silk-page-white-csharp";
$ICON_EXT['cf'] = "ui-silk-page-white-coldfusion";
$ICON_EXT['fla'] = "ui-silk-page-white-flash";
$ICON_EXT['swf'] = "ui-silk-page-white-flash";
$ICON_EXT['xls'] = "ui-silk-page-excel";
$ICON_EXT['xlsx'] = "ui-silk-page-excel";
$ICON_EXT['h'] = "ui-silk-page-white-h";
$ICON_EXT['js'] = "ui-silk-script";
$ICON_EXT['class'] = "ui-silk-page-white-cup";
$ICON_EXT['java'] = "ui-silk-page-white-cup";
$ICON_EXT['php'] = "ui-silk-page-white-php";
$ICON_EXT['ppt'] = "ui-silk-page-white-powerpoint";
$ICON_EXT['pptx'] = "ui-silk-page-white-powerpoint";
$ICON_EXT['pps'] = "ui-silk-page-white-powerpoint";
$ICON_EXT['svg'] = "ui-silk-page-white-vector";
$ICON_EXT['svg'] = "ui-silk-page-white-visualstudio";
$ICON_EXT['jpg'] = "ui-silk-picture";
$ICON_EXT['gif'] = "ui-silk-picture";
$ICON_EXT['png'] = "ui-silk-picture";
$ICON_EXT['psd'] = "ui-silk-picture-edit";
$ICON_EXT['psb'] = "ui-silk-picture-edit";
$ICON_EXT['html'] = "ui-silk-page-world";
$ICON_EXT['xhtml'] = "ui-silk-page-world";
$ICON_EXT['htm'] = "ui-silk-page-world";
$ICON_EXT['rar'] = "ui-silk-compress";
$ICON_EXT['zip'] = "ui-silk-compress";
$ICON_EXT['ace'] = "ui-silk-compress";
$ICON_EXT['uha'] = "ui-silk-compress";
$ICON_EXT['7z'] = "ui-silk-compress";
$ICON_EXT['bz2'] = "ui-silk-compress";
$ICON_EXT['log'] = "ui-silk-page-white-text";
$ICON_EXT['txt'] = "ui-silk-page-white-text";
$ICON_EXT['avi'] = "ui-silk-film";
$ICON_EXT['mpg'] = "ui-silk-film";
$ICON_EXT['mp4'] = "ui-silk-film";
$ICON_EXT['m4v'] = "ui-silk-film";
$ICON_EXT['3gp'] = "ui-silk-film";
$ICON_EXT['flv'] = "ui-silk-film";
$ICON_EXT['webm'] = "ui-silk-film";
$ICON_EXT['ogg'] = "ui-silk-film";

//Fallback for unknown file type
$ICON_EXT['unknown'] = "ui-silk-page";
//Folder Icon
$ICON_EXT['folder'] = "ui-silk-folder";?>