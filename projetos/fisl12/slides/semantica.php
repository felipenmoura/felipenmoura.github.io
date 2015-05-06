<div style='padding-top:90px;padding-left:40px;'>
	<div id='parteUm'>
		A <b>inteligência</b> por trás do código
		<br/><br/>
		<ul type='disc' style='width:600px; margin-left:80px;'>
			<li>
				Uso de XML<br/><br/>
			</li>
			<li>
				Uso de RDF<br/><br/>
			</li>
			<li>
				Padrões indicados pela W3C
			</li>
		</ul>
		<br/>
		<span style='font-size:28px;'>Dá sentido aos elementos em uma página comum.</span>
	</div>
	<div id='parteDois' style='display:none;padding-right:56px;'>
		<form>
			<table align='left'>
				<tr>
					<td>
						Números:
					</td>
					<td>
						<b>*</b><img src='images/opera-numbers.png' />
					</td>
				</tr>
				<tr>
					<td>
						E-mail:
					</td>
					<td>
						<input type="email" />
					</td>
				</tr>
				<tr>
					<td>
						Sliders:
					</td>
					<td>
						<input type="range"
							   min="0"
							   max="10"
							   step="1"
							   value="5" />
					</td>
				</tr>
				<tr>
					<td style='vertical-align:top;'>
						Data:
					</td>
					<td>
						<nobr><b>*</b><img src='images/opera-date.png' align='right' /></nobr>
					</td>
				</tr>
			</table>
			<img src='images/iphone.png' align='right' width='240' class='add' />
		</form>
	</div>
	<div id='parteTres' style='display:none; margin-top:-26px; margin-left:-20px;'>
		<pre style='margin:0px; margin-bottom:12px;'>  &lt;!DOCTYPE html></pre>
		<table cellpadding='0'>
			<tr>
				<td style='vertical-align:top; border:solid 1px #666;padding:0px;'>
<pre style='margin:2px;'>  &lt;header>
    &lt;hgroup>
      &lt;h1>Título&lt;/h1>
      &lt;h2>Sub-Título&lt;/h2>
    &lt;/hgroup>
  &lt;/header></pre>
				</td>
				<td style='vertical-align:top; border:solid 1px #666;'>
<pre style='margin:2px;'>  &lt;nav>
    &lt;ul>
      Navegação, links e índices
    &lt;/ul>
  &lt;/nav></pre>
				<td/>
			</tr>
			<tr>
				<td style='vertical-align:top; border:solid 1px #666;'>
<pre style='margin:2px;'>  &lt;section>
    &lt;article>
      &lt;header>
        &lt;h1>Título&lt;/h1>
      &lt;/header>
      &lt;section>
        Conteúdo desta sessão 
      &lt;/section>
    &lt;/article>
  &lt;/section></pre>
				</td>
				<td style='vertical-align:top; border:solid 1px #666;'>
<pre style='margin:2px;'>  &lt;aside>
    Relacionado ao assunto "anterior" 
  &lt;/aside></pre>
				<td/>
			</tr>
			<tr>
				<td style='vertical-align:top; border:solid 1px #666;' colspan='2'>
<pre style='margin:2px;'>  &lt;footer>
    http://exemplo.com Copyright © 2010.
  &lt;/footer></pre>
				</td>
			</tr>
		</table>
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
</script>
