<?php
	//session_start();
	//$acessoWeb= 'Roteiros operacionais';
	require_once("inc/valida_sessao.php");
	clearstatcache();
	
	if($_GET['id'])
	{
		$targetTextEditor= $_GET['id'];
	}
?>
<?
	if($_POST)
	{
		//$arquivo= fopen($_POST['url'].$_POST[''])
		echo "ID= ".$_POST['idTextEditor'];
		echo "<br>URL= ".$_POST['url'];
		echo "<br>NOME= ".$_POST['titulo_new_'.$_POST['idTextEditor']];
		echo "<br>CONTEUDO= ".$_POST['textEditorContent'];
		
		$arquivo= @fopen($_POST['url'].$_POST['titulo_new_'.$_POST['idTextEditor']].'.rtf', 'w+');
		if(!$arquivo)
			$arquivo= @fopen($_POST['url'].'/'.$_POST['titulo_new_'.$_POST['idTextEditor']].'.rtf', 'w+');
		if(!$arquivo)
			$arquivo= @fopen(substr_replace($_POST['url'], '', 0,3).'/'.$_POST['titulo_new_'.$_POST['idTextEditor']].'.rtf', 'w+');
		if(!$arquivo)
		{
			?>
				<script>
					alert('Ocorreu um erro ao tentar salvar/criar o documento');
				</script>
			<?
			exit;
		}else{
				?>
					<script>
						alert('Documento salvo');
					</script>
				<?
				exit;
			 }
	}else{
			?>

				<form action="editor_de_textos.php"
					  method="POST"
					  id="editor_texto_<? echo $idTextEditor; ?>"
					  name="editor_texto_<? echo $idTextEditor; ?>"
					  target="hiddenFrameee">
					<input type="hidden"
						   name="idTextEditor"
						   value="<? echo $idTextEditor; ?>">
					<input type="hidden"
						   name="url"
						   style="width: 500px;"
						   value="<? echo $_GET['fileurl'];//echo substr($_GET['fileurl'], strrpos($_GET['fileurl'], '/')+1, strlen($_GET['fileurl'])) ;?>">
					<input type="hidden"
						   name="textEditorContent"
						   id="textEditorContent_<? echo $idTextEditor; ?>"
						   value="">
					<table width="100%">
						<tr>
							<td style=" vertical-align: top;
										width : 50px;
										text-align: left"
								colspan="2">
								T&iacute;tulo &nbsp; 
								<input type="text"
									   id="titulo_new_<? echo $idTextEditor; ?>"
									   name="titulo_new_<? echo $idTextEditor; ?>"
									   style="width: 350px;"
									   value="<? echo substr($_GET['fileurl'], strrpos($_GET['fileurl'], '/')+1, strlen($_GET['fileurl'])); ?>">
								
							</td>
						</tr>
						<tr>
							<td style="text-align: left;"
								colspan="2">
								<nobr>
								<!--<img src="img/salvar.gif"
									 class="bt_wordEditor"
									 onclick="saveAs('<? echo $idTextEditor; ?>', document.getElementById('titulo_new_<? echo $idTextEditor; ?>').value)"
									 style="cursor: pointer"
									 alone="true"
									 onmouseover="showtip(this, event, 'Salvar como')">-->
								<!-- Salvar -->
								<img src="img/recortar.gif"
									 class="bt_wordEditor"
									 onclick="recortar('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 alone="true"
									 onmouseover="showtip(this, event, 'Recortar')">
								<!-- Copiar -->
								<img src="img/copiar.gif"
									 class="bt_wordEditor"
									 onclick="copiar('<? echo $idTextEditor; ?>')"
									 alone="true"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Copiar')">
									
								<!-- Colar -->
								<img src="img/colar.gif"
									 class="bt_wordEditor"
									 onclick="colar('<? echo $idTextEditor; ?>')"
									 alone="true"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Colar')">
									
								<!-- Desfazer --> 
								<img src="img/desfazer.gif"
									 class="bt_wordEditor"
									 onclick="desfazer('<? echo $idTextEditor; ?>')"
									 alone="true"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Desfazer')">
									
								<!-- Refazer -->
								<img src="img/refazer.gif"
									 class="bt_wordEditor"
									 onclick="refazer('<? echo $idTextEditor; ?>')"
									 alone="true"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Refazer')">
									
								<!-- Negrito --> 
								<img src="img/negrito.gif"
									 class="bt_wordEditor"
									 onclick="negrito('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Negrito')">
								
								<!-- Itálico -->
								<img src="img/italico.gif"
									 class="bt_wordEditor"
									 onclick="italico('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Italico')">
									
								<!-- Sublinhado -->
								<img src="img/sublinhado.gif"
									 class="bt_wordEditor"
									 onclick="sublinhado('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Sublinhado')">
								
								<!-- Alinhar à Esquerda -->
								<img src="img/alinhamentoesquerda.gif"
									 class="bt_wordEditor"
									 onclick="alinharEsquerda('<? echo $idTextEditor; ?>');"
									 style="cursor: pointer"
									 id="leftAlign"
									 child="centerAlign, rightAlign"
									 onmouseover="showtip(this, event, 'Alinhar a esquerda')">
									
								<!-- Alinhar ao Centro -->
								<img src="img/centralizado.gif"
									 class="bt_wordEditor"
									 id="centerAlign"
									 onclick="centralizado('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 child="leftAlign, rightAlign"
									 onmouseover="showtip(this, event, 'Centralizar')">
									
								<!-- Alinha à Direita -->
								<img src="img/alinhamentodireita.gif"
									 class="bt_wordEditor"
									 id="rightAlign"
									 onclick="alinharDireita('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 child="leftAlign, centerAlign"
									 onmouseover="showtip(this, event, 'Alinhar a direita')">
								<!-- Numeração -->
								<img src="img/numeracao.gif"
									 class="bt_wordEditor"
									 onclick="numeracao('<? echo $idTextEditor; ?>')"
									 style="cursor: pointer"
									 id="ordList"
									 child="unordList"
									 onmouseover="showtip(this, event, 'Lista numerada')">

								<!-- Marcadores -->
								<img src="img/marcador.gif"
									 class="bt_wordEditor"
									 onclick="marcadores('<? echo $idTextEditor; ?>')"
									 id="unordList"
									 child="ordList"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Lista não ordenada')">
								
								<!-- Inserir Imagem --> 
								<img src="img/agiplan_logo_ico.gif"
									 class="bt_wordEditor"
									 onclick="urlImageToTextEditor= prompt('Digite o endereço da imagem', 'http://www.agiplan.com.br/'); insertImage('<? echo $idTextEditor; ?>', urlImageToTextEditor);"
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Inserir imagem')">
								
								<!-- imprimir -->
								<img src="img/print.jpg"
									 class="bt_wordEditor"
									 onclick="printTextEditor('<? echo $idTextEditor; ?>')"
									 id="unordList"
									 child=""
									 style="cursor: pointer"
									 onmouseover="showtip(this, event, 'Imprimir')">
								<br>
								Font 
								<select name="fonte_<? echo $idTextEditor; ?>"
										onchange="formatFont('<? echo $idTextEditor; ?>', this.value); //fonte(this.options[this.selectedIndex].value)" style="width: 140px;">
									<option value="Arial">Arial</option>
									<option value="Courier">Courier</option>
									<option value="Sans Serif">Sans Serif</option>
									<option value="Tahoma">Tahoma</option>
									<option value="Times New Roman">Times New Roman</option>
									<option value="Verdana">Verdana</option>
								</select>
								Tamanho 
								<select name="tamanho_<? echo $idTextEditor; ?>"
										onchange="formatFontSize('<? echo $idTextEditor; ?>', this.value)"
										style="width: 40px;">
									<option value=""></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top;
									   font-size: 11px"
								colspan="2"
								width="100%">
								<iframe name="editor_de_textos_<? echo $idTextEditor; ?>"
										id="editor_de_textos_<? echo $idTextEditor; ?>"
										src="text_editor_iframe.php?fileurl=<? echo $_GET['fileurl']; ?>"
										style="width: 100%;
												 height: 330px;"></iframe>
								<br>
								<input type="hidden">
									   <!--name="noticia_integra_hidden_<? echo $idTextEditor; ?>"
									   id="noticia_integra_hidden_<? echo $idTextEditor; ?>">-->
							</td>
						</tr>
					</table>
					<center>
						<input type="submit"
							   value="salvar"
							   onclick="saveTextEditor('<? echo $idTextEditor; ?>')"
							   class="botao">
					</center>		
				</form>

			<style type="text/css">
			.bt_wordEditor
			{
				border: solid 1px #333366;
				width: 20px;
				height: 20px;
			}
			</style>
			<script>
				makeEditor('<? echo $idTextEditor; ?>', '<? echo $_GET['fileurl']; ?>');
			</script>
			<flp_script>
				makeEditor('<? echo $idTextEditor; ?>', '<? echo $_GET['fileurl']; ?>');
		<?
		}
?>