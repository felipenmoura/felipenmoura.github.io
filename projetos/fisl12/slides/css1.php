<div style='padding-top:60px;'>
	<center><div id='transformer' style='background-color:#f66; width: 240px; height:240px;margin:20px;'><br/><br/><br/>Demonstração</div></venter>
	
	<table>
		<tr>
			<td>
				Borda:
			</td>
			<td>
				<input type="range"
					   min="0"
					   max="40"
					   step="5"
					   value="0"
					   onchange='setBorderRadius(this.value);'/>
			</td>
			<td>
				Sombra:
			</td>
			<td>
				<input type="range"
					   min="0"
					   max="40"
					   step="5"
					   value="0"
					   onchange='setShadow(this.value);'/>
			</td>
		</tr>
		<tr>
			<td>
				Inclinação:
			</td>
			<td>
				<input type="range"
					   min="-40"
					   max="40"
					   step="10"
					   value="0"
					   onchange='setInclination(this.value);'/>
			</td>
			<td>
				Rotação:
			</td>
			<td>
				<input type="range"
					   min="0"
					   max="360"
					   step="5"
					   value="0"
					   onchange='setRadius(this.value);'/>
			</td>
		</tr>
		<tr>
			<td>
				Opacidade:
			</td>
			<td>
				<input type="range"
					   min="0"
					   max="1"
					   step="0.1"
					   value="1"
					   onchange='setOpacity(this.value);'/>
			</td>
			<td>
				Escala:
			</td>
			<td>
				<input type="range"
					   min="0"
					   max="2"
					   step="0.1"
					   value="1"
					   onchange='setScale(this.value);'/>
			</td>
		</tr>
	</table>
</div>
<script>
	function setBorderRadius(v)
	{
		var el= document.getElementById('transformer');
		$(el).css('-webkit-border-radius', v+'px');
		//transformer
	}
	function setShadow(v)
	{
		var el= document.getElementById('transformer');
		$(el).css('-webkit-box-shadow', '0px 0px '+v+'px #000');
	}
	function setInclination(v)
	{
		var el= document.getElementById('transformer');
		$(el).css('-webkit-transform', 'skew('+v+'deg)');
	}
	function setRadius(v)
	{
		var el= document.getElementById('transformer');
		$(el).css('-webkit-transform', 'rotate('+v+'deg)');
	}
	function setOpacity(v)
	{
		var el= document.getElementById('transformer');
		$(el).css('opacity', v);
	}
	function setScale(v)
	{
		var el= document.getElementById('transformer');
		$(el).css('-webkit-transform', 'scale('+v+')');
	}
</script>
