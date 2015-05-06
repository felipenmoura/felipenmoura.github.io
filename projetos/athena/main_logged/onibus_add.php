<?php
//$acessoWeb= 2;
	require_once('inc/valida_sessao.php');
	require_once('inc/styles.php');
	require_once('inc/query_control.php');
	require_once('inc/calendar_input.php');
	require_once('inc/class_explorer.php');
	include('../connections/flp_db_connection.php');
		$db_connection = connectTo();
?>
<iframe id='onibus_add_hiddenFrame'
		name='onibus_add_hiddenFrame'
		style='display: none;'>
</iframe>
<div style='width: 100%;
			height: 100%;
			overflow: auto;'>
	<form name='onibus_add_form'
		  id='onibus_add_form'
		  target='onibus_add_hiddenFrame'
		  method='POST'
		  action='onibus_add'>
		<table>
			<tr>
				
				<td>
					Nome
				</td>
				<td>
					<input type='text'
						   name='tb_onibus.s_nome'
						   id='tb_onibus.s_nome'
						   class='gridCell'>
				</td>
				<td>
					Codigo
				</td>
				<td>
					<input type='text'
						   name='tb_onibus.pk_onibus'
						   id='tb_onibus.pk_onibus'
						   class='gridTitle'>
				</td>
			</tr>
			<tr>
				<td colspan='4'
					style='text-align: center;'>
					<table>
						<tr>
							<td>
								<input type='submit'
									   value='Salvar'
									   class='botao'>
							</td>
							<td>
								<input type='reset'
									   value='Limpar'
									   class='botao'>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>