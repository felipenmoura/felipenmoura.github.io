<?php
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");

include("../connections/flp_db_connection.php");
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
	if($_POST)
	{
		if($_POST['s_privacidade_agenda_evento_add'] == true || $_POST['s_privacidade_agenda_evento_add'] == 'on')
			$s_privacidade= '1';
		else
			$s_privacidade= '0';
		$qr_insert= "INSERT into tb_agenda_evento
						(							
						    s_titulo, 
						    fk_usuario, 
						    txt_descricao, 
						    s_privacidade, 
						    dt_data_ini, 
						    dt_data_fin,
						    hr_hora_ini, 
						    hr_hora_fin
						)
					 VALUES
						(
							'".$_POST['s_titulo_agenda_evento_add']."',
							'".$_SESSION['pk_usuario']."',
							'".$_POST['s_descricao_agenda_evento_add']."',
							'".$s_privacidade."',
							TO_DATE('".$_POST['dt_data_ini_agenda_evento_add']."', 'DD/MM/YYYY'),
							TO_DATE('".$_POST['dt_data_fin_agenda_evento_add']."', 'DD/MM/YYYY'),
							'".$_POST['hr_hora_ini_h_agenda_evento_add'].":".$_POST['hr_hora_ini_m_agenda_evento_add']."',
							'".$_POST['hr_hora_fin_h_agenda_evento_add'].":".$_POST['hr_hora_fin_m_agenda_evento_add']."'
						)
					";					
			$data= pg_query($db_connection, $qr_insert);
			if($data)
			{
				?>
					<script>
						top.showAlert('informativo','Evento adicionado');
						parent.onlyEvalAjax('agenda_eventos_cadastrados.php', 'top.setLoad(true)', 'top.setLoad(false); document.getElementById("conteudo_agenda_eventos").innerHTML= ajax');
						top.c.closeBlock('block_adiciona_evento');
						//agenda_contatos_grupos_lista
					</script>
				<?
			}else{
					echo pg_last_error($data);
					?>
						<script>
							top.showAlert("erro","Erro ao tentar salvar no banco");
							//top.c.closeBlock('novo_usuario_contatos');
						</script>
					<?
				 }
	}else // Senão POST
	{
?>
<form method="POST"
	  action="agenda_evento_add.php"
	  target="hiddenFrameAgendaEventoAdd"
	  id="form_agenda_evento_add">
	<table>
		<tr>
			<td style="width: 90px;">
				T&iacute;tulo
			</td>
			<td>
				<input type="text"
					   maxlength="35"
					   style="width: 160px;"
					   name="s_titulo_agenda_evento_add"
					   id="s_titulo_agenda_evento_add">
			</td>
		</tr>
		<tr>
			<td>
				Data de in&iacute;cio
			</td>
			<td>
				<?
					makeCalendar('dt_data_ini_agenda_evento_add', '');
				?>
			</td>
		</tr>
		<tr>
			<td>
				Data de t&eacute;rmino
			</td>
			<td>
				<?
					makeCalendar('dt_data_fin_agenda_evento_add', '');
				?>
			</td>
		</tr>
		<tr>
			<td>
				Hora (in&iacute;cio)
			</td>
			<td>
				<select name="hr_hora_ini_h_agenda_evento_add">
					<?
						for($i=0; $i<24; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option ".$ii.">
									".$ii."
								  </option>";
						}
						?>
				</select> 
				<b>
				: 
				</b>
				<select name="hr_hora_ini_m_agenda_evento_add">
					<?
						for($i=0; $i<60; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option ".$ii.">
									".$ii."
								  </option>";
						}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Hora (t&eacute;rmino)
			</td>
			<td>
				<select name="hr_hora_fin_h_agenda_evento_add">
					<?
						for($i=0; $i<24; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option ".$ii.">
									".$ii."
								  </option>";
						}
					?>
				</select> 
				<b>
				: 
				</b>
				<select name="hr_hora_fin_m_agenda_evento_add">
					<?
						for($i=0; $i<60; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option ".$ii.">
									".$ii."
								  </option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				Descri&ccedil;&atilde;o
			</td>
			<td>
				<textarea name="s_descricao_agenda_evento_add"
						  id="s_descricao_agenda_evento_add"
						  style="width: 160px;
								 height: 100px;
								 overflow: auto;"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="checkbox"
					   name="s_privacidade_agenda_evento_add"
					   id="s_privacidade_agenda_evento_add"
					   checked> 
				Privado (apenas eu posso visualizar)
			</td>
		</tr>
		<tr>
			<td colspan="2"
				style="text-align: center;">
				<input type="button"
					   class="botao"
					   value="Agendar"
					   onclick="if(document.getElementById('s_titulo_agenda_evento_add').value=='' || document.getElementById('dt_data_ini_agenda_evento_add').value == '' || document.getElementById('dt_data_fin_agenda_evento_add').value == ''){alert('Os campos Titulo, Data Inicial e Data Final devem ser preenchidos');}else{document.getElementById('form_agenda_evento_add').submit()}">
			</td>
		</tr>
	</table>
</form>
<iframe name="hiddenFrameAgendaEventoAdd"
		id="hiddenFrameAgendaEventoAdd"
		style="display: none;">
</iframe>
		<?
	}
?>