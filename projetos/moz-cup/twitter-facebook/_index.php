<?php
?>
<html>
	<head>
		<title>
			Firefox
		</title>
		<style type='text/css'>
			body
			{
				margin:0px;
				padding:0px;
			}
			.content
			{
				position:absolute;
				left:400px;
				top: 100px;
				background-color:#fff;
				-moz-border-radius:4px;
				padding:8px;
				width:340px;
				height:400px;
				font-family: Arial;
				-moz-box-shadow: 0 0 1em #000;
				-webkit-box-shadow: 0 0 1em #000;
				box-shadow: 0 0 1em #000;
			}
			#text
			{
				width: 210px;
				height:240px;
			}
		</style>
	</head>
	<body>
		<canvas id='canvas'>
			sorry, a real browser is required!
		</canvas>
		<div class='content'>
			<form name='f'>
				Right, in the textarea, the text you want to see in the image in the background.<br/>
				<center>
					<textarea id='text'>Compete in the
Firefox Cup by
installing your
team's persona!</textarea><br/>
					<input type='radio' id='imgTypeFaceBook' name='imgType' value='f' /> Facebook &nbsp; &nbsp; <input type='radio' value='t' checked='checked' name='imgType' /> Twitter<br/>
					<input type='button' value='See it' onclick="seeIt()">
				</center>
				<br/>
				Then, click in the "See it" button and use the right click to save the image and go ahead.
			</form>
		</div>
	</body>
	<script>
		var canvas= document.getElementById('canvas');
		var ctx= canvas.getContext('2d');
		var img= new Image();
		var imgF= new Image();
		imgF.src= 'images/facebook.jpg';
		
		canvas.width= 1920;
		canvas.height= 1200;
		
		function seeIt()
		{
			//#737570
			ctx.clearRect(0, 0, 1920, 1200);
			if(document.getElementById('imgTypeFaceBook').checked)
			{
				left= 5;
				lHeight= 28;
				top=230;
				lineLeft= 10;
				linkFontSize= 15;
				fontSize= 20;
				document.getElementById('canvas').width= 200;
				document.getElementById('canvas').height= 378;
				ctx.drawImage(imgF, 0, 0);
			}else{
					left= 20;
					lHeight= 28;
					top=330;
					lineLeft= 30;
					linkFontSize= 15;
					fontSize= 22;
					document.getElementById('canvas').width= 1920;
					document.getElementById('canvas').height= 1200;
					ctx.drawImage(img, 0, 0);
				 }
			
			ctx.textAlign= 'left';
			ctx.fillStyle = "#717870";
			ctx.shadowOffsetX = 0;
			ctx.shadowOffsetY = 0;
			ctx.shadowBlur    = 0;
			ctx.shadowColor   = 'rgba(255, 255, 255, 0.0)';
			ctx.font= "bold "+fontSize+"px sans-serif";
			
			var lines= document.getElementById('text').value.split('\n');
			for(var i=0, j=lines.length; i<j; i++)
			{
				ctx.fillText(lines[i], left, top + (lHeight*i));
			}
			
			ctx.font= "bold "+linkFontSize+"px sans-serif";
			ctx.shadowOffsetX = 0;
			ctx.shadowOffsetY = 0;
			ctx.shadowBlur    = 4;
			ctx.shadowColor   = 'rgba(100, 100, 100, 0.8)';
			ctx.fillStyle = "white";
			ctx.fillText("www.firefoxcup.com", lineLeft, top + (lHeight*i));
		}
		img.addEventListener('load', function(){
			seeIt(this);
		}, false);
		img.src= 'images/twitter-bg.jpg';
		
	</script>
</html>
