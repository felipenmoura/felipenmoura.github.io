<div style='padding-top:60px; padding-left:6px;' id='parteUm'>
	<b>RGBA</b><br/>
	<pre>  .fundo{ background-color: rgba(100, 100, 200, 0.7); }</pre>
	<b>HSLA</b><br/>
	<pre>  .fonte{ color: hsla(10, 3%, 3%, 0.7); }</pre>
	<b>Gradiente</b><br/>
		<pre>
  .fundo{
    background: -webkit-gradient(radial, 500 0, 50,
                                 300 0, 300, from(#44d), to(#000));
  }</pre>
	<center>
		<div style='height:100px; background: -webkit-gradient(radial, 500 0, 50, 300 0, 300, from(#44d), to(#000)); width: 600px;'>
		</div>
	</center>
</div>
<div style='padding-top:60px; padding-left:6px; display:none;' id='parteDois'>
	<b>
		Background-size
	</b>
	<pre>  .fundo{ background:url(imagem.png) center center no-repeat;
          background-size: auto; <u>/* auto, cover, contain or i%*/</u> }</pre>
	<b>Multiplos backgrounds</b>
	<pre>  .fundo {background: url(img1.png) 10px 10px no-repeat, 
                      url(img2.png) center repeat-x; }
	</pre>
	<b>Reflexão</b>
	<pre>  -webkit-box-reflect: below 10px
  -webkit-gradient(linear, left top, left bottom, 
                   from(transparent), to(rgba(255, 255, 255, 0.27)));</pre>
	<div style='-webkit-box-reflect: below -4px
			    -webkit-gradient(linear, left top, left bottom, 
                                 from(transparent), to(rgba(0, 0, 0, 0.3)));
				text-align:center;
				font-weight:bold;
				color:#449;'>
		Pausa para Reflexão!
	</div>
</div>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteUm').fadeOut(function(){
			$('#parteDois').fadeIn();
		});
	};
</script>
