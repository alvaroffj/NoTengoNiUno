function output(txt) {
    //    alert(txt);
    $("#output").find("#texto").html("<pre>"+txt+"<pre>");
}

$(document).ready(function() {
    //        $('#wrapper').corner();
    //        $('#footer').corner();
    });

Cufon.replace('#logo');
//Cufon.replace('#footer');
//Cufon.replace('h1', {textShadow: '1px 1px #000'});
//Cufon.replace('h2', {textShadow: '1px 1px #000'});
//Cufon.replace('h3', {textShadow: '1px 1px #000'});
$(function($){
    var d = new Date();
    var nFotos = 19;
    var fotoHoy = d.getDate()%nFotos;
    $.supersized({
        start_slide : 0,		//Start slide (0 is random) //Requires multiple background images
        vertical_center : 1,		//Vertically center background
        horizontal_center : 1,		//Horizontally center background
        min_width : 1000,	//Min width allowed (in pixels)
        min_height : 700,	//Min height allowed (in pixels)
        fit_portrait : 1,		//Portrait images will not exceed browser height
        fit_landscape : 0,		//Landscape images will not exceed browser width
        image_protect :	1,		//Disables image dragging and right click with Javascript
        slides : [ 		//Background image
            { image : 'http://notengoniuno.flawers.me/public/background/'+fotoHoy+'.jpg'}
        ]
    });
});