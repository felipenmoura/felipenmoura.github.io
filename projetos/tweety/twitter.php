<?php
	$content = @simplexml_load_file("http://search.twitter.com/search.atom?q=from:".$_GET['usr']."&amp;rpp=1");
	if($content)
	{
		$tt= rand(0, sizeof($content->entry));
		if($tt>6)
			$tt= 4;
		$str= utf8_decode(htmlentities($content->entry[$tt]->content, ENT_QUOTES, 'UTF-8'));
		$str= preg_replace('/\&amp\;/', '&', $str);
		$str= preg_replace('/\&gt\;/', '>', $str);
		$str= preg_replace("/\'/", '"', $str);
		$str= preg_replace('/\&quot;/', '"', $str);
		$str= preg_replace('/\&lt\;a/ ', "<a target=_blank ", $str);
		$str= preg_replace('/\&lt\;\/a/', '</a', $str);
//		$str= preg_replace("'", '\'', $str);
//		echo "alert('aaaa');";
		echo "document.getElementById('tweetContent').innerHTML= '".$str."';";
	}else{
			echo "document.getElementById('tweetContent').innerHTML= 'Error: Twitter is not accessible!';";
		 }
?>
