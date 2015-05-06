<div style='padding-top:100px;'>
	<div style='padding-left: 140px;' id='alcanceContent'>
		<div style='padding-left: 20px;'>SQL/NOSQL</div>
		<div style='padding-left: 310px;'>CSS3</div>
		<div style='padding-left: 110px;'>JavaScript</div>
		<div style='padding-left: 0px; font-size: 48px;'>HTML5</div>
		<div style='padding-left: 420px;'>NodeJS</div>
		<div style='padding-left: 230px;'>JSon</div>
		<div style='padding-left: 95px;'>OO</div>
		<div style='padding-left: 390px;'>Docs</div>
		<br/>
		<div style='padding-left: 270px;'>Base64</div>
		<div style='padding-left: 340px;'>DOM</div>
	</div>
	<img src='images/mac.png' style='position:absolute; left:40px; top:338px;' />
</div>
<script>
//	alert(document.compatMode);
	Slides.slides[Slides.slideNumber].action= Array();
	
	Slides.setBackgroundImage('images/nuvem5.jpg');
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#alcanceContent').fadeOut();
		Slides.setBackgroundImage('images/web1.jpg');
	};
</script>
