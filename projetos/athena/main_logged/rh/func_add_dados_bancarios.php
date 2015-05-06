<table id="<?php echo $PREID; ?>tbodyDadosPessoais"
	   align="center">
	<tr>
		<td>
		   <table>
				<tr>
					<td style="padding-right:5px">
						Banco<br>
						<span>
							<?php
								$_GET['component']= 'banco';
								$_GET['componentId']= $PREID.'funcionarioBanco';
								include('../components.php');
							?>
						</span>
					</td>
					<td style="width:150px;">
						Opera&ccedil;&atilde;o
						<input type="text"
							   name="funcionarioOperacao"
							   class="discret_input"
							   style="width:100px;"
							   required="true">
					</td>	
					<td style="width:150px;">
						Ag&ecirc;ncia<br>	
						<input type="text"
							   name="funcionarioAgencia"
							   class="discret_input"
							   style="width:100px;
							   required="true">
					</td>	
					<td style="width:150px;">
						Conta Corrente
						<input type="text"
							   name="funcionarioContaCorrente"
							   class="discret_input"
							   style="width:100px;
							   required="true">
					</td>	
				</tr>
			</table>
		</td>
	</tr>
</table>