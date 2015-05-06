<div style='width:100%'>
	<img id='imgBack' src='images/ocean_4.jpg' style='position:abslute;left:0px; top:0x; z-indx:0; width:100%;height:100%;' />
	<span id='centeredTitle' style='position:absolute;font-size:48px;font-weight:bold;'>
		HTML5
	</span>
	<div id='subTtOne' style='display:none;position:absolute;top:92px;width:800px;'>
		<div style='color:white;padding-left:90px;'>
			Video
		</div>
		<center>
			<div class='add' style='width:320px;border:none;'>
				<video loop='loop' id='videoExemplo' >
					<source src='slides/external/video.mp4' type='video/mp4' />
					<source src='slides/external/video.ogg' type='video/ogg' />
				</video>
			</div>
			<input type='button' onclick="document.getElementById('videoExemplo').play();" value='Play' />
			<input type='button' onclick="document.getElementById('videoExemplo').pause(); document.getElementById('videoExemplo').currentTime= 0;" value='Stop' />
			<input type='button' onclick="document.getElementById('videoExemplo').pause();" value='Pause' />
			<input type='range' id='range' min='0' value='0' step='0.1' /><span id='curTime'>0</span><input type='checkbox' onclick="if(this.checked){document.getElementById('videoExemplo').setAttribute('controls', 'controls');}else{document.getElementById('videoExemplo').removeAttribute('controls');} ">
		</center>
		<div>

<pre class='dark' style="background-color:white;margin:auto;width: 600px;border:solid 1px black;margin-top:40px;">
 <b>&lt;video</b> <i>width</i>=<s>"320"</s> <i>height</i>=<s>"240"</s> <i>controls</i>=<s>"controls"</s><b>></b>
   <b>&lt;source</b> <i>src</i>=<s>"movie.ogg"</s> <i>type</i>=<s>"video/ogg"</s> <b>/></b>
   <b>&lt;source</b> <i>src</i>=<s>"movie.mp4"</s> <i>type</i>=<s>"video/mp4"</s> <b>/></b>
     <u >Seu navegador não suporta a tag de vídeo</u>
 <b>&lt;/video></b></pre>
		</div>
	</div>
	<div id='subTtTwo' style='color:white;display:none;'>
		Video
	</div>
</div>
<script>
//	alert(document.compatMode);
	setTimeout(function(){
		var cachedEl= document.getElementById('centeredTitle');
		$(cachedEl).fadeIn('slow');
		cachedEl.style.left= ((document.body.clientWidth/2) - (cachedEl.offsetWidth/2))+'px';
		cachedEl.style.top= '240px';
		setTimeout(function(){
			$(document.getElementById('centeredTitle')).animate({
				left:30,
				top:60
			}, function(){
				$('#subTtOne').fadeIn();
				//alert($('#subTtOne')[0]);
			});
		}, 3000);
	}, 3000);
	$('#imgBack').css('opacity', 0.6);
	document.getElementById('centeredTitle').style.display= 'none';
	Slides.setBackgroundImage('images/ocean_2.jpg');
	
	
	
	function parseTime(v)
	{
		var m= Math.floor(v);
		h= (''+(m/60)).substring(0,2);
		h= Math.floor(h);
		if(h<10)
			h= '0'+h;
		m= m%60;
		if(m<10)
			m= '0'+m;
		return h+':'+m;
	}
		
	var v= document.getElementById('videoExemplo');
	var ct= document.getElementById('curTime');
	var r= document.getElementById('range');
	
	v.addEventListener('loadedmetadata', function()
	{
		r.value= 0;
		r.min= 0;
		r.max= this.duration;
		r.onchange= function(){
			v.currentTime= this.value;
			document.getElementById('curTime').innerHTML= parseTime(this.value);
		}
	}, false);
	v.addEventListener('timeupdate', function(){
		r.value= this.currentTime;
		document.getElementById('curTime').innerHTML= parseTime(r.value);
	}, false);
</script>
