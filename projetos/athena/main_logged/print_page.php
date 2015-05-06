<?
	//session_start();
	require_once("inc/valida_sessao.php");
?>
<body id="body"
	  onload="tryPrint();"
	  style="font-family: Arial;">
	<table width="100%"
		   height="100%">
		<tr>
			<td style="text-align: center;">
				<br>
				<h1>
					<script>
						contentToPrint= opener.blockInFocus.innerHTML.replace(/auto/g, 'visible')+"<br>";
						document.write(opener.titleToPrint+"<br>");
					</script>
				</h1>
				<br>
				<br>
				<img src="img/logo.gif">
				<br>
				<?
					echo "<h3>
							".$_SESSION['s_usuario']."
						  </h3>
						  <h2>
							<br>
							". strtoupper($_SESSION['']) ."
						  </h2>";
					echo "<h2>".date('d/m/y')."</h2><br><br><br><br><br>";
					echo "<h4></h4>";
				?>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td>
				<script>
					document.writeln(contentToPrint);
				</script>
			</td>
		</tr>
	</table>
</body>
<script>
	function tryPrint()
	{
		window.print();
		window.close();
		opener.setLoad(false);
		opener.document.getElementById('abertura_back_div').style.display= 'none';
	}
</script>