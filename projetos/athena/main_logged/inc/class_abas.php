<?php
	class guia
	{
		var $label= '';
		var $url= '';
	}
	
	class guias
	{
		var $bloco;
		var $guias		= Array();
		var $selected	= 0;
		var $errorMsg	= '<b>Erro ao tentar carregar as informa&ccedil;&otilde;es desta guia !</b>';
		var $linhaAtual	= -1;
		var $linha		= Array();
		var $disabled	= Array();
		
		function guiaAddLinha()
		{
			$this->linhaAtual++;
			$this->linha[$this->linhaAtual]= Array();
		}
		function __construct()
		{
			$this->guiaAddLinha();
		}
		function guiaAdd($label, $url)
		{
			$c= array_push($this->guias, new guia);
			$c--;
			$this->guias[$c]->label= $label;
			$this->guias[$c]->url= $url;
			array_push($this->linha[$this->linhaAtual], $this->guias[$c]);
		}
		function setSelected($s)
		{
			$this->selected= $s;
		}
		function setErrorMsg($msg)
		{
			$this->errorMsg= $msg;
		}
		function disable($idx)
		{
			array_push($this->disabled, $idx);
		}
		
		function write()
		{
			?>
				<table class="guiaTable"
					   cellpadding="0px"
					   cellspacing="0">
					<tr>
						<td class="guiaLeftTop">
							&nbsp;<br>
						</td>
						<td style="text-align: left;">
								<?
									$tmpId= rand(0, 999).date('Ymdhis').microtime();
								?>
								<span id="f2j_guia_labels_<?php echo $tmpId;?>">
								<?php
									$i=0;
									for($counter=0; $counter<count($this->linha); $counter++)
									{
										?><table cellpadding="0"
												 cellspacing="0">
											<tr>
												<?php
												for($ii=0; $ii<count($this->linha[$counter]); $ii++)
												{
													if(in_array($i, $this->disabled))
													{
														$cssClass= 'Disabled';
													}else{
															if($i == $this->selected)
																$cssClass= 'Focus';
															else
																$cssClass= '';
														 }
													?>
													<td style="vertical-align: bottom;">
														<table cellpadding="0"
															   cellspacing="0">
															<tr>
																<td class="guiaOptionLeft<?php echo $cssClass; ?>"
																	id="f2j_guia_label_left<?php echo $this->guias[$i]->url; ?>">
																	&nbsp;<br>
																</td>
																<td class="guiaOptionCenter<?php echo $cssClass; ?>"
																	id="f2j_guia_label_center<?php echo $this->guias[$i]->url; ?>"
																	onclick="if(this.className== 'guiaOptionCenterDisabled') return false;
																			f2j_guiaChange(document.getElementById('f2j_guia_labels_<?php echo $tmpId;?>'), this.parentNode);
																			<?php
																				for($j=0; $j<count($this->guias); $j++)
																				{
																					echo "document.getElementById('f2j_guia_".$this->guias[$j]->url."').style.display= 'none'; ";
																				}
																				echo "document.getElementById('f2j_guia_".$this->linha[$counter][$ii]->url."').style.display= ''; ";
																			 ?>
																			">
																	<nobr>
																		<?php
																			echo $this->linha[$counter][$ii]->label;
																		?>
																	</nobr>
																</td>
																<td class="guiaOptionRight<?php echo $cssClass; ?>"
																	id="f2j_guia_label_right<?php echo $this->linha[$counter][$i]->url; ?>">
																	&nbsp;&nbsp;<br>
																</td>
															</tr>
														</table>
													</td>
													<?php
													$i++;
												}
										echo "</tr>
										</table>";
									}
								?>
							</span>
						</td>
						<td class="guiaTop">
							<nobr>&nbsp;</nobr>
						</td>
						<td class="guiaRightTop">
								
						</td>
					</tr>
					<tr>
						<td class="guiaTopLeftBorder">
							&nbsp;
						</td>
						<td colspan="<?php echo (count($this->guias)*3)+3; ?>"
							class="guiaTopBorder">
							&nbsp;
						</td>
						<td class="guiaTopRightBorder">
							&nbsp;
						</td>
					</tr>
					<tr>
						<td class="guiaLeftBorder">
							&nbsp;<br>
						</td>
						<td colspan="<?php echo (count($this->guias)*3)+3; ?>"
							style="height: 100%;"
							class="guiaConteudo">
							<table style="width: 100%;
										  height: 100%;">
								<?php
									$ii=0;
									for($counter=0; $counter<count($this->linha); $counter++)
									{
										for($i=0; $i<count($this->linha[$counter]); $i++)
										{
											if($ii == $this->selected || $this->selected >= count($this->guias) || $this->selected<0)
												$display= '';
											else
												$display= 'none';
											?>
												<tr style="display: <?php echo $display; ?>"
													id="f2j_guia_<?php echo $this->linha[$counter][$i]->url; ?>">
													<td class="tdGuiaConteudo">
														<?php
															if($this->selected >= count($this->guias) || $this->selected<0)
																echo $this->errorMsg;
															else
																if(trim($this->linha[$counter][$i]->url) != '')
																{
																	if(strpos($this->linha[$counter][$i]->url,'?'))
																	{
																		if((!@include(substr($this->linha[$counter][$i]->url,0,strrpos($this->linha[$counter][$i]->url,'?')))) || $this->selected >= count($this->guias) || $this->selected<0)
																		echo $this->errorMsg;	
																	}else{
																		if((!@include($this->linha[$counter][$i]->url)) || $this->selected >= count($this->guias) || $this->selected<0)
																			echo $this->errorMsg;
																	}
																}
																//try{
																	//if((!@include($this->linha[$counter][$i]->url)) || $this->selected >= count($this->guias) || $this->selected<0)
																		//echo $this->errorMsg;
																//}catch(Exception $e){}
																//try{
																	
																//}catch(Exception $e){}
														?>
													</td>
												</tr>
											<?php
											if($this->selected >= count($this->guias) || $this->selected<0)
											{
												//break;
											}
											$ii++;
										}
									}
								?>
							</table>
						<td class="guiaRightBorder">
							&nbsp;&nbsp;<br>
						</td>
					</tr>
					<tr>
						<td class="guiaBottomLeftBorder">
							&nbsp;
						</td>
						<td colspan="<?php echo (count($this->guias)*3)+3; ?>"
							class="guiaBottomBorder">
							&nbsp;
						</td>
						<td class="guiaBottomRightBorder">
							&nbsp;
						</td>
					</tr>
				</table>
			<?php
			echo "<script>
					f2j_guiaNames['f2j_guia_labels_".$tmpId."']= document.getElementById('f2j_guia_labels_".$tmpId."');
				  </script>";
		}
	}
?>