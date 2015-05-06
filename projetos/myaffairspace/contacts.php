<div class='contactsList'>
	<h2>
		Contacts
	</h2>
	<table align='center'
		   cellpadding='0'
		   cellspacing='0'
		   style='width: 100%;'>
		<tr class='contactsListLine'>
			<td class='contactItem'
				gender='male'
				orientation='straight'
				age='20'
				onmouseover='this.className= "contactItemOver";
							 showballoon(event, this, 1);'
				onmouseout='this.className= "contactItem";
							hiddeballoon();'>
				<img src='img/no_photo_male.jpg'><br>
				User's Name
			</td>
			<td class='contactItem'
				gender='female'
				orientation='straight'
				age='23'
				onmouseover='this.className= "contactItemOver";
							 showballoon(event, this, 2);'
				onmouseout='this.className= "contactItem";
							hiddeballoon();'>
				<img src='img/no_photo_male.jpg'><br>
				User's Name
			</td>
			<td class='contactItem'
				gender='male'
				orientation='homosexual'
				age='29'
				onmouseover='this.className= "contactItemOver";
							 showballoon(event, this, 3);'
				onmouseout='this.className= "contactItem";
							hiddeballoon();'>
				<img src='img/no_photo_male.jpg'><br>
				User's Name
			</td>
		</tr>
		<tr class='contactsListLine'>
			<td class='contactItem'
				 gender='couple'
				 orientation='bisexual'
				 age='27/32'
				 onmouseover='this.className= "contactItemOver";
							  showballoon(event, this, 1, 2);'
				 onmouseout='this.className= "contactItem";
							 hiddeballoon();'>
				<img src='img/no_photo_couple.jpg'><br>
				User's Name
			</td>
			<td class='contactItem'
				gender='female'
				 orientation='straight'
				 age='42'
				 onmouseover='this.className= "contactItemOver";
							  showballoon(event, this, 2, 2);'
				 onmouseout='this.className= "contactItem";
							 hiddeballoon();'>
				<img src='img/no_photo_female_2.jpg'><br>
				User's Name
			</td>
			<td class='contactItem'
				gender='male'
				 orientation='straight'
				 age='36'
				 onmouseover='this.className= "contactItemOver";
							  showballoon(event, this, 3, 2);'
				 onmouseout='this.className= "contactItem";
							 hiddeballoon();'>
				<img src='img/no_photo_male.jpg'><br>
				User's Name
			</td>
		</tr>
		<tr class='contactsListLine'>
			<td class='contactItem'
				 gender='female'
				 orientation='bisexual'
				 age='22'
				 onmouseover='this.className= "contactItemOver";
							  showballoon(event, this, 1, 3);'
				 onmouseout='this.className= "contactItem";
							 hiddeballoon();'>
				<img src='img/no_photo_female_2.jpg'><br>
				User's Name
			</td>
			<td class='contactItem'
				gender='male'
				 orientation='straight'
				 age='25'
				 onmouseover='this.className= "contactItemOver";
							  showballoon(event, this, 2, 3);'
				 onmouseout='this.className= "contactItem";
							 hiddeballoon();'>
				<img src='img/no_photo_male.jpg'><br>
				User's Name
			</td>
			<td class='contactItem'
				gender='couple'
				 orientation='straight'
				 age='22/25'
				 onmouseover='this.className= "contactItemOver";
							  showballoon(event, this, 3, 3);'
				 onmouseout='this.className= "contactItem";
							 hiddeballoon();'>
				<img src='img/no_photo_couple.jpg'><br>
				User's Name
			</td>
		</tr>
	</table>
	<div class='listShowAllLink'>
		<a href='#' rel='dinamicAnchor'>
			Show All</a>
	</div>
</div>
<div class='balloonDiv'
	 id='balloon'
	 style='display: none;'>
	<table cellpadding='0'
		   cellspacing='0'>
		<tr>
			<td class='balloonItem'>
				<span id='balloonGenderData'>Female</span> (<span id='balloonOrientationData'>Straight</span>)
			</td>
		</tr>
		<tr>
			<td class='balloonItem'>
				Age: <span id='balloonAgeData'>20</span>
			</td>
		</tr>
		<tr>
			<td class='balloonItem'
				onmouseover="if(!isIe) this.className='balloonItemOver' /* ie sucks */"
				onmouseout="this.className='balloonItem'"
				onmousedown='hiddeballoon()';
				style='cursor: pointer;
					   font-weight: bold;'>
				Profile
			</td>
		</tr>
		<tr>
			<td class='balloonItem'
				onmouseover="if(!isIe) this.className='balloonItemOver'"
				onmouseout="this.className='balloonItem'"
				onmousedown='hiddeballoon()';
				style='cursor: pointer;'>
				Photos
			</td>
		</tr>
		<tr>
			<td class='balloonItem'
				sonclick="alert(1);"
				sonmousedown="alert(2);"
				sonmouseover="alert(3);"
				sonmousemove="alert(4);"
				sonmouseout="alert(5);"
				onmouseover="if(!isIe) this.className='balloonItemOver'"
				onmouseout="this.className='balloonItem'"
				onmousedown='hiddeballoon();';
				style='cursor: pointer;'>
				Historic
			</td>
		</tr>
		<tr>
			<td class='balloonItem'
				style='padding-bottom: 2px;
					   border-bottom: solid 2px #000;
					   cursor: pointer;'
				onmouseover="if(!isIe) this.className='balloonItemOver'"
				onmouseout="this.className='balloonItem'"
				onmousedown='hiddeballoon()';>
				Report abuse
			</td>
		</tr>
		<!--<tr>
			<td style='text-align: right;
					   padding-right: 50px;'>
				<img src='img/baloon.gif'
					 style='position: relative;
							top: -2px;
							border: none;'>
			</td>
		</tr>-->
	</table>
</div>
<img src='img/baloon.gif'
	 style='position: absolute;
			top: 0px;
			left: 0px;
			z-index: 8;
			display: none;
			border: none;'
	 id='balloonArrow'>
			
			
			
			
			
			