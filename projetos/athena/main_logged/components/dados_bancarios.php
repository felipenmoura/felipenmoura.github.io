<table>
	<tr>
		<td>
			Banco<br>
			<span>
				<?php
					$_GET['component']= 'banco';
					$_GET['componentId']= $PREID.'funcionarioBanco';
					include('../components.php');
				?>
			</span>
		</td>
		<td style="padding-left: 4px;">
			Opera&ccedil;&atilde;o<br>
			<?php
				$_GET['component']= 'operacao';
				$_GET['componentId']= $PREID.'funcionarioOperacao';
				include('../components.php');
			?>
			<!--
			<input type="text"
				   name="funcionarioOperacao"
				   class="discret_input"
				   style="width:100px;"
				   required="true">
			-->
		</td>	
		<td>
			Ag&ecirc;ncia<br>	
			<input type="text"
				   name="funcionarioAgencia"
				   class="discret_input"
				   style="width:100px;
				   required="true">
		</td>	
		<td>
			Conta Corrente<br>
			<input type="text"
				   name="funcionarioContaCorrente"
				   class="discret_input"
				   style="width:100px;
				   required="true">
		</td>	
	</tr>
</table>