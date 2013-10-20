//Licensed under Creative Commons License
$('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
        || location.hostname == this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
           if (target.length) {
             $('html,body').animate({
                 scrollTop: target.offset().top-15
            }, 1000);
            return false;
        }
    }
});
var lasthighlight = false;
$("a").click(function(){
	if($(this).attr("data-parent")){
		var thisshit = this;
		var target = "#"+$(this).attr("data-parent") + "-b";
		$("article").hide( "slide", { direction:"left" } ,1000 ,function(){ LoadNewPage($(thisshit).attr("href")); });
		return false;
	}else if((/^#/).test($(this).attr("href"))){
		$($(this).attr("href")).addClass("highlight",1000, "easeOutBounce");
		if(lasthighlight != $(this).attr("href")){
			$(lasthighlight).removeClass("highlight",1000, "easeOutBounce");
		}
		lasthighlight = $(this).attr("href");
	}
});
function LoadNewPage( href ){
	//$("div.panel:hidden").show( <?php if($safedir) {?>"slide", { direction:"right" }<?php }else{ ?>"drop", { direction:"down" }<?php } ?> ,1500 );
	$("#loading").fadeIn("fast");
	$.get("_res/ajax.php",{ ajax:"breadcrumb" }).done(function(status,data){ 
	if(status == "success"){
		
	}else{
	alert("Warning: Couldn't Load Page, Redirecting...");
	window.location = href; 
	}
	});
}
$( 'button.close[id^="close-"]' ).click(function() {
$("#"+$(this).attr("data-target")+"-b").hide( "blind", { direction:"up" } ,1000 );
$(this).hide( "blind", { direction:"up" } ,500 ,function(){
	$("#open-"+$(this).attr("data-target")).show( "blind", { direction:"up" } ,500 );
});
});
$( 'button.close[id^="open-"]' ).click(function() {
$("#"+$(this).attr("data-target")+"-b").show( "blind", { direction:"up" } ,1000 );
$(this).hide( "blind", { direction:"up" } ,500 ,function(){
	$("#close-"+$(this).attr("data-target")).show( "blind", { direction:"up" } ,500 );
});
});
/*$("#closeoverlay").click(function(){
	$("#pageoverlay").fadeOut("fast");
	$("#mainVideo").pause();
});*/
//Functions Below here is not ready-to-use
/*
$("#playvideo").click(function(){
	$("#mainVideo")[0].play();
	$(this).hide();
	$("#pausevideo").show();
});
$("#pausevideo").click(function(){
	$("#mainVideo")[0].pause();
	$(this).hide();
	$("#playvideo").show();
});*/
//Toggle Video Size
$("#resizevideo").click(function(){
if($("#mainVideo").attr( 'width') == 640){
	$("#mainVideo").attr( 'width',1280 ).attr( 'height',720 );
	$("#videoWrap").toggleClass( 'width',1280 ).attr( 'height',720 );
	$(this).removeClass( "glyphicon-resize-full" ).addClass("glyphicon-resize-small");
}else{
	$("#mainVideo").attr( 'width',640 ).attr( 'height',360 );
	$("#videoWrap").attr( 'width',640 ).attr( 'height',360 );
	$(this).removeClass( "glyphicon-resize-small" ).addClass("glyphicon-resize-full");
}});
function ViewVideo( id ){
	if(!$(id)){ return false; }
	$("#videoWrap").show();
	$( "#videoWrap" ).dialog({
	minWidth: 650,
    minHeight: 360,
    modal: true,
	close: function( event, ui ) { $("#mainVideo")[0].pause(); $("video#mainVideo").attr("src",""); $(this).dialog("destroy"); $(this).hide();  },
	title: "Video Player: " + $("#"+id+" > div:nth-child(2) > a:nth-child(1)").text()
    });
	$("video#mainVideo").attr("src",CurDir + $("#"+id+" > div:nth-child(2) > a:nth-child(1)").text());
	
	//$("#playvideo").show();
	//$("#pausevideo").hide();
}