$('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
        || location.hostname == this.hostname) {
		$($(this).attr("href")).addClass("highlight",1000, "easeOutBounce");
		if(lasthighlight != $(this).attr("href")){
			$(lasthighlight).removeClass("highlight",1000, "easeOutBounce");
		}
		lasthighlight = $(this).attr("href");
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

$("a[href^='?b']").click(function(e) {
		LoadNewPage($(this).attr("href"),false);
		return false;
});
function LoadNewPage( href , rs){
	if(!href) { return; };
	$("article").hide( "slide", { direction:"left" } ,1000);
	setTimeout(function(){
	$("#loading").fadeIn("fast");
	$.get("_res/ajax.php",{ ajax:"breadcrumb", b:href.substr(3) }).done(function(data1,status1){ 
	if(status1 == "success"){
		$("#breadcrumb").html( data1 );
		$.get("_res/ajax.php",{ ajax:"article", b:href.substr(3) }).done(function(data2,status2){
			if(status2 == "success"){
				$("article").html( data2 );
				$.get("_res/ajax.php",{ ajax:"navbar", b:href.substr(3) }).done(function(data3,status3){
					if(status3 == "success"){
						$("nav.navbar").html( data3 );
						$("article").show();
						$("div.panel:hidden").show( "slide", { direction:"right", complete: function() { $("img.lazy").lazyload({ effect : "fadeIn" },1000);} } ,1500 );
						$("#loading").fadeOut("fast");
						if(rs){
							history.replaceState({ LoadNewPage:true }, document.title, href);
						}else{
							history.pushState({ LoadNewPage:true }, document.title, href);
						}
						document.title = PageTitle + href.substr(3);
							$("a[href^='?b']").click(function(e) {
								var thisshit = this;
								LoadNewPage($(thisshit).attr("href"));
								return false;
							});
					}else{
						alert(status3+": Couldn't Load Page, Redirecting...");
						window.location = href; 
					}
				});
			}else{
				alert(status2+": Couldn't Load Page, Redirecting...");
				window.location = href; 
			}
		});
	}else{
		alert(status1+": Couldn't Load Page, Redirecting...");
		window.location = href; 
	}
	});
	},1000)
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
}
$(window).bind("popstate", function(e) {
	if (!e.originalEvent.state.LoadNewPage) return;
    LoadNewPage("?b="+getUrlVars()["b"],true);
});

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}
