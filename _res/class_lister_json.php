<?php 
class JSONLister {
	private $Name, $CurDir, $FileInfo_Enable, $content, $cssclas, $isfolder, $drawctype, $uniqueid;
	public function __construct($objType,$name){
		$this->Name = $name;
		global $BOOTSTRAP_CLASS, $Browse, $safedir, $uid;
		if(!$BOOTSTRAP_CLASS[strtolower($objType."s")]){
			exit("No Style Defined or Unknown Class(".strtolower($objType."s").")!");
		}
		$this->cssclas = $BOOTSTRAP_CLASS[strtolower($objType."s")];
		$this->CurDir = ($safedir ? $safedir . "/" : NULL);
		$this->FileInfo_Enable = extension_loaded("php_fileinfo");
		$this->drawctype = $objType;
		$this->uniqueid = $uid;
	}
	public function SetCategoryContent($data){
		$this->content = $data;
	}
	public function Draw(){
		$ret[] = $this->PrintOpenTag();
		ksort($this->content,SORT_NATURAL);
		$ret[] = $this->PrintContentArray($this->content);
		$ret[] = $this->PrintCloseTag();
		return implode("",$ret);
	}
	private function PrintOpenTag(){
		$cntcount = count( $this->content );
		$lowerid = strtolower($this->uniqueid);
		return <<<OPENTAG
		<section><div id="{$this->uniqueid}" class="panel panel-{$this->cssclas}" style="display:none;">
<div class="panel-heading">
<h3 class="panel-title"> <button id="close-{$lowerid}" data-target="{$this->uniqueid}" type="button" class="close glyphicon glyphicon-chevron-up" aria-hidden="true"></button><button id="open-{$lowerid}" data-target="{$this->uniqueid}" type="button" class="close glyphicon glyphicon-chevron-down" aria-hidden="true" style="display:none;"></button>{$this->Name}s ({$cntcount})</h3>
</div><div id="{$lowerid}-b" class="panel-body">\n
OPENTAG;
	}
	private function PrintCloseTag(){
		return "</div></div></section>";
	}
	private function PrintContent($data){
		$contentid = sprintf("%u", crc32($data[1]));
		$ret = array();
		$ret[] = ('<div class="row item" id="'.$contentid.'">');
		$ret[] = ('<div class="col-md-1 col-sm-1 col-xs-1">'.$this->GetExtImage($data[1],$contentid).'</div>');//File Ext Image
		$ret[] = ('<div class="col-md-7 col-sm-9 col-xs-5"><a href="'.($this->drawctype == "folder" ? "?b=".$this->EncURL($this->CurDir.$data[1]): $this->EncURL($this->CurDir.$data[1]))."\" data-parent=\"".$this->uniqueid."\">".$data[1]."</a></div>\n");
		$ret[] = ('<div class="col-md-1 col-sm-2 col-xs-4">'.($data[2] ? $this->FileSize($data[2]) :"Folder").'</div>');//File Size
		$ret[] = ('<div class="col-md-3 hidden-sm hidden-xs"><time datetime="'.date("Y-m-d\TH:i:sP" , $data[0]).'">'.date("D d F Y h:i:s A", $data[0]).'</time></div>');
		$ret[] = ('</div>'."\n");
		return implode("",$ret);
	}
	private function PrintContentVideo($data){
		$fn = explode(".",$data[1]);
		$ext = strtolower($fn[count($fn) - 1]);
		$contentid = sprintf("%u", crc32($data[1]));
		$ret = array();
		$ret[] = ('<div class="row item" id="'.$contentid.'">');
		$ret[] = ('<div class="col-md-1 col-sm-1 col-xs-1 text-right">'.$this->GetExtImage($data[1],$contentid).'</div>');//File Ext Image
		if(IsVideoHTML5($data[1])){
		$ret[] = ('<div class="col-md-6 col-sm-8 col-xs-5"><a href="?download='.rawurlencode($this->CurDir.$data[1])."\">".$data[1]."</a></div>\n");
		$ret[] = ('<div class="col-md-1 col-sm-1 col-xs-1"><a title="Click here to watch: '.$data[1].'" class="ViewVideo" href="javascript:ViewVideo('.$contentid.');" data-mime="video/'.$ext.'">'.$this->GetSilkIcon("ui-silk-eye")."</a></div>\n");
		}else{
		$ret[] = ('<div class="col-md-7 col-sm-9 col-xs-5"><a href="?download='.rawurlencode($this->CurDir.$data[1])."\">".$data[1]."</a></div>\n");
		}
		$ret[] = ('<div class="col-md-1 col-sm-2 col-xs-4">'.($data[2] ? $this->FileSize($data[2]) :"&nbsp;").'</div>');//File Size
		$ret[] = ('<div class="col-md-3 hidden-sm hidden-xs"><time datetime="'.date("Y-m-d\TH:i:sP" , $data[0]).'">'.date("D d F Y h:i:s A", $data[0]).'</time></div>');
		$ret[] = ('</div>'."\n");
		return implode("",$ret);
	}
	private function PrintContentArray($array){
		if(count( $array ) == 0){ $ret[] = ("No content specified"); }
		switch($this->drawctype){
			case "image";
			foreach ( $array as $data ){
				$ret[] = ($this->GetImageLink($this->CurDir.$data[1],$data[1]));
			}
			break;
			case "video";
			foreach ( $array as $data ){
				$ret[] = $this->PrintContentVideo($data);
			}
			break;
			case "audio";
			//Not yet implemented
			foreach ( $array as $data ){
				$ret[] = $this->PrintContent($data);
			}
			break;
			case "folder";
			foreach ( $array as $data ){
				$ret[] = $this->PrintContent($data);
			}
			break;
			default;
			foreach ( $array as $data ){
				$ret[] = $this->PrintContent($data);
			}
			break;
		}
		return implode("",$ret);
	}
	private function FileSize($bytes, $precision = 2){
	    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
	    $bytes = max($bytes, 0); 
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	    $pow = min($pow, count($units) - 1); 
		$bytes /= pow(1024, $pow);
    	return round($bytes, $precision) . ' ' . $units[$pow]; 
	}
	private function GetImageLink( $path ,$name )
	{
		global $THUMBNAIL_WIDTH, $THUMBNAIL_HEIGHT;
		$contentid = $this->EncPath(($path));
		return "<div class=\"image item\"><a href=\"".$this->EncURL($path)."\" data-lightbox=\"$contentid\"><div class=\"imgbox\">".$this->LazyLoadImage("?imgE=".base64_encode($path),$THUMBNAIL_WIDTH, $THUMBNAIL_HEIGHT)."</div></a> $name</div>\n";
	}
	private function LazyLoadImage( $imgpath, $width, $height, $id = NULL, $class = NULL ){
		return "<img ".($id ? "id=\"i-".$id."\"": "")." class=\"lazy ".$class."\" src=\"_res/grey.gif\" data-original=\"$imgpath\" width=$width 	height=$height alt=\"$img\">";
	}
	private function GetExtImage($fn,$cntid){
		global $ICON_EXT;
		$fn = explode(".",$fn);
		$ext = strtolower($fn[count($fn) - 1]);
		if($this->drawctype == "folder") return $this->GetSilkIcon($ICON_EXT["folder"],"pull-right");
		return $ICON_EXT[$ext] ? $this->GetSilkIcon($ICON_EXT[$ext],"pull-right") : $this->GetSilkIcon($ICON_EXT["unknown"],"pull-right");
	}
	private function DrawHTML5VideoTag($data){
		//$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$contentid = sprintf("%u", crc32($data[1]));
		$fn = explode(".",$data[1]);
		$ext = strtolower($fn[count($fn) - 1]);
		$ret[] = ('<div class="row item text-center" id="'.$contentid.'">');
		$ret[] = ('<div class="col-md-12 text-center">');
		$ret[] = ('<video width="1000" height="563" controls>
  				<source src="'.$this->CurDir.$data[1].'" type="video/'.$ext.'">
  				Your browser is suck.
		</video><br><a href="?download='.urlencode($this->CurDir.$data[1]).'">'.$data[1]."</a>\n");
		$ret[] = ("</div></div>");
		return implode("",$ret);
		//finfo_close($finfo);
	}
	private function EncURL ( $TheVal ) //Url Encode, with slashes
	{ 
		return str_replace("%2F","/",rawurlencode($TheVal));
	} 
	private function EncPath ( $TheVal ) //Url Encode, with slashes
	{ 
		return str_replace("/","_",dirname($TheVal));
	} 
	private function GetSilkIcon ( $classname , $moarclass = NULL) //Url Encode, with slashes
	{ 
		return '<span class="ui-silk '.$classname.($moarclass ? " ".$moarclass : NULL).'"></span>';
	} 
}
?>