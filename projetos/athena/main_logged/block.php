<?
	session_start();
?>
<table cellpadding="0"
		   cellspacing="0"
		   onmousedown="setFocus(this);"
		   id="table_tabelas_de_comissoes"
		   style="position: absolute;
				  left: 40px;
				  top: 90px;
				  width: 180px;
				  height: 100px;"
		   bloco="true">
		<tr style="cursor: default;
				   height: 20px;">
			<td style="width: 7px;">
				<img src="img/left_top_blue_focus.gif"><br>
			</td>
			<td style="background-image: url(img/top_blue_focus.gif);
					   background-repeat: repeat-x;"
				id="td_botoes_comissoes"
				ondblclick="maximiza(document.getElementById('max_bloco'))">	<!---->
				
				<table cellpadding="0"
					   cellspacing="0"
					   width="100%">
					<tr>
						<td  style="float: left;"
							 class="title"
							 id="div_titulo_comissoes">
							--%TITULO%--
						</td>
						<td style="text-align: right"
							style="text-align: right;
								padding-right: 4px;
								padding-left: 7px;
								float: right;"
							id="div_botoes_comissoes">
							<nobr>
								<img src="img/min_block.gif"
									 onmouseover="this.src='img/min_block_over.gif'"
									 onmouseout="this.src='img/min_block.gif'"
									 onclick="minimiza(this)">
								<img src="img/max_block.gif"
									 onmouseover="this.src= this.src.replace(/.gif/, '_over.gif')"
									 onmouseout="this.src = this.src.replace(/_over.gif/, '.gif')"
									 onclick="maximiza(this)"
									 id="max_bloco">
								<img src="img/close_block.gif"
									 onmouseover="this.src='img/close_block_over.gif'"
									 onmouseout="this.src='img/close_block.gif'"
									 onclick="closeBlock(this)">
							</nobr>
						</td>
					</tr>
				</table>
			</td>
			<td style="width: 7px;">
				<img src="img/right_top_blue_focus.gif"><br>
			</td>
		</tr>
		<tr style="width: 7px;">
			<td style="background-image: url(img/left.gif);
					   background-repeat: repeat-y;"
				onmousedown="resize('wL', this, event)">
				<br>
			</td>
			<td bgcolor="#f0f0f0"
				style="vertical-align: top;">a
				<?
					echo "a".$_SESSION['last_url_loadded']."b";
					require_once($_SESSION['last_url_loadded']);
				?>
			</td>
			<td style="background-image: url(img/right.gif);
					   background-repeat: repeat-y;
					   background-position: right;
					   cursor: w-resize;"
				onmousedown="resize('wR', this, event)">
				<br>
			</td>
		</tr>
		<tr style="cursor: default;
				   height: 5px;">
			<td style="width: 7px;
				   height: 5px;">
				<img src="img/left_bottom.gif"><br>
			</td>
			<td style="background-image: url(img/bottom.gif);
					   background-repeat: repeat-x;
					   height: 5px;
					   cursor: s-resize;"
				onmousedown="resize('s', this, event)">
			</td>
			<td style="width: 7px;
				   height: 5px;">
				<img src="img/right_bottom.gif"
					 style="cursor: nw-resize;"
					 onmousedown="resize('nw', this, event)"><br>
			</td>
		</tr>
	</table>
	
	<script>
		flp_makeItDragable('table_tabelas_de_comissoes', 'div_titulo_comissoes, div_botoes_comissoes, td_botoes_comissoes');
		dragOpacity= false;
	</script>