<?php
session_start();

require_once("inc/valida_sessao.php");
?>
<div class="conteudo"
	 style="text-align: center;
			width: 100%;
			height: 100%;
			overflow: auto;">
  <center>
		<table border="0"
			   width='100%'
			   cellpadding="0"
			   cellspacing="0"
			   bgcolor="#f0f0f0"
			   class="tabela_lista">
	      <tr bgcolor="#333366">
	        <td align="left" class="gridTitle"><b>Arquivo</b></td>
	        <td width="78" class="gridTitle" align="left"><b>Data</b></td>
	      </tr>
		<?php 
			$dir = "../forms/arquivos/circulares";
		    if ($handle = opendir($dir))
			{
		       $x=0;
			   if($x%2==0)
			   {
					$cor = "#ffffff";
			   }
			   else
			   {
					$cor = "#dedede";
			   }
		       while (false!==($file=readdir($handle)))
			   {
		          if ($file!="." && $file!="..")
				  {
		              $matrix[$x]=$file;
		              $x++;
		          }
		       }
		       closedir($handle);
		    }
		   $x=0;
	   array_multisort($matrix,SORT_ASC);
	   while($matrix[$x])
	   {  //imprime links com nomes dos arquivos
	      $arquivo = $dir . '/' . $matrix[$x];
		  if (file_exists($arquivo))
		  {
	         if($x%2==0)
			 {
	            $cor = "#ffffff";
	         } //if
	         else{
					$cor = "#dedede";
				 } //else
		     ?>
	         <tr onmouseover="this.style.backgroundColor= '#aaaaaa';"
				 onmouseout="this.style.backgroundColor= '<? echo $cor; ?>';"
				 bgcolor="<? echo $cor; ?>">
	            <td align="left"
					style="padding-left: 8px;">
					<a href="../forms/arquivos/_CIRCULARES/<?php echo $matrix[$x];?>"
					   target="_quot">
						<?php echo $matrix[$x];?>
					</a>
				</td>
	            <td align="center">
					<?php echo date("d/m/Y", filemtime("../forms/arquivos/circulares/".$matrix[$x])); ?>
				</td>
	         </tr>
	         <?php $x++;
		  }
		}?>
	    </table>
  </center>
</div>
<flp_script>


