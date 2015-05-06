<div style='padding-top:60px;padding-left:10px;'>
	<div id='parteUm'>
		<center>
			W3Schools
			<br/>
			<img src='images/w3-statistics.png' class='add' />
		</center>
	</div>
	<div id='parteDois' style='display:none;'>
		<center>
			StatCounter
			<br/>
			<img src='images/statc.png' class='add' width='600' />
		</center>
	</div>
	<div id='parteTres' style='display:none;'>
		<center>
			Botaoteca.com.br
			<br/>
			<img src='images/bttk.png' class='add' width='700' />
		</center>
	</div>
</div>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteUm').fadeOut(function(){
			$('#parteDois').fadeIn();
		});
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#parteDois').fadeOut(function(){
			$('#parteTres').fadeIn();
		});
	};
</script>
