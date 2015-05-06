function saveDataBlocks()
{
	top.setLoad(true, 'Salvando dados...');
	blockArrayToSave= document.getElementsByTagName('table');
	blockArrayToSaveTmp= Array();
	for(i=0; i<blockArrayToSave.length; i++)
	{
		if( blockArrayToSave[i].getAttribute('bloco')
			||
			blockArrayToSave[i].id.indexOf('table_block_') != -1
		  )
		{
			blockArrayToSaveTmp.push(blockArrayToSave[i]);
		}
	}
	delete blockArrayToSave;
	blockArrayToSave= "";
	blockArrayToSave= Array();
	blockArrayToSave= blockArrayToSaveTmp;
	delete blockArrayToSaveTmp;
	formBlocksToSave= document.createElement('FORM');
		iptBlockId= document.createElement('INPUT');
			iptBlockId.setAttribute('type', 'text');
			iptBlockId.setAttribute('id', 'iptBlockId');
			iptBlockId.setAttribute('name', 'iptBlockId');
			iptBlockId.value= "";
		iptBlockW= document.createElement('INPUT');
			iptBlockW.setAttribute('type', 'text');
			iptBlockW.setAttribute('id', 'iptBlockW');
			iptBlockW.setAttribute('name', 'iptBlockW');
			iptBlockW.value= "";
		iptBlockH= document.createElement('INPUT');
			iptBlockH.setAttribute('type', 'text');
			iptBlockH.setAttribute('id', 'iptBlockH');
			iptBlockH.setAttribute('name', 'iptBlockH');
			iptBlockH.value= "";
		iptBlockT= document.createElement('INPUT');
			iptBlockT.setAttribute('type', 'text');
			iptBlockT.setAttribute('id', 'iptBlockT');
			iptBlockT.setAttribute('name', 'iptBlockT');
			iptBlockT.value= "";
		iptBlockL= document.createElement('INPUT');
			iptBlockL.setAttribute('type', 'text');
			iptBlockL.setAttribute('id', 'iptBlockL');
			iptBlockL.setAttribute('name', 'iptBlockL');
			iptBlockL.value= "";
		iptBlockZ= document.createElement('INPUT');
			iptBlockZ.setAttribute('type', 'text');
			iptBlockZ.setAttribute('id', 'iptBlockZ');
			iptBlockZ.setAttribute('name', 'iptBlockZ');
			iptBlockZ.value= "";
		iptBlockTt= document.createElement('INPUT');
			iptBlockTt.setAttribute('type', 'text');
			iptBlockTt.setAttribute('id', 'iptBlockTt');
			iptBlockTt.setAttribute('name', 'iptBlockTt');
			iptBlockTt.value= "";
		iptBlockUrl= document.createElement('INPUT');
			iptBlockUrl.setAttribute('type', 'text');
			iptBlockUrl.setAttribute('id', 'iptBlockUrl');
			iptBlockUrl.setAttribute('name', 'iptBlockUrl');
			iptBlockUrl.value= "";
		iptBlockConf= document.createElement('INPUT');
			iptBlockConf.setAttribute('type', 'text');
			iptBlockConf.setAttribute('id', 'iptBlockConf');
			iptBlockConf.setAttribute('name', 'iptBlockConf');
			iptBlockConf.value= "";
	for(i=0; i<blockArrayToSave.length; i++)
	{
		iptBlockId.value+= blockArrayToSave[i].id+",";
		iptBlockW.value+= blockArrayToSave[i].offsetWidth+",";
		iptBlockH.value+= blockArrayToSave[i].offsetHeight+",";
		iptBlockT.value+= blockArrayToSave[i].offsetTop+",";
		iptBlockL.value+= blockArrayToSave[i].offsetLeft+",";
		iptBlockZ.value+= blockArrayToSave[i].style.zIndex+",";
		iptBlockTt.value+= blockArrayToSave[i].getAttribute('tt')+",";
		iptBlockUrl.value+= blockArrayToSave[i].getAttribute('url')+",";
		iptBlockConf.value+= blockArrayToSave[i].getAttribute('especific')+"|";
	}
	formBlocksToSave.appendChild(iptBlockId);
	formBlocksToSave.appendChild(iptBlockW);
	formBlocksToSave.appendChild(iptBlockH);
	formBlocksToSave.appendChild(iptBlockT);
	formBlocksToSave.appendChild(iptBlockL);
	formBlocksToSave.appendChild(iptBlockZ);
	formBlocksToSave.appendChild(iptBlockTt);
	formBlocksToSave.appendChild(iptBlockUrl);
	formBlocksToSave.appendChild(iptBlockConf);	
	formBlocksToSave.setAttribute('style', '');
	formBlocksToSave.style.display= 'none';
	
	formBlocksToSave.setAttribute('method', 'POST');
	formBlocksToSave.setAttribute('action', 'save_data_blocks.php');
	formBlocksToSave.setAttribute('target', 'hiddenFrame');
	
	document.getElementById('corpo').appendChild(formBlocksToSave);
	formBlocksToSave.submit();
	document.getElementById('corpo').removeChild(formBlocksToSave);		
}