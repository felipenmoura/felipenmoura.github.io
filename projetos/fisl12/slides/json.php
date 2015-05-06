<div style='padding-top:46px;'>
	<table cellpadding='0' cellspacing='0' align='center'>
		<tr>
			<td style='padding-left:80px; vertical-align:top'>
				<br/><br/>
				<div>
					<b style='font-size: 40px;'>JSon</b>
				</div>
				<br/><br/>
				<div id='comet' style='display:none;'>
					AWS
				</div>
				<br/><br/>
				<div id='ap' style='display:none;'>
					YAML
				</div>
			</td>
			<td style='padding-left: 110px; padding-top:70px;' >
				<img src='images/json.png' />
			</td>
		</tr>
	</table>
</div>
<script>
//	alert(document.compatMode);
	Slides.slides[Slides.slideNumber].action= Array();
	
//	Slides.setBackgroundImage('images/nuvem5.jpg');
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#comet').fadeIn('slow', function(){
			$('#ap').fadeIn('slow', function(){
				$('#as').fadeIn('slow', function(){
					$('#hf').fadeIn('slow', function(){});
				});
			});
		});
	};
</script>
