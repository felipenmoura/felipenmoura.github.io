<div style='padding-top:46px;'>
	<table cellpadding='0' cellspacing='0'>
		<tr>
			<td>
				<img src='images/terminator.png' />
			</td>
			<td style='padding-left:80px; vertical-align:top;'>
				<br/><br/>
				<div>
					<b style='font-size: 40px;'>Ajax</b>
				</div>
				<br/>
				<div id='comet' style='display:none;'>
					Comet
				</div>
				<br/>
				<div id='ap' style='display:none;'>
					<sub>AjaxPush, HTTP Streamming, Reverse Ajax, etc...</sub>
				</div>
				<br/>
				<div id='as' style='display:none;'>
					AppendScript
				</div>
				<br/>
				<div id='hf' style='display:none;'>
					HiddenFrame
				</div>
			</td>
		</tr>
	</table>
</div>
<script>
//	alert(document.compatMode);
	Slides.slides[Slides.slideNumber].action= Array();
	
	Slides.setBackgroundImage('images/nuvem5.jpg');
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
