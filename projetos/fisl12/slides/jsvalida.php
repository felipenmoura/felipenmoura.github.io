<div style='padding-top:60px;'>
	<form id='fModel' action='notFound' target='hidden'>
		<table align='center'>
			<tr>
				<td style='font-size: 20px;'>
					<label for='nome'>Nome</label>
				</td>
				<td>
					<input type='text' name='nome' />
				</td>
			</tr>
			<tr>
				<td style='font-size: 20px;'>
					<label for='tel'>Telefone</label>
				</td>
				<td>
					<input type='tel' name='telefone' required />*
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<center>
						<textarea maxlength='10' style='width:100%;' ></textarea>
					</center>
				</td>
			</tr>
		</table>
		<center>
			<input id='bt' type='button' value='NÃO' disabled='disabled' onclick="formTest(this.parentNode.parentNode);" />
		</center>
	</form>
	<div id='parteDois' style='display:none;'>
	<pre>
	
  <b>&lt;input</b> type=<s>'tel'</s> name=<s>'telefone'</s> <b>required /></b>*
  
  <b>&lt;textarea</b> maxlength=<s>'10'</s><b>>&lt;/textarea></b>
</pre>
	</div>
	<div id='parteTres' style='display:none;'>
		<pre>
  <i>var</i> f= document.forms[<s>'fModel'</s>];
  <i>var</i> bt= document.getElementById(<s>'botao'</s>);
  f.telefone.addEventListener(<s>'keyup'</s>, <b>function()</b>{
    <b>if</b>(f.<b>checkValidity()</b>)
    {
      bt.removeAttribute(<s>'disabled'</s>);
      bt.value= <s>'Válido'</s>;
    }else
    {
      bt.setAttribute(<s>'disabled'</s>, <s>'disabled'</s>);
      bt.value= <s>'NÃO'</s>;
    }
  }, <s>false</s>);

		</pre>
	</div>
	<div id='parteQuatro' style='display:none;'>
		<pre>
  f.onsubmit= <b>function()</b>{
    alert(<b>this.checkValidity()</b>);
    return <s>false</s>;
  }
  
  <b>input:</b><s>invalid</s>
  {
    background:url(img_invalid.png) left no-repeat;
  }
		</pre>
	</div>
	<iframe id='hidden' name='hidden' style='display:none;'></iframe>
</div>
<script>
	document.forms['fModel'].telefone.addEventListener('keyup', function(){
		if(document.getElementById('fModel').checkValidity())
			$('#bt').removeAttr('disabled').attr('value', 'Valido');
		else
			$('#bt').attr('disabled', 'disabled').attr('value', 'NÃO');
	}, false);
	function formTest(f){
		alert(f.checkValidity());
	}
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#parteDois').fadeIn();
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#parteDois').fadeOut(function(){
			$('#parteTres').fadeIn();
		});
	};
	Slides.slides[Slides.slideNumber].action[2]= function(){
		$('#parteTres').fadeOut(function(){
			$('#parteQuatro').fadeIn();
		});
	};
</script>
