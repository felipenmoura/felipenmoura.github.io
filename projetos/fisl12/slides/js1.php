<div style='padding-top:60px;'>
	<div style='position:absolute; left: 90px; top:110px;'>
		<b>Conheça</b> seu cliente muito bem
	</div>
	<div id='fw' style='position:absolute; left: 50px; top:210px;display:none;'>
		Use frameworks para <b>agilizar</b> o seu trabalho
	</div>
	<div id='learn' style='position:absolute; left: 40px; top:310px; display:none;'>
		<table>
			<tr>
				<td>
					<img src='images/gear.png' />
				</td>
				<td>
					Aprenda <b>JavaScript</b> antes
					<div style='padding-left: 190px;'>
						de aprender um <b>Framework</b>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id='duvide' style='position:absolute; left: 160px; top:440px; display:none;'>
		<b>Jamais</b> duvide do poder do Javascript
	</div>
</div>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#fw').show('slide');
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#learn').show('slide');
	};
	Slides.slides[Slides.slideNumber].action[2]= function(){
		$('#duvide').show('slide');
	}
</script>
