<img id='image'
	 src='images/bottle.jpg'
	 style='position:absolute;
	 		left: -460px;
	 		top: -220px;
	 		-webkit-transform: scale(1.8) rotate(-10deg);
	 		-webkit-transition-property:-webkit-transform, left, top, width, opacity;
			-webkit-transition-duration: 1s;
			-webkit-transition-timing-function: ease-in;
	 		'/>
	 <div id='slideMenu' style='display:none; position:absolute; left:40px; top:90px;'>
	 	Conheça alguns dos maiores navegadores<br/>de nossos tempos:<br/>
	 	<div style='display:none;margin:20px;margin-left:60px;'>
	 		Mozilla Firefox
	 	</div>
	 	<div style='display:none;margin:20px;margin-left:60px;'>
	 		Google Chrome
	 	</div>
	 	<div style='display:none;margin:20px;margin-left:60px;'>
	 		Apple Safari
	 	</div>
	 	<div style='display:none;margin:20px;margin-left:60px;'>
	 		Opera's Opera
	 	</div>
	 	<div style='display:none;margin:20px;margin-left:60px;'>
	 		MS Intern... Internet Explorer?!
	 	</div>
	 </div>
<script>

	var showSlideMenu= function(){
		var m= $('#slideMenu');
		m.fadeIn();
		var c= 700;
		var i= 0;
		m.find('div').each(function(){
			setTimeout("$('#slideMenu').find('div').eq("+i+").fadeIn('fast');", c);
			i++;
			c+= 700;
		});
	}

	setTimeout(function(){
		var backImg= document.getElementById('image');
		$(backImg).css("-webkit-transform", "scale(0.9) rotate(0deg)").css('left', '-90px').css('top', '-80px');
		setTimeout(function(){
			//$('#image').css('opacity', 0.35);
			setTimeout(function(){
				//try{showSlideMenu();}catch(e){};
				Slides.next();
			}, 400);
		}, 1600);
	}, 3000);
</script>
