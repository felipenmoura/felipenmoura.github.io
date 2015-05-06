<div style='padding-top:60px;'>
	<center>
		<img src='images/bolt2.jpg' width='300' class='add' />
		<img id='bolt1' src='images/bolt1.png' width='300' style='position:absolute; left:250px; top:60px;'/>
	</center>
	<div>
		<div style='padding-left: 40px; margin:10px; display:none;' id='frase1'>
			JavaScript vai lhe <b>salvar</b> tempo
		</div>
		<div style='padding-left: 80px; margin:10px; display:none;' id='frase2'>
			vai lhe <b>salvar</b> requisições
		</div>
		<div style='padding-left: 120px; margin:10px; display:none;' id='frase3'>
			irá <b>salvar</b> processamento
		</div>
		<div id='frase4' style='display:none;'>
			<div style='margin:10px;'>
				<center>mas não salvará o seu <b>emprego</b></center>
			</div>
			<div style='font-size: 40px; margin:10px;margin-top:20px;'>
				<center>JS <b>não</b> lhe protegerá dos inimigos</center>
			</div>
		</div>
	</div>
</div>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#frase1').fadeIn(function(){
			$('#frase2').fadeIn(function(){
				$('#frase3').fadeIn();
			});
		});
		//Slides.next();
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#bolt1').fadeOut();
		$('#frase4').fadeIn();
		//Slides.next();
	};
	setTimeout(function(){Slides.next();}, 600);
</script>
