<div style='padding-top:60px;'>
	<center>
		<br/>
		<br/>
		<br/>
		<img src='images/mr-monk.png' width='600'/>
	</center>
	<div style='position: absolute; left: 30px; top:75px;'>DDoS</div>
	<div style='position: absolute; left: 380px; top:50px;'>clickjacking</div>
	<div style='position: absolute; left: 210px; top:100px;'>SQLInjection</div>
	<div style='position: absolute; left: 250px; top:240px;'>XSL</div>
	<div style='position: absolute; left: 120px; top:180px;'>Usuários</div>
	<div style='position: absolute; left: 340px; top:230px;'>WebServices</div>
	<div id='ie' style='position: absolute; left: 340px; top:140px;'>Internet Explorer</div>
	<div id='browsers' style='display:none; position: absolute; left: 350px; top:150px;'>Navegadores</div>
	<div style='position: absolute; left: 40px; top:200px;'>Etc...</div>
</div>
<script>
	Slides.setBackgroundImage('images/nuvem5.jpg');
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		var strEl= document.getElementById('ie');
		var str= strEl.innerHTML.split('');
		strEl.innerHTML= '';
		var c= 0;
		$(str).each(function(){
			c++;
			$(strEl).append("<span style='position:relative;' id='"+(Slides.slides[Slides.slideNumber].id)+c+"' >"+this+"</span>");
		});
		strEl= $(strEl).find('span');
		c= 0;
		$(strEl).each(function(){
			c++;
			var time= Math.ceil(Math.random()*10) * 100;
			setTimeout("$('#"+(Slides.slides[Slides.slideNumber].id)+c+"').animate({top:450, opacity: 0 }, 'slow');", time);
		});
		setTimeout("$('#browsers').fadeIn();", 1500);
	};
</script>
