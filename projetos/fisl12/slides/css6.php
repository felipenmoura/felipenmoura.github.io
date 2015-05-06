<div style='padding-top:60px;paddin-left:6px;'>
	<center>
		<div class='animated' style='text-align:center;font-weight:bold; border:solid 1px #444; -webkit-border-radius: 4px; width:240px; height:90px;'>
			COMPRE
		</div>
	</center>
	<div id='parteUm'>
		<pre>        <u>/* crie sua animação */</u>
      <b>  @-webkit-keyframes</b> <i>compre</i>
	{
          <b>from</b>{
		   opacity: 0.3;
		   font-size: 20px;
		   color: #000;
		   background-color: white;
          }
          <b>to</b>{
		   opacity: 1.0;
		   font-size: 40px;
		   color: #900;
		   background-color: rgba(255, 180, 180, 0.7);
          }
	}
	</pre>
	</div>
	<div id='parteDois' style='display:none;'>
		<pre>  <u>/* use e especifique a sua animação */</u>
  <b>div</b>.<i>animated</i> {
    -webkit-animation-name: compre;
    -webkit-animation-duration: 1s;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: ease-out;
    -webkit-animation-direction: alternate;
  }</pre>
	</div>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteUm').fadeOut(function(){
			$('#parteDois').fadeIn();
		});
	};
</script>
