<style type="text/css">
	.guiaTable
	{
		width: 100%;
		height: 100%;
	}
	.guiaLeftTop
	{
		width: 4px;
		height: 21px;
	}
	
	.guiaOptionLeftFocus
	{
		height: 21px;
		cursor: default;
		width: 7px;
		background-image: url(img/left_top_blue_focus.gif);
		background-repeat: no-repeat;
	}
	.guiaOptionCenterFocus
	{
		height: 21px;
		font-size: 11px;
		font-weight: bold;
		font-family: Arial;
		text-align: center;
		cursor: default;
		padding-left: 3px;
		padding-right: 3px;
		width: 10px;
		background-image: url(img/top_blue_focus.gif);
		background-repeat: repeat-x;
	}
	.guiaOptionRightFocus
	{
		height: 21px;
		cursor: default;
		width: 7px;
		background-image: url(img/right_top_blue_focus.gif);
		background-repeat: no-repeat;
	}
	
	.guiaOptionLeft
	{
		height: 21px;
		cursor: default;
		width: 7px;
		background-image: url(img/left_top_blue_blur.gif);
		background-repeat: no-repeat;
	}
	.guiaOptionCenter
	{
		height: 21px;
		font-size: 11px;
		font-family: Arial;
		cursor: default;
		text-align: center;
		padding-left: 3px;
		padding-right: 3px;
		width: 10px;
		background-image: url(img/top_blue_blur.gif);
		background-repeat: repeat-x;
	}
	.guiaOptionRight
	{
		height: 21px;
		cursor: default;
		width: 7px;
		background-image: url(img/right_top_blue_blur.gif);
		background-repeat: no-repeat;
	}
	
	.guiaTop
	{
	}
	.guiaRightTop
	{
		width: 4px;
	}
	
	
	.guiaTopLeftBorder
	{
		width: 4px;
		height: 4px;
		overflow: hidden;
		font-size: 1px;
		border-left: solid 2px #333366;
		border-top: solid 2px #333366;
	}
	.guiaTopBorder
	{
		height: 4px;
		overflow: hidden;
		font-size: 1px;
		border-top: solid 2px #333366;
		background-image: url(img/top_load.gif);
	}
	.guiaTopRightBorder
	{
		width: 4px;
		height: 4px;
		overflow: hidden;
		font-size: 1px;
		border-right: solid 2px #333366;
		border-top: solid 2px #333366;
		background-image: url(img/top_right_load.gif);
	}
	
	.guiaLeftBorder
	{
		width: 4px;
		height: 4px;
		border-left: solid 2px #333366;
		/*background-image: url(img/top_left_load.gif);*/
	}
	.guiaRightBorder
	{
		width: 4px;
		height: 4px;
		border-right: solid 2px #333366;
		/*background-image: url(img/top_right_load.gif);*/
	}
	
	.guiaBottomLeftBorder
	{
		
		width: 4px;
		height: 4px;
		overflow: hidden;
		font-size: 1px;
		border-left: solid 2px #333366;
		border-bottom: solid 2px #333366;
		--background-image: url(img/top_left_load.gif);
	}
	.guiaBottomBorder
	{
		height: 4px;
		overflow: hidden;
		font-size: 1px;
		border-bottom: solid 2px #333366;
		background-image: url(img/top_load.gif);
	}
	.guiaBottomRightBorder
	{
		width: 4px;
		height: 4px;
		overflow: hidden;
		font-size: 1px;
		border-right: solid 2px #333366;
		border-bottom: solid 2px #333366;
		background-image: url(img/top_right_load.gif);
	}
	
	.guiaOptionLeftDisabled
	{
		cursor: default;
		width: 7px;
		background-image: url(img/left_top_blue_blur.gif);
		background-repeat: no-repeat;
	}
	.guiaOptionCenterDisabled
	{
		font-size: 11px;
		font-weight: bold;
		font-family: Arial;
		text-align: center;
		padding-left: 3px;
		padding-right: 3px;
		cursor: default;
		width: 7px;
		color: gray;
		background-image: url(img/top_blue_blur.gif);
		background-repeat: repeat-x;
	}
	.guiaOptionRightDisabled
	{
		cursor: default;
		width: 7px;
		background-image: url(img/right_top_blue_blur.gif);
		background-repeat: no-repeat;
	}
	
	.guiaConteudo
	{
		vertical-align: top;
		width: 100%;
		height: 100%;
		overflow: auto;
	}
	.tdGuiaConteudo
	{
		vertical-align: top;
	}
</style>
<script>
	var f2j_guiaNames= Array();
	function f2j_guiaChange(obj, pn)
	{
		//alert(obj.innerHTML)
		fields= obj.getElementsByTagName('TABLE');
		for(i=0; i<fields.length; i++)
		{
			TDs= fields[i].getElementsByTagName('TD');
			if(TDs[1].className != 'guiaOptionCenterDisabled')
			{
				TDs[0].className= 'guiaOptionLeft';
				TDs[1].className= 'guiaOptionCenter';
				TDs[2].className= 'guiaOptionRight';
			}
		}
		TDs= pn.getElementsByTagName('TD');
		TDs[0].className= 'guiaOptionLeftFocus';
		TDs[1].className= 'guiaOptionCenterFocus';
		TDs[2].className= 'guiaOptionRightFocus';
	}
</script>