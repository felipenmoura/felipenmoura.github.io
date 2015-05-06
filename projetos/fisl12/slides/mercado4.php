<div style='padding-top:60px;'>
</div>
<div id='parteUm' style='position:absolute;left:0px;top:240px;text-align:center;width:100%; font-size:80px;'>
	<b>
		The End
	</b>
</div>
<div id='linksUteis' style='display:none; position:absolute;left:40px; top:50px;'>
	<b>Links úteis</b>
	<pre>
  <b>HTML5</b>
    http://www.html5rocks.com/
    http://tableless.com.br/html5/
    http://diveintohtml5.org/
  <b>CSS3, JavaScript</b>
    http://www.w3.org/TR/css3-roadmap/
    http://www.css3.info/preview/
  <b>Outros</b>
    http://acid3.acidtests.org/
    http://www.findmebyip.com/
    http://chromeexperiments.com/
    http://www.dhteumeuleu.com/
    https://developer.mozilla.org/en-US/demos/
	</pre>
</div>
<div id='adeus' style='display:none; position:absolute;left:40px; top:90px;width:100%;'>
	<center><b>Adeus, e obrigado pelos peixes</b></center>
	<br/><br/>
	<div>
		Autor: Felipe Nascimento de Moura<br/>
		E-mail: felipenmoura@gmail.com<br/>
		<!--WebSite: felipenascimento.org<br/>-->
		Twitter: @felipenmoura<br/>
		<div id='signature' style='background:url(images/signature.png) left top no-repeat; width:2px; height:200px;margin-left:480px;'>
		</div>
	</div>
</div>
<script>
	
	Slides.setBackgroundImage('images/web1.jpg');
	
	Slides.slides[Slides.slideNumber].action= Array();
	/*Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteUm').fadeIn('fast');
	};*/
	Slides.slides[Slides.slideNumber].action[0]= function(){
		
		var strEl= document.getElementById('parteUm').getElementsByTagName('B')[0];
		var str= strEl.innerHTML.split('');
		strEl.innerHTML= '';
		var c= 0;
		$(str).each(function(){
			c++;
			$(strEl).append("<span style='position:relative;' id='"+(Slides.slides[Slides.slideNumber].id)+'_'+c+"' >"+this+"</span>");
		});
		strEl= $(strEl).find('span');
		c= 0;
		$(strEl).each(function(){
			c++;
			time= Math.ceil(Math.random()*10) * 100;
			setTimeout("$('#"+(Slides.slides[Slides.slideNumber].id)+'_'+c+"').animate({top:450, opacity: 0 }, 'slow');", time);
		});
		setTimeout(function(){
			Slides.setBackgroundImage('images/nuvem5.jpg');
			$('#linksUteis').fadeIn();
		}, c*100);
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#linksUteis').fadeOut(function(){
			$('#adeus').fadeIn(function(){
				$('#signature').animate({width:260, height:200}, 4000);
			});
		});
	};
</script>
