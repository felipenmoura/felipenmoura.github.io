<?
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
			$this->label	= $label;
			$this->objectId = htmlentities(str_replace(' ', '_', $label)).'_'.rand(0,999);
			$this->structure= 'parent';
		}
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
		# resta para o padrao as variáveis
		function clearAttributes()
		{
			$this->label		= '';
			$this->help			= '';
			$this->url			= '';
			$this->permission	= '';
			$this->title		= '';
			$this->attributes	= '';
			$this->size			= '';
			$this->position		= '';
			$this->structure	= '';
			$this->objectId		= null;
		}
		# escreve o menu
		function write()
		{
			if($this->structure == 'parent')
			{
				?>
					<tr>
						<td style=""
							onmouseover="this.style.backgroundColor= '#777777';
										 document.getElementById('<? echo $this->objectId; ?>').style.display= ''"
							onmouseout="this.style.backgroundColor= '';
										document.getElementById('<? echo $this->objectId; ?>').style.display= 'none'">
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
										  left: 98%;"
								   class="subMenu"
								   cellpadding="0"
								   cellspacing="0">
							<?
								for($i=0; $i< count($this->subMenu); $i++)
								{
							?>
									<tr>
										<td onmouseover="showtip(this, event, '<? echo $this->subMenu[$i]['help']; ?>');
														 this.style.backgroundColor= '#777777';"
											onmouseout="this.style.backgroundColor= '';"
											onclick="document.getElementById('<? echo $this->objectId; ?>').style.display= 'none';
													 c.creatBlock('<? echo $this->subMenu[$i]['title']; ?>', '<? echo $this->subMenu[$i]['url']; ?>'); menuUnset();"
											style="white-space: nowrap;">
											<?
												echo $this->subMenu[$i]['label'];
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
							<td style=""
								onmouseover="this.style.backgroundColor= '#777777';
											 showtip(this, event, '<? echo $this->help; ?>')"
								onmouseout="this.style.backgroundColor= '';"
								onclick="c.creatBlock('<? echo $this->title; ?>', '<? echo $this->url; ?>', '<? echo $this->unique; ?>', '<? echo $this->attributes; ?>', '<? echo $this->position; ?>', '<? echo $this->size; ?>'); menuUnset()">
								<?
									echo $this->label;
								?>
							</td>
						</tr>
					<?
				 }
			$this->clearAttributes();
		}
	}
?>