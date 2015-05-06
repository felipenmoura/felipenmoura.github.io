<!-- 82/148 --- 77/153 -->
<div style='padding-top:70px;'>
	<table align='center' id='spriteBlock'>
		<tr>
			<td align='right' valign='top'>
				<b>
					Sprites
				</b>
			</td>
			<td>
				<pre style='font-size:18px;'>
				
<b style='color:#69a;'>var</b> spriteBgPos= 0;
<b style='color:#69a;'>var</b> timing= setInterval<b>(function(){</b>
	<b style='color:#69a;'>var</b> el= document.getElementById<b>(</b><b style='color:#a77;'>'sprite_red'</b><b>)</b>;
	spriteBgPos= spriteBgPos - 77;
	el.style.backgroundPosition= spriteBgPos+<b style='color:#a77;'>'px 0px'</b>;
<b>}</b>, 100<b>)</b>;</pre>
			</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<div style='width: 692px; height:153px;
							background-image:url(images/sprite-red.png);
							background-position: 3px 0px;
							background-color: #ccf;
							border:solid 1px #66a;'
					 id='sprite_red'>
					<div style='float:left; height:153px; width:310px; background-color:#ddf; border-right: solid 1px #66a;'>
					</div>
					<div style='float:right; height:153px; width:305px; background-color:#ddf; border-left: solid 1px #66a;'>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<img id='spriteMenus' src='images/sprite-menus.jpg' width='400' class='add' style='margin-top:12px; display:none;' />
			</td>
		</tr>
	</table>
	<table id='uriBlock' style='display:none;margin-left:22px;'>
		<tr>
			<td style='vertical-align:top;'>
				<b>base64</b>
			</td>
		</tr>
		<tr>
			<td style='font-size:18px;'><br/><br/>
				<b style='color:#444;'>Modo tradicional</b>
				<pre>
.classe {
    width: 45px;
    background: url(imagem.jpg) no-repeat;
}</pre>
			</td>
		</tr>
		<tr>
			<td style='font-size:18px;'><br/>
				<b style='color:#444;'>Usando Base64</b>
				<pre>
.classe {
    width: 45px;
    background: <b style='color:#444;'>url(data:image/png;base64,&lt;data>)</b> no-repeat;
    _background: url(imagem.png) no-repeat;
}</pre>
<br/>
<b>*MHTML</b>
			</td>
		</tr>
	</table>
<div>
<script>
	$('#sprite_red div').css('opacity', 0.8);
	var spriteBgPos= 0;
	var spritesActived= false;
	var timing= setInterval(function(){
		if(spritesActived)
		{
			var el= document.getElementById('sprite_red');
			if(!el)
			{
				clearInterval(timing);
				timing= false;
				return false;
			}
			spriteBgPos= spriteBgPos - 77;
			el.style.backgroundPosition= spriteBgPos+'px 0px';
		}
	}, 100);
	

	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		spritesActived= true;
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#spriteMenus').fadeIn();
	};
	Slides.slides[Slides.slideNumber].action[2]= function(){
		$('#spriteBlock').fadeOut(function(){
			$('#uriBlock').fadeIn();
		});
	};
</script>
