<?php
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
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

	if($_POST)
	{
		if($_POST['s_privacidade_agenda_evento_add'] == true || $_POST['s_privacidade_agenda_evento_add'] == 'on')
			$s_privacidade= '1';
		else
			$s_privacidade= '0';
		$qr_update= "UPDATE tb_agenda_evento 
					 SET s_titulo = '".$_POST['s_titulo_agenda_evento_edit']."',  
						 txt_descricao = '".$_POST['s_descricao_agenda_evento_edit']."', 
						 s_privacidade = '".$s_privacidade."', 
						 dt_data_ini = TO_DATE('".$_POST['dt_data_ini_agenda_evento_edit']."', 'DD/MM/YYYY'),
						 dt_data_fin = TO_DATE('".$_POST['dt_data_fin_agenda_evento_edit']."', 'DD/MM/YYYY'),
						 hr_hora_ini = '".$_POST['hr_hora_ini_h_agenda_evento_edit'].":".$_POST['hr_hora_ini_m_agenda_evento_edit']."',
						 hr_hora_fin = '".$_POST['hr_hora_fin_h_agenda_evento_edit'].":".$_POST['hr_hora_fin_m_agenda_evento_edit']."'
					WHERE pk_agenda_evento = ".$_POST['pk_evento_agenda_evento_edit'];				
			$data= pg_query($db_connection, $qr_update);
			if($data)
			{
				?>
					<script>
						top.showAlert('informativo','Evento Atualizado');
						parent.onlyEvalAjax('agenda_eventos_cadastrados.php', 'top.setLoad(true)', 'top.setLoad(false); document.getElementById("conteudo_agenda_eventos").innerHTML= ajax');
						top.c.closeBlock('agenda_eventos_edit_<? echo $_POST['pk_evento_agenda_evento_edit']; ?>');
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
	}

	$qr_select= "SELECT pk_agenda_evento,
						s_titulo,
						txt_descricao,
						TO_CHAR(dt_data_ini, 'DD/ MM/ YYYY') as dt_data_ini,
						TO_CHAR(dt_data_fin, 'DD/ MM/ YYYY') as dt_data_fin,
						TO_CHAR(hr_hora_ini, 'HH24') as hr_hora_ini_h,
						TO_CHAR(hr_hora_fin, 'HH24') as hr_hora_fin_h,
						TO_CHAR(hr_hora_ini, 'MI') as hr_hora_ini_m,
						TO_CHAR(hr_hora_fin, 'MI') as hr_hora_fin_m,
						CASE WHEN s_privacidade = '1' THEN ' checked' ELSE '' END as s_privacidade
				   FROM tb_agenda_evento
				  WHERE pk_agenda_evento = ".$_GET['pk_agenda_eventos']."
				  ORDER BY dt_data_ini,hr_hora_ini
				";
	$data= pg_query($db_connection, $qr_select);
	$linha= @pg_fetch_array($data);
?>

<form method="POST"
	  action="agenda_evento_edit.php"
	  target="hiddenFrameAgendaEventoedit"
	  id="form_agenda_evento_edit">
	<input type="text" 
		   name="pk_evento_agenda_evento_edit"
		   style="display:none" 
		   value="<? echo $_GET['pk_agenda_eventos']?>">
	<table>
		<tr>
			<td style="width: 90px;">
				T&iacute;tulo
			</td>
			<td>
				<input type="text"
					   maxlength="35"
					   style="width: 160px;"
					   name="s_titulo_agenda_evento_edit"
					   id="s_titulo_agenda_evento_edit"
					   value="<? echo $linha['s_titulo']?>">
			</td>
		</tr>
		<tr>
			<td>
				Data de in&iacute;cio
			</td>
			<td>
				<?
					makeCalendar('dt_data_ini_agenda_evento_edit', $linha['dt_data_ini']);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Data de t&eacute;rmino
			</td>
			<td>
				<?
					makeCalendar('dt_data_fin_agenda_evento_edit', $linha['dt_data_fin']);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Hora (in&iacute;cio)
			</td>
			<td>
				<select name="hr_hora_ini_h_agenda_evento_edit">
					<?
						for($i=0; $i<24; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option value='".$ii."' ".(($i == $linha['hr_hora_ini_h'])? ' selected' : '')." >
									".$ii."
									</option>";
						}
					?>
				</select> 
				<b>
				: 
				</b>
				<select name="hr_hora_ini_h_agenda_evento_edit">
					<?
						for($i=0; $i<24; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option value='".$ii."' ".(($i == $linha['hr_hora_ini_m'])? ' selected' : '')." >
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
				<select name="hr_hora_fin_h_agenda_evento_edit">
					<?
						for($i=0; $i<24; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option value='".$ii."' ".(($i == $linha['hr_hora_fin_h'])? ' selected' : '')." >
									".$ii."
									</option>";
						}
					?>
				</select> 
				<b>
				: 
				</b>
				<select name="hr_hora_fin_m_agenda_evento_edit">
					<?
						for($i=0; $i<24; $i++)
						{
							$ii= ($i<10)? '0'.$i: $i;
							echo "<option value='".$ii."' ".(($i == $linha['hr_hora_fin_m'])? ' selected' : '')." >
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
				<textarea name="s_descricao_agenda_evento_edit"
						  id="s_descricao_agenda_evento_edit"
						  style="width: 160px;
								 height: 100px;
								 overflow: auto;"><? echo $linha['txt_descricao']?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="checkbox"
					   name="s_privacidade_agenda_evento_edit"
					   id="s_privacidade_agenda_evento_edit"
					   <?
							echo $linha['s_privacidade'];
					   ?>> 
				Privado (apenas eu posso visualizar)
			</td>
		</tr>
		<tr>
			<td colspan="2"
				style="text-align: center;">
				<input type="button"
					   class="botao"
					   value="Atualizar"
					   onclick="if(document.getElementById('s_titulo_agenda_evento_edit').value=='' || document.getElementById('dt_data_ini_agenda_evento_edit').value == '' || document.getElementById('dt_data_fin_agenda_evento_edit').value == ''){alert('Os campos Titulo, Data Inicial e Data Final devem ser preenchidos');}else{document.getElementById('form_agenda_evento_edit').submit()}">
			</td>
		</tr>
	</table>
</form>
<iframe name="hiddenFrameAgendaEventoedit"
		id="hiddenFrameAgendaEventoedit"
		style="display: none;">
</iframe>
		<?
?>