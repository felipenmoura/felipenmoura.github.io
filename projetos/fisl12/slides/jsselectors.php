<div style='padding-top:60px;'>
	<div id='parteUm'>
		<pre>
		
		
	<?php
			echo '<b>'.htmlentities("<table").'</b>'.htmlentities(" id='grid'").'<b>'.htmlentities(">
		<tr>
			<td>").'</b>'.htmlentities(" A ").'<b>'.htmlentities("</td>
			<td").'</b>'.htmlentities(" class='valor'").'<b>'.htmlentities(">").'</b>'.htmlentities(" R$35.40 ").'<b>'.htmlentities("</td>
		</tr>
		<tr>
			<td>").'</b>'.htmlentities(" B ").'<b>'.htmlentities("</td>
			<td").'</b>'.htmlentities(" class='valor'").'<b>'.htmlentities(">").'</b>'.htmlentities(" R$29.90").'<b>'.htmlentities(" </td>
		</tr>
		<tr>
			<td>").'</b>'.htmlentities(" C ").'<b>'.htmlentities("</td>
			<td ").'</b>'.htmlentities("class='valor'").'<b>'.htmlentities("> ").'</b>'.htmlentities("R$49.95 ").'<b>'.htmlentities("</td>
		</tr>
		<tr>
			<td>").'</b>'.htmlentities(" Total ").'<b>'.htmlentities("</td>
			<td ").'</b>'.htmlentities("class='total'").'<b>'.htmlentities("> ").'</b>'.htmlentities("R$115.25 ").'<b>'.htmlentities("</td>
		</tr>
	</table>").'</b>';
		?>
		</pre>
	</div>
	<div id='parteDois' style='display:none;'>
		<pre>
		
		
	  <i>var</i> linhas = <b>document</b>.getElementById(<s>'grid'</s>).
		                getElementsByTagName(<s>'TR'</s>);
							 
	  <i>var</i> valores= <b>Array()</b>;
	  <i>var</i> cur    = <s>null</s>;

	  <b>for</b>(<i>var</i> i=<s>0</s>, j=linhas.length; i&lt;j; i<s>++</s>)
	  {
		cur= linhas[i].<b>getElementsByTagName</b>(<s>'TD'</s>)[1];
		<b>if</b>(cur.className == <s>'valor'</s>)
		   valores.<b>push</b>(cur);
	  }
		</pre>
	</div>
	<div id='parteTres' style='display:none;'>
		<pre>
		
		
	  <i>var</i> valores= <b>document.querySelectorAll(<s>'#grid td.valor'</s>);</b>
		</pre>
	</div>
	<div id='parteQuatro' style='display:none;'>
		<pre>
	  <i>var</i> valores= <b>document.querySelector(<s>'#grid'</s>);</b>
		</pre>
	</div>
</div>
<script>
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteUm').fadeOut(function(){
			$('#parteDois').fadeIn();
		});
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#parteDois').fadeOut(function(){
			$('#parteTres').fadeIn();
		});
	};
	Slides.slides[Slides.slideNumber].action[2]= function(){
		$('#parteQuatro').fadeIn();
	};
</script>
