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
				Write in the text you'd like to see on the image.<br/>
				<center>
					<textarea id='text'>Compete in the
Firefox Cup by
installing your
team's persona!</textarea><br/>
					<input type='radio' id='imgTypeFaceBook' name='imgType' value='f' /> Facebook &nbsp; &nbsp; <input type='radio' value='t' checked='checked' name='imgType' /> Twitter<br/>
					<input type='button' value='See it' onclick="seeIt()">
				</center>
				<br/>
				Then click the "See it" button and use the right click to save the image and go ahead
			</form>
		</div>
	</body>
	<script>

/*	
	var lineLimit= 14;
	str= "copa do mundo";
					//rx= new RegExp('.{2, '+(lineLimit - 3)+'} .{2,}', 'i');
					//alert(lineLimit);
					rx= new RegExp('.{2,'+(lineLimit-3)+'} .{2}', 'i');
					alert(rx.test(str));
*/
	
	
	
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
				left= 100;
				lHeight= 28;
				top=230;
				linkLeft= 100;
				linkFontSize= 15;
				fontSize= 20;
				document.getElementById('canvas').width= 200;
				document.getElementById('canvas').height= 378;
				ctx.drawImage(imgF, 0, 0);
			}else{
					left= 110;
					lHeight= 28;
					top=330;
					linkLeft= 110;
					linkFontSize= 15;
					fontSize= 22;
					lineLimit1= 16;
					lineLimit2= 20;
					lineLimit= 24;
					document.getElementById('canvas').width= 1920;
					document.getElementById('canvas').height= 1200;
					ctx.drawImage(img, 0, 0);
				 }
			
			ctx.textAlign= 'center';
			ctx.fillStyle = "#717870";
			ctx.shadowOffsetX = 0;
			ctx.shadowOffsetY = 0;
			ctx.shadowBlur    = 0;
			ctx.shadowColor   = 'rgba(255, 255, 255, 0.0)';
			ctx.font= "bold "+fontSize+"px sans-serif";
			
			var lines= document.getElementById('text').value.split('\n');
			var charSize= 0;
			var carSobrando= 0;
			
			var arTmp= Array();
			var strTmp= '';
			for(var i=0, j=lines.length; i<j; i++)
			{
				if(lines[i].length <= lineLimit)
				{
					arTmp.push(lines[i]);
				}
				else
				{
					if(lines[i].indexOf(' ')>-1)
					{ // look for the best space to break
						while(lines[i].length >= lineLimit)
						{
							strTmp= lines[i].substring(0, (lines[i].lastIndexOf(' ')));
							lines[i]= lines[i].substring(lines[i].lastIndexOf(' '), lines[i].length);
							arTmp.push(strTmp);
						}
						arTmp.push(lines[i]);
						/*lines[i]= lines[i].split('');
						for(var x= lineLimit-1; x>=0; x--)
						{
							lines[i][x]
						}*/
					}else{// crop the string
							while(lines[i].length >= lineLimit)
							{
								strTmp= lines[i].substring(0, lineLimit);
								lines[i]= lines[i].substring(lineLimit, lines[i].length);
								arTmp.push(strTmp);
							}
							arTmp.push(lines[i]);
						 }
					/*rx= new RegExp('^.{2,'+(lineLimit-3)+'} ', 'i');
					if(rx.test(lines[i]))
					{ // better treatment of spaces
						alert(lines[i].match(rx));
					}
					if(lines[i].indexOf(' ')>-1)
					{ // braking for any space
						lines[i]= lines[i].split(' ');
						for(var x=0; x<lines[i].length; x++)
						{
							arTmp.push(lines[i][x]);
						}
					}else{ // cropping the string
							while(lines[i].length >= lineLimit)
							{
								strTmp= lines[i].substring(0, lineLimit);
								lines[i]= lines[i].substring(lineLimit, lines[i].length);
								arTmp.push(strTmp);
							}
							arTmp.push(lines[i]);
						 }
					*/
				}
			}
			lines= arTmp;
			
			for(i=0, j=lines.length; i<j; i++)
			{
				if(lines[i].length <= lineLimit1)
				{
					ctx.font= "bold "+ (fontSize) +"px sans-serif";
				}else{
						if(lines[i].length <= lineLimit2)
						{
							ctx.font= "bold "+ (fontSize-4) +"px sans-serif";
						}else{
								ctx.font= "bold "+ (fontSize-8) +"px sans-serif";
							 }
					 }
				ctx.fillText(lines[i], left, top + (lHeight*i));
			}
			
			ctx.font= "bold "+linkFontSize+"px sans-serif";
			ctx.shadowOffsetX = 0;
			ctx.shadowOffsetY = 0;
			ctx.shadowBlur    = 4;
			ctx.shadowColor   = 'rgba(100, 100, 100, 0.8)';
			ctx.fillStyle = "white";
			ctx.fillText("www.firefoxcup.com", linkLeft, top + (lHeight*i));
		}
		img.addEventListener('load', function(){
			seeIt(this);
		}, false);
		img.src= 'images/twitter-bg.jpg';
		
	</script>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1270869-12']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>
