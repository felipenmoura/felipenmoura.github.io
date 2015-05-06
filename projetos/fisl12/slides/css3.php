<!--<div style='padding-top:140px;' id='parteUm'>
	<pre>
	@namespace foo url(http://www.example.com);
		foo|h1 { color: blue }  /* first rule */
		foo|* { color: yellow } /* second rule */
		*|h1 { color: green }
		h1 { color: green }</pre>
</div>-->
<div style='padding-top:70px;'>
	<center>
		<div class='pseudo' style='width:340px;padding-left:12px;padding-right:12px;zoom:1.6;background-color:#fff;'>
			<P>A primeira letra, no capítulo de um livro antigo, já estilizada via CSS. O resto do capítulo segue normalmente.</P>
		</div>
	</center>
	<pre>	@charset "ISO-8859-1";
	@font-face
	{
		font-family: "fonte";
		src: url("./fonte.ttf");
	}
	P{
		font-size: 12pt; line-height: 1.2; text-align:justify;
		font-family: "fonte";
	}
	P::first-letter{
		font-size: 200%; font-weight: bold;
		float: left; font-style:italic;
	}
	</pre>
</div>
<script>
	/*Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteUm').fadeOut(function(){
			$('#parteDois').fadeIn();
		});
	};*/
</script>
