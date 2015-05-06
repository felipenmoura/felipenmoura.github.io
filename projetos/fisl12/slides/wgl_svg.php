<div style='padding-top:60px; padding-left:12px;'>
	<b>SVG</b>
	<pre>
  <b>&lt;svg></b>
    <b>&lt;circle</b> id=<s>"circulo"</s> class=<s>"classe"</s> cx=<s>"50%"</s> cy=<s>"50%"</s>
            r=<s>"100"</s> 
            fill=<s>"url(gradiente)"</s>
            onmousedown=<s>"alert('hello');"</s>/>
  <b>&lt;/svg></b>
	</pre>
	<b>WebGL</b> - Experimental
	<pre>
  <b>&lt;canvas</b> id=<s>"canvas"</s> width=<s>"768"</s> height=<s>"480"</s>><b>&lt;/canvas></b>

  <b>&lt;script></b>
    <i>var</i> canvas= document.getElementById(<s>"canvas"</s>);
    <i>var</i> ctx = canvas.<b>getContext</b>(<s>"experimental-webgl"</s>);
    ctx.<b>viewport</b>(0, 0, canvas.width, canvas.height);
  <b>&lt;/script></b>

	</pre>
</div>
