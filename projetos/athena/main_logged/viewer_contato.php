<?php

// PERMISSÃO
$acessoWeb= 12;

require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/styles.php");
require_once("inc/class_explorer.php");
require_once("inc/class_abas.php");
include("../connections/flp_db_connection.php");
$db_connection= @connectTo();
$PREID= 'clientes_viewer_id';

if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?php
	exit;
}


	if ($_POST)
	{
		if ($_POST['op'] == 'fisica')
		{
			$qr_selectCliente= " SELECT F.pk_pes_fisica,
										F.fk_dados_pessoais,
										F.cpf,
										F.s_rg,
										D.s_usuario,
										D.vfk_usuario,
										U.pk_usuario,
										D.bl_status
								 FROM tb_pess_fisica F
								 INNER JOIN tb_dados_pessoais D
								 ON (F.fk_dados_pessoais = D.pk_dados_pessoais)
								 INNER JOIN tb_usuario U
								 ON(U.pk_usuario = D.vfk_usuario)
								 WHERE s_usuario is NOT NULL 
								 AND D.bl_status = 1
								 AND U.bl_cliente = 1 "; // U.bl_status = Cliente Ativo ou Inativo
								 
			if ($_POST['nome'])
			{
				$qr_selectCliente.= " AND UPPER(D.s_usuario) like UPPER('%".trim($_POST['nome'])."%')";
			}
							
			if ($_POST['clienteCPF'])
			{
				$qr_selectCliente.= " AND F.cpf like '%".trim($_POST['clienteCPF'])."%'";
			}	
			
			if ($_POST['clienteRG'])
			{
				$qr_selectCliente.= " AND F.s_rg = '".trim($_POST['clienteRG'])."'";
			}	
			
			$qr_selectCliente.= " ORDER BY D.s_usuario";
			$dataCli= pg_query($db_connection, $qr_selectCliente);
			$numRows = pg_num_rows($dataCli);
			if ($dataCli)
			{
				?>
					<div id="clientViewerDivPai">
					<table width="100%">
					<tr>
						<td class="gridTitle">
							Clientes
						</td>
					</tr>
				<?php
				if (!$numRows)
					{
						echo "<tr><td class='gridCell'><font color='red'>Nenhum Registro Encontrado...</font></td></tr>";
					}
				while($arrayCli = pg_fetch_array($dataCli))
				{
					?>
						<tr onmouseover="this.style.backgroundColor= '<? echo $style['unSubItem']['bgMouseOver']; ?>';
												 showtip(this,event,'<?php echo str_replace("'", "\'", htmlentities($linhaCli['s_usuario']));?>')"
									onmouseout="this.style.backgroundColor= '<? echo $style['unSubItem']['backGround']; ?>';">
							<td class="gridCell"
								style="text-align:left;
									   cursor:pointer"
								onclick="creatBlock('<?php echo str_replace("'", "\'", htmlentities($arrayCli['s_usuario'])); ?>', 'cliente_view_data.php?pk_dados_pessoais=<?php echo $arrayCli['fk_dados_pessoais'] ?>&pk_usuario=<?php echo $arrayCli['pk_usuario'] ?>&tipo_pess=F','cliente_view_data<?php echo $arrayCli['pk_usuario'] ?>');">
								<?php
									{
										echo $arrayCli['s_usuario'];
									}
								?>
							</td>
						</tr>
					<?php
				}
				?>
					</table>
					</div>
						<script>
							top.filho.document.getElementById('clientes_viewer_list_fis').innerHTML = document.getElementById('clientViewerDivPai').innerHTML; 
						</script>
				<?php
				exit;
			}
		}else
			{ // Juridica
				$qr_selectCliente= " SELECT J.pk_pes_juridica,
											J.fk_dados_pessoais,
											D.s_usuario,
											D.vfk_usuario,
											U.pk_usuario,
											D.bl_status
									 FROM tb_pess_juridica J
									 INNER JOIN tb_dados_pessoais D
									 ON (J.fk_dados_pessoais = D.pk_dados_pessoais)
									 INNER JOIN tb_usuario U
									 ON(U.pk_usuario = D.vfk_usuario)
									 WHERE s_usuario is NOT NULL 
									 AND D.bl_status = 1
									 AND U.bl_cliente = 1 "; // U.bl_status = Cliente Ativo ou Inativo";
									 
				if ($_POST['razao_social'])
				{
					$qr_selectCliente.= " AND UPPER(J.razao_social) like UPPER('%".trim($_POST['razao_social'])."%')";
				}
				if ($_POST['nome_fantasia'])
				{
					$qr_selectCliente.= " AND UPPER(J.nome_fantasia) like UPPER('%".trim($_POST['nome_fantasia'])."%')";
				}
				if ($_POST['cnpj'])
				{
					$qr_selectCliente.= " AND UPPER(J.cnpj) like UPPER('%".trim($_POST['cnpj'])."%')";
				}
				/*
				if ($_POST['clienteCPF'])
				{
					$qr_selectCliente.= " AND J.cpf = '".trim($_POST['clienteCPF'])."'";
				}	
				
				if ($_POST['clienteRG'])
				{
					$qr_selectCliente.= " AND F.s_rg = '".trim($_POST['clienteRG'])."'";
				}	
				*/
				$qr_selectCliente.= " ORDER BY D.s_usuario";
				$dataCli= pg_query($db_connection, $qr_selectCliente);
				$numRows = pg_num_rows($dataCli);
				if ($dataCli)
				{
					?>
						<div id="clientViewerDivPai">
						<table width="100%">
						<tr>
							<td class="gridTitle">
								Clientes
							</td>
						</tr>
					<?php
					if (!$numRows)
					{
						echo "<tr><td class='gridCell'><font color='red'>Nenhum Registro Encontrado...</font></td></tr>";
					}
					
					while($arrayCli = pg_fetch_array($dataCli))
					{
						?>
						<tr onmouseover="this.style.backgroundColor= '<? echo $style['unSubItem']['bgMouseOver']; ?>';
												 showtip(this,event,'<?php echo str_replace("'", "\'", htmlentities($linhaCli['s_usuario']));?>')"
									onmouseout="this.style.backgroundColor= '<? echo $style['unSubItem']['backGround']; ?>';">
							<td class="gridCell"
								style="text-align:left;
									   cursor:pointer"
								onclick="creatBlock('<?php echo $arrayCli['s_usuario'] ;?>', 'cliente_view_data.php?pk_dados_pessoais=<?php echo $arrayCli['fk_dados_pessoais'] ?>&pk_usuario=<?php echo $arrayCli['pk_usuario'] ?>&tipo_pess=J','cliente_view_data_<?php echo $arrayCli['pk_usuario']?>');">
								<?php
									{
										echo str_replace("'", "\'", htmlentities($arrayCli['s_usuario']));
									}
								?>
							</td>
						</tr>
					<?php
					}
					?>
						</table>
						</div>
							<script>
								top.filho.document.getElementById('clientes_viewer_list_jur').innerHTML = document.getElementById('clientViewerDivPai').innerHTML; 
							</script>
					<?php
					exit;
				}
			}
		
	exit;  // Se não tiver POST
	}
?>
<div style="width:100%;
			height: 100%;
			overflow: auto">
	<table style="width: 100%;
				  height: 100%;" cellspacing="10">
		<tbody style="height: 20px;">
				<tr>
					<td id="<?php echo $PREID; ?>clienteAdd_tb_visivel"
						colspan="2">
						<?php
							$_GET['PREID']= $PREID;
							$funcGuiasPai= new guias();
							$funcGuiasPai->guiaAdd('Clientes', 'clientes_viewer.php');
							$funcGuiasPai->guiaAdd('Contatos / Filiais', 'contatos_viewer.php');
							$funcGuiasPai->setSelected(0);
							$funcGuiasPai->write();
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</table>
	<iframe id="<?php echo $PREID; ?>hiddenFrameClientViewer"
			name="<?php echo $PREID; ?>hiddenFrameClientViewer"
			style="display: none;">
	</iframe>
</div>