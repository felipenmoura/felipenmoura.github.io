<?php
	include('classes/mind.php');
	$mind= new Mind($_POST['requisition']);
	
	if($mind->type == 'link')
	{
		
		$mind->close();
	}
	//$mind->close();
?>