<?php
	class Mind
	{
		private $requisition= false;
		private $outPut= '';
		public  $type= 'link';
		
		public function close()
		{
			echo json_encode($this->outPut);
			//exit;
		}
		
		public function __construct($requisition)
		{
			$this->requisition= json_decode(stripslashes($requisition));
			$this->type= $this->requisition->type;
			if($this->requisition->type == 'link')
			{
				$urls= $this->requisition->post->url;
				
				$return= Array();
				
				reset($urls);
				while($url= current($urls))
				{
					ob_start();
					include($url.'.php');
					$saida = ob_get_contents();
					$return[key($urls)]= $saida;//$url.' ('.$this->requisition->post->mindcode.')';
					ob_end_clean();
					next($urls);
				}
				reset($urls);
				$this->outPut= $return;
			}
		}
	}
?>