
function updatecalendar(obj, id)
{
	var themonth= obj.value//parseInt(theselection[theselection.selectedIndex].value)+1
	var calendarstr=buildCal(id, themonth, curyear, "main", "month", "daysofweek", "days", 0)
	if(!id)
		document.getElementById("calendario_padrao").innerHTML=calendarstr;
	else
		document.getElementById(id).innerHTML=calendarstr;
}

function updatecalendarYear(obj, id)
{
	var calendarstr=buildCal(id, curmonth, obj.value, "main", "month", "daysofweek", "days", 0)
	if(!id)
		document.getElementById("calendario_padrao").innerHTML=calendarstr;
	else
		document.getElementById(id).innerHTML=calendarstr;
}

function buildCal(id, m, y, cM, cH, cDW, cD, brdr)
{
	var mn=['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
	var dim=[31,0,31,30,31,30,31,31,30,31,30,31];

	var oD = new Date(y, m-1, 1); //DD replaced line to fix date bug when current day is 31st
	oD.od=oD.getDay()+1; //DD replaced line to fix date bug when current day is 31st

	var todaydate=new Date() //DD added
	var scanfortoday=(y==todaydate.getFullYear() && m==todaydate.getMonth()+1)? todaydate.getDate() : 0 //DD added
	dim[1]=(((oD.getFullYear()%100!=0)&&(oD.getFullYear()%4==0))||(oD.getFullYear()%400==0))?29:28;
	var t='<div class="'+cM+'"><table width="170" class="'+cM+'" cols="7" cellpadding="0" border="'+brdr+'" cellspacing="0"><tr align="center">';
	t+='<td colspan="7" align="center" class="'+cH+'" style="white-space: nowrap;">';
	//	selectlist of months
	t+="<select calendar_object='"+id+"' onchange=\"updatecalendar(this, '"+id+"')\" style='width: 120px;'>";
	for (i=0; i<12; i++) //display option for 12 months of the year
	{
		t+='<option value="'+i+'"';
		if(m-1 == i)
			t+= ' selected="yes" ';
		t+='>'+themonths[i]+'</option>';
	}
	t+='</select>';

	//	selectlist of years
	t+="<select calendar_object='"+id+"' onchange=\"updatecalendarYear(this, '"+id+"')\" style='width: 100px;'>";

	for (i=5; i>=0; i--)
	{
		t+='<option value="'+(curyear-i)+'"';
			if(y==curyear-i)
				t+= ' selected="yes" ';
		t+='>'+(curyear-i)+'</option>';
	}
	for (i=0; i<5; i++)
	{
		t+='<option value="'+(curyear+i)+'"';
		if(y==curyear+i)
				t+= ' selected="yes" ';
		t+='>'+(curyear+i)+'</option>';
	}
	t+='</select>';


	t+='</td></tr><tr align="center">';
	for(s=0;s<7;s++)
		t+='<td class="'+cDW+'">'+"DSTQQSS".substr(s,1)+'</td>';
	t+='</tr><tr align="center">';
	for(i=1;i<=42;i++){
	var x=((i-oD.od>=0)&&(i-oD.od<dim[m-1]))? i-oD.od+1 : '&nbsp;';
	if (x==scanfortoday) //DD added
	x='<span id="today">'+x+'</span>' //DD added
	t+='<td class="'+cD+'">'+x+'</td>';
	if(((i)%7==0)&&(i<36))t+='</tr><tr align="center">';
	}
	return t+='</tr></table></div>';
}