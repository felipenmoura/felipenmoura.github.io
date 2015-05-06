<?php
	$PREID= 'func_add_';
	$_GET['$PREID'] = $PREID;
?>
<table width="100%">
	<tr>
		<td colspan="2">
			<?php
				include('../components/enderecos.php')
			?>
		</td>
	</tr>
	<tr>
		<td style="vertical-align: top;">
			<?php
				include('../components/emails.php')
			?>
		</td>
		<td style="vertical-align: top;">
			<?php
				include('../components/telefones.php')
			?>
		</td>
		<!--
		<td style="vertical-align: top;">
			<?php
				include('../components/contatos.php')
			?>
		</td>
		-->
	</tr>
</table>
