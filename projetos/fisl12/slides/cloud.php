<img src='images/cloud.png' id='cloudImg' style='width:100%;height:545px; border-right:none; border-left:none; border-top:none;' class='add' />
<div style='padding-top:50px;
            display:none;
            position: absolute;
            left: 40px;
            top:140px;' id="contentOfSlide">
    Uma núvem é o acúmulo de vapor que se agrupa acima das cam...
</div>
<script>
	Slides.setBackgroundImage('images/nuvem5.jpg');
    
    Slides.slides[Slides.slideNumber].action= Array();
	
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#cloudImg').animate({opacity: 0.4});
        $('#contentOfSlide').show();
	};
</script>