<br/><br/><br/><br/><br/>
<center>
	<div id='mythPic'>
		<img src="images/myth.jpg"
			 class='add'
			 alt=""
			 style="-webkit-transform: rotate(-20deg) scale(1) skew(15deg);
			 		-moz-transform: rotate(-20deg) scale(1) skew(15deg);
					border:solid 4px #fff; border-bottom: solid 42px #fff;" />
		<div style="-webkit-transform: rotate(-20deg) scale(1) skew(15deg);
					-moz-transform: rotate(-20deg) scale(1) skew(15deg);
					font-size:18px;
					margin-top:-30px;font-family:'commersial_script';">
			Elefantes cor de rosa existem!<br/>
			<span style="padding-left:240px;">
				<s>Ahã Claudia, senta lá...</s>
			</span>
		</div>
	</div>
</center>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
	var t= 40;
		for(var i=0; i<40; i++)
		{
			setTimeout("$('#mythPic').css('-moz-transform', 'rotate(-"+(10*i)+"deg)');"+
					   "$('#mythPic').css('-webkit-transform', 'rotate(-"+(10*i)+"deg)');", t*i);
			if(i>30)
			{
				setTimeout("$('#mythPic').css('opacity', '"+(1/(i-30))+"');", t*i);
			}
		}
		setTimeout("$('#mythPic').css('display', 'none'); Slides.next();", t*++i);
	};
</script>
