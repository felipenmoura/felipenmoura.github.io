<img src='images/jsvalida-1.png' style='position:absolute; left:70px; top:70px; display:none;' width='220' class='add' id='img1' />
<img src='images/jsvalida-2.png' style='position:absolute; left:130px; top:190px; display:none;' width='250' class='add' id='img2' />
<img src='images/jsvalida-3.png' style='position:absolute; left:240px; top:300px; display:none;' width='340' class='add' id='img3' />
<img src='images/jsvalida-4.png' style='position:absolute; left:500px; top:210px; display:none;' width='220' class='add' id='img4' />
<img src='images/jsvalida-5.png' style='position:absolute; left:380px; top:75px; display:none;' width='220' class='add' id='img5' />
<img src='images/js-first-person.png' style='position:absolute; left:220px; top:150px; display:none;' width='250' class='add' id='img6' />
<script>
	//Slides.setBackgroundImage('images/nuvem5.jpg');
	setTimeout(function(){
		$('#img1').css('display', '');
		setTimeout(function(){
			$('#img2').css('display', '');
		}, 100);
	
		setTimeout(function(){
			$('#img3').css('display', '');
		}, 200);
	
		setTimeout(function(){
			$('#img4').css('display', '');
		}, 300);
	
		setTimeout(function(){
			$('#img5').css('display', '');
		}, 400);
	
		setTimeout(function(){
			$('#img6').css('display', '');
		}, 500);
	}, 5000);
</script>
