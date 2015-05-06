<?php
//session_start();
require_once("inc/valida_sessao.php");

require_once("../connections/flp_db_connection.php");
$db_connection= @connectTo();
if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?
	exit;
}
?>
<?
	$qr_select= "SELECT pk_agenda_evento,
						s_titulo,
						txt_descricao,
						TO_CHAR(dt_data_ini, 'DD/ MM/ YYYY') as dt_data_ini,
						TO_CHAR(dt_data_fin, 'DD/ MM/ YYYY') as dt_data_fin,
						TO_CHAR(hr_hora_ini, 'HH:MI:SS') as hr_hora_ini,
						TO_CHAR(hr_hora_fin, 'HH:MI:SS') as hr_hora_fin
				   FROM tb_agenda_evento
				  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
				  ORDER BY dt_data_ini,hr_hora_ini
				";
	$data= pg_query($db_connection, $qr_select);
	?>
	<center>
		<img src="../img/add.jpg"
			 style="cursor:pointer;"
			 onmouseover="showtip(this,event,'Adicionar Evento')"
			 onclick="creatBlock('Adicionar Evento','agenda_evento_add.php', 'block_adiciona_evento', 'noresize, nomaximize', false, '300/400')">
		<!--<img src="../img/vizualiza.jpg"
			 style="cursor:pointer;"
			 onmouseover="showtip(this,event,'Vizualizar Eventos')"
			 onclick="document.getElementById('tabela_vizualiza_eventos').style.display='block'">-->
		<img src="../img/edit.jpg"
			 style="cursor:pointer;"
			 onmouseover="showtip(this,event,'Editar Eventos')"
			 onclick="">
		<img src="../img/delete.gif"
			 style="cursor:pointer;"
			 onmouseover="showtip(this,event,'Excluir Eventos')"
			 onclick="excluiEventos()">
		<img src="../img/concluido.png"
			 style="cursor:pointer;"
			 onmouseover="showtip(this,event,'Marcar como Concluido')"
			 onclick="">
		<!--
		<input type="button"
			   class="botao"
			   value="Adicionar">
		<input type="button"
			   class="botao"
			   value="Excluir">
			   -->
	</center>
	<br>
	<table id="tabela_vizualiza_eventos" style="width: 100%">
	<tr style="border:solid 1px;background:#cccccc;">
				<td class="gridTitle">
				</td>
				<td class="gridTitle">
					Inicio
				</td>
				<td class="gridTitle">
					T&eacute;rmino
				</td>
				<td class="gridTitle">
					T&iacute;tulo
				</td>
			</tr>
			<form name="form_eventos" id="form_eventos">
	<?
	while($linha= pg_fetch_array($data))
	{
		?>
			<tr style="cursor:pointer;color:#000000" 
				onmouseover="this.style.color='blue'" 
				onmouseout="this.style.color='#000000'">
				<td>
					<input type="checkbox"
						   name="eventTo"
						   id="chbox_eventos"
						   value="">
				</td>
				<td width="150" height="40" style="padding-left:15px;" onclick="creatBlock('Editar Evento','agenda_evento_edit.php?pk_agenda_eventos=<? echo $linha['pk_agenda_evento']?>', 'agenda_eventos_edit_<? echo $linha['pk_agenda_evento']?>', 'noresize, nomaximize', false)">
					<?
						echo $linha['dt_data_ini'];
					?>
					&nbsp;&agrave;s&nbsp;
					<?
						echo $linha['hr_hora_ini'];
					?>
				</td>
				<td width="150" onclick="creatBlock('Editar Evento','agenda_evento_edit.php?pk_agenda_eventos=<? echo $linha['pk_agenda_evento']?>', 'agenda_eventos_edit_<? echo $linha['pk_agenda_evento']?>', 'noresize, nomaximize', false)">
					<?
						echo $linha['dt_data_fin'];
					?>
					&nbsp;&agrave;s&nbsp;
					<?
						echo $linha['hr_hora_fin'];
					?>
				</td>
				<td width="150" onclick="creatBlock('Editar Evento','agenda_evento_edit.php?pk_agenda_eventos=<? echo $linha['pk_agenda_evento']?>', 'agenda_eventos_edit_<? echo $linha['pk_agenda_evento']?>', 'noresize, nomaximize', false)">
					<?
						echo $linha['s_titulo'];
					?>
				</td>
			</tr>
		<?
	}
	?>
		</form>
		</table>