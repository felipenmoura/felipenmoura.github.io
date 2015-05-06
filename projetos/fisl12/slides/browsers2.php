<img id='image'
	 src='images/bottle.jpg'
	 style='position:absolute;
	 		left: -90px;
	 		top: -80px;
	 		opacity: 0.35;
	 		-webkit-transform: scale(0.9) rotate(0deg);'/>
<div id='browserCard' style='position:absolute; left:10px; height:380px; width:780px; top:90px; background-color:rgba(255,255,140, 0.25); border:solid 1px rgb(255,255,140); -webkit-border-radius:4px; '>
	<div>
		<table align="center">
			<tr>
				<td style='text-align:center;padding-top:20px;'>
					<b>Chrome</b>
				</td>
            </tr>
            <tr>
				<td style='padding-top:30px;'>
					<img src='images/nav-chrome.png'>
				</td>
			</tr>
            <tr>
				<td style='text-align:center;'>
					Webkit
				</td>
			</tr>
		</table>
	</div>
	<div style='display:none;'>
		
		<table align="center">
			<tr>
				<td style='text-align:center;padding-top:20px;'>
					<b>Firefox</b>
				</td>
            </tr>
            <tr>
				<td style='padding-top:30px;'>
					<img src='images/nav-ff.png'>
				</td>
			</tr>
            <tr>
				<td style='text-align:center;'>
					Gecko
				</td>
			</tr>
		</table>
	</div>
	
	
	<div style='display:none;'>
		
		<table align="center">
			<tr>
				<td style='text-align:center;padding-top:20px;'>
					<b>Safari</b>
				</td>
            </tr>
            <tr>
				<td style='padding-top:30px;'>
					<img src='images/nav-saf.png' height='200'>
				</td>
			</tr>
            <tr>
				<td style='text-align:center;'>
					Webkit
				</td>
			</tr>
		</table>
	</div>
	
	
	<div style='display:none;'>
		
		<table align="center">
			<tr>
				<td style='text-align:center;padding-top:20px;'>
					<b>Opera</b>
				</td>
            </tr>
            <tr>
				<td style='padding-top:30px;'>
					<img src='images/nav-op.png'>
				</td>
			</tr>
            <tr>
				<td style='text-align:center;'>
					Presto
				</td>
			</tr>
		</table>
	</div>
		
		
	
	<div style='display:none;'>
		<table align="center">
			<tr>
				<td style='text-align:center;padding-top:20px;'>
					<b>Internet explorer</b>
				</td>
            </tr>
            <tr>
				<td style='padding-top:30px;'>
					<img src='images/nav-ie.png'>
				</td>
			</tr>
            <tr>
				<td style='text-align:center;'>
					<s>Trident</s> Chakra
				</td>
			</tr>
		</table>
	</div>
</div>


<script>
	var colors= Array();
	colors[1]= Array('rgba(255,140,140,0.25)', 'rgb(255,70,70)');
	colors[2]= Array('rgba(140,140,255,0.25)', 'rgb(70,70,255)');
	colors[3]= Array('rgba(255,140,140,0.25)', 'rgb(255,70,70)');
	colors[4]= Array('rgba(140,140,255,0.25)', 'rgb(70,70,255)');
	colors[5]= Array('rgba(140,140,255,0.25)', 'rgb(70,70,255)');
	var curCard= 0;
	var browserCardAnim= function(){
		$('#browserCard div').eq(curCard).fadeOut(function(){
			curCard++;
			var o= $('#browserCard');
			o.animate({width:2, left:399}, function(){
				o.css('backgroundColor', colors[curCard][0]).css('border', 'solid 1px '+colors[curCard][0]);
				o.animate({width:780, left:10}, function(){
					$('#browserCard div').eq(curCard).fadeIn();
				})
			});
		});
	};
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		browserCardAnim();
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		browserCardAnim();
	};
	Slides.slides[Slides.slideNumber].action[2]= function(){
		browserCardAnim();
	};
	Slides.slides[Slides.slideNumber].action[3]= function(){
		browserCardAnim();
	};
	/*Slides.slides[Slides.slideNumber].action[4]= function(){
		browserCardAnim();
	};*/
</script>
