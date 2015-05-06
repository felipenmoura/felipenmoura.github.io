<?php
	//session_start();
	//$acessoWeb= 2;
	require_once("inc/valida_sessao.php");
	require_once("inc/styles.php");
	require_once("inc/query_control.php");
	require_once("inc/calendar_input.php");
	require_once("inc/class_explorer.php");
	if(!$db_connection)
	{
		include("../connections/flp_db_connection.php");
		$db_connection = connectTo();
	}
	exit;
?>
<div style="width: 100%;
			height: 100%;
			overflow-y: auto;">
	<table>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type="text">
			</td>
		</tr>
		<tr>
			<td>
				Atalho
			</td>
			<td>
				<select>
					<option value="">
					</option>
					<option value="">
						
					</option>
					<option value="">
					</option>
					<option value="">
					</option>
					<option value="">
					</option>
				</select>
			</td>
		</tr>
	</table>
</div>