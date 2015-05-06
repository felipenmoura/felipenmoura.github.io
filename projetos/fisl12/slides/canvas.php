<table style='margin-top:50px;'>
	<tr>
		<td colspan='2' style='height:70px;'>
			<table style='width:700px; display:none;' id='frase'>
				<tr>
					<td style='text-align:right;'>
						Não funciona no 
					</td>
					<td>
						<b><div id='ie' style='position: relative; left: 0px; top:0px;'>Internet Explorer</div></b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<img src='images/tetris.png' />
		</td>
		<td>
			<img src='images/draw.png' width='360' class='add' />
		</td>
	</tr>
	<tr>
		<td colspan='2' style='padding-left:135px;'>
			<pre>
			
<b>&lt;canvas</b> <i>id</i>=<s>'myCanvas'</s> <i>width</i>=<s>'360'</s> <i>height</i>=<s>'210'</s><b>></b>
	<u>Seu navegador não suporta Canvas</u>
<b>&lt;/canvas></b></pre>
		</td>
	</tr>
</table>
<script>
	Slides.setBackgroundImage('images/nuvem5.jpg');
	/*Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#frase').fadeIn();
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		var strEl= document.getElementById('ie');
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
			var time= Math.ceil(Math.random()*10) * 100;
			setTimeout("$('#"+(Slides.slides[Slides.slideNumber].id)+'_'+c+"').animate({top:450, opacity: 0 }, 'slow');", time);
		});
	};*/
</script>
