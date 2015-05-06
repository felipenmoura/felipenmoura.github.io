<?php
	class menu
	{
		var $menu;
		var $label;
		var $help;
		var $url;
		var $permission;
		var $title;
		var $attributes;
		var $size;
		var $position;
		var $structure;
		var $subMenu= Array();
		var $objectId;
		var $eventListener= Array();
		//var $subMenuEventListener= Array();
		# inicia a criação de um novo menu
		function makeMenu($label, $title, $url, $permission, $help)
		{
			$this->label= $label;
			$this->title= $title;
			$this->help= $help;
			$this->url= $url;
			$this->permission= $permission;
		}
		# seta atributos;
		# 'unique', 'id' -> enviar a id para setar como unico este menu
		# 'translucent', ''-> seta como transparente
		# noresize, '' -> seta que nao pode ter o tamanho alterado
		# nomaximize, '' -> seta que nao pode ser maximizado
		# nominimize, '' -> seta que nao pode ser minimizado
		function setAttribute($atributo, $valor)
		{
			if($atributo == 'unique')
			{
				$this->unique= $valor;
				return true;
			}
			$this->attributes.= $atributo.", ";
		}
		# seta o tamanho do bloco a ser criado 'W/H'
		function setSize($size)
		{
			$this->size= $size;
		}
		# seta a posição do bloco a ser criado 'L/T'
		function setPosition($pos)
		{
			$this->position= $pos;
		}
		# seta o menu, como parent de um submenu
		function makeParentMenu($label)
		{
			$this->label	= "<nobr>".$label."</nobr>";
			$this->objectId = htmlentities(str_replace(' ', '_', $label)).'_'.rand(0,999);
			$this->structure= 'parent';
		}
		# instancia um novo sub menu
		function makeSubMenu($label, $title, $url, $permission, $help)
		{
			$this->subMenu[count($this->subMenu)]= Array();
			$this->subMenu[count($this->subMenu)-1]['label']		= $label;
			$this->subMenu[count($this->subMenu)-1]['title']		= $title;
			$this->subMenu[count($this->subMenu)-1]['url']		= $url;
			$this->subMenu[count($this->subMenu)-1]['permission'] = $permission;
			$this->subMenu[count($this->subMenu)-1]['help']		= $help;
			return $this->subMenu[count($this->subMenu)];
		}
		# seta atributos para o ultimo submenu instanciado
		function setSubMenuAttribute($atributo, $valor)
		{
			if($atributo == 'unique')
			{
				$this->subMenu[count($this->subMenu)-1]['unique']= $valor;
				return true;
			}
			$this->subMenu[count($this->subMenu)-1]['attributes'].= $atributo.", ";
		}
		# seta o tamanho do bloco a ser criado 'W/H' a partir de um submenu
		function setSubMenuSize($size)
		{
			$this->subMenu[count($this->subMenu)-1]['size']= $size;
		}
		# seta a posição do bloco a ser criado 'L/T' a partir de um submenu
		function setSubMenuPosition($pos)
		{
			$this->subMenu[count($this->subMenu)-1]['position']= $pos;
		}
		function setEvent($evento, $acao)
		{
			$this->eventListener[$evento].= $acao. " ";
		}
		function setSubMenuEvent($evento, $acao)
		{
			$this->subMenu[count($this->subMenu)-1][$evento].= $acao;
			//$this->subMenuEventListener[$evento].= $acao. " ";
		}
		# reseta para o padrao as variáveis
		function clearAttributes()
		{
			$this->label		= '';
			$this->unique		= '';
			$this->help			= '';
			$this->url			= '';
			$this->permission	= '';
			$this->title		= '';
			$this->attributes	= '';
			$this->size			= '';
			$this->position		= '';
			$this->structure	= '';
			$this->objectId		= null;
			$this->eventListener= null;
			$this->subMenu		= null;
			$this->subMenuEventListener= null;
			$this->eventListener= Array();
			$this->subMenu		= Array();
			//$this->subMenuEventListener= Array();
		}
		# escreve o menu
		function write()
		{
			if(trim($this->permission)!= '')
			{
				$validSession= false;
				for($i=0; $i<=count($_SESSION['acesso_web']); $i++)
				{
					if($_SESSION['acesso_web'][$i] == $this->permission)
					{
						$validSession= true;
					}
				}
				if($validSession== false)
				{
					$this->clearAttributes();
					return false;
				}
			}
			if($this->structure == 'parent')
			{
				?>
					<tr>
						<td style="background-image: url('img/back_menu.gif');
								   padding-left:3px;
								   padding-right:4px;"
							onmouseover="this.style.backgroundColor= '#777777';
										 document.getElementById('<? echo $this->objectId; ?>').style.display= '';
										 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
							onmouseout="this.style.backgroundColor= '';
										document.getElementById('<? echo $this->objectId; ?>').style.display= 'none';
										this.style.backgroundImage= 'url(img/back_menu.gif)';">
							<?
								echo "<div style='float: left; width: 90%;'>"
										.$this->label.
									 "</div><div style='float: left; text-align: right;'>
										»
									  </div>";
							?>
							<table id="<? echo $this->objectId; ?>"
								   style="display: none;
										  position: absolute;
										  border: solid 1px #000000;
										  left: 98%;
										  background-image: url('img/back_menu.gif');"
								   class="subMenu"
								   cellpadding="0"
								   cellspacing="0">
							<?
								for($i=0; $i< count($this->subMenu); $i++)
								{
							?>
									<tr>
										<td onmouseover="showtip(this, event, '<? echo $this->subMenu[$i]['help']; ?>');
														 this.style.backgroundColor= '#777777';
														 this.style.backgroundImage= 'url(img/back_menu_over.gif)';
														 <? echo $this->subMenu[$i]['onmouseover']; ?>"
											onmouseout="this.style.backgroundColor= '';
														this.style.backgroundImage= 'url(img/back_menu.gif)';
														<? echo $this->subMenu[$i]['onmouseout']; ?>"
											onclick="document.getElementById('<? echo $this->objectId; ?>').style.display= 'none';
													 c.creatBlock('<? echo $this->subMenu[$i]['title']; ?>', '<? echo $this->subMenu[$i]['url']; ?>', '<? echo trim($this->subMenu[$i]['unique']); ?>', '<? echo $this->subMenu[$i]['attributes'] ?>', '<? echo $this->subMenu[$i]['position']; ?>', '<? echo $this->subMenu[$i]['size']; ?>'); menuUnset();
													 <? echo $this->subMenu[$i]['onclick']; ?>"
											style="white-space: nowrap;"
											onmousedown="<? echo $this->subMenu[$i]['onmousedown']; ?>"
											onmouseup="<? echo $this->subMenu[$i]['onmouseup']; ?>">
											<?
												//echo "c.creatBlock('".$this->subMenu[$i]['title']."', '".$this->subMenu[$i]['url']."', '".trim($this->subMenu[$i]['unique'])."', '".$this->subMenu[$i]['attributes']."'); menuUnset();";
												echo $this->subMenu[$i]['label'];//."XXX".trim($this->subMenu[$i]['unique']);
											?>
										</td>
									</tr>
							<?
								}
							?>
							</table>
						</td>
					</tr>
				<?
			}else{
					?>
						<tr>
							<td style="background-image: url('img/back_menu.gif');"
								onmouseover="this.style.backgroundColor= '#777777';
											 showtip(this, event, '<? echo $this->help; ?>');
											 this.style.backgroundImage= 'url(img/back_menu_over.gif)';
											 <? echo $this->eventListener['onmouseover']; ?>"
								onmouseout="this.style.backgroundColor= '';
											this.style.backgroundImage= 'url(img/back_menu.gif)';
											<? echo $this->eventListener['onmouseout']; ?>"
								onclick="c.creatBlock('<? echo $this->title; ?>', '<? echo $this->url; ?>', '<? echo $this->unique; ?>', '<? echo $this->attributes; ?>', '<? echo $this->position; ?>', '<? echo $this->size; ?>'); menuUnset(); 
										 <? echo $this->eventListener['onclick']; ?>"
								onmousedown="<? echo $this->eventListener['onmousedown']; ?>"
								onmouseup="<? echo $this->eventListener['onmouseup']; ?>">
								<nobr>
									<?
										echo $this->label;
									?>
								</nobr>
							</td>
						</tr>
					<?
				 }
			$this->clearAttributes();
		}
	}
?>