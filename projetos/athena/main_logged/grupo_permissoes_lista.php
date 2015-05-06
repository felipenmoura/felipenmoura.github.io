<?
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
if(!$db_connection)
{
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
}
?>
<input type="hidden"
	   name="groupeCode"
	   value="<? echo $_GET['selectedGroup']; ?>">

<table cellpadding="0"
	   cellspacing="0">
<?
	$qr_select= "select 
					pk_tipo_permissao,
					s_titulo 
				from 
					tb_tipo_permissao";
	$data= pg_query($db_connection, $qr_select);
	
	while($tipo_permissao = @pg_fetch_array($data))
	{
		$qr_select = "SELECT 
							pk_permissao,
							s_titulo 
					  FROM 
							tb_permissao 
					  WHERE fk_tipo_permissao = ".$tipo_permissao['pk_tipo_permissao'];
		$dataPermissao = pg_query($db_connection, $qr_select);
		?>
			<tbody>
			<tr>
					<td class="gridTitle">
						<input style="float:left" 
							   type="checkbox"
							   onclick="if(this.checked == true)
										{
											t = this.parentNode.parentNode.parentNode;
											i = t.getElementsByTagName('INPUT');
											for(j=0;j<i.length;j++)
											{
												if(i[j].type == 'checkbox')
													i[j].checked = true;
											}
										}else{
											t = this.parentNode.parentNode.parentNode;
											i = t.getElementsByTagName('INPUT');
											for(j=0;j<i.length;j++)
											{
												if(i[j].type == 'checkbox')
													i[j].checked = false;
											}
										}"
							   onmouseover="showtip(this,event,'Marcar Todos deste tipo')">
						<?php 
							echo htmlentities($tipo_permissao['s_titulo']);
						?>
					</td>
				</tr>
				<?php
					while($permissao = @pg_fetch_array($dataPermissao))
					{
						$qr_select = "select 
											case when 
												pk_grupo_permissao is not null then ' checked ' 
											end as checkbox
									  from tb_grupo_permissao 
									  where fk_grupo = ".$_GET['selectedGroup']." 
									  and fk_permissao = ".$permissao['pk_permissao'];
						$dataCheckBox = pg_query($db_connection, $qr_select);
						?>
							<tr>
								<td class="gridCell"
									style="text-align: left">
									<input type="checkbox"
										   name="permission_code[]"
										   id="permission_code<?php echo $permissao['pk_permissao'] ?>"
										   value="<?php echo $permissao['pk_permissao'] ?>"
									<?php
										$linha = pg_fetch_array($dataCheckBox);
										echo $linha['checkbox'];
										
									?>>
									<label for="permission_code<?php echo $permissao['pk_permissao'] ?>">
									<?php
										echo htmlentities($permissao['s_titulo']);
									?>
									</label>
								</td>
							</tr>
						<?php
					}
				?>
			<tbody>
		<?php
	}
	
?>
</table>