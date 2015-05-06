<html>
	<script src='print_j.js'></script>
	<body>
		<input type='text' name='field'>
		<div id='container'><br/></div>
	</body>
	<script>
		// let's play with the lib, now \o/
		// an Object
		var o= {
			nome: 'Felipe',
			idade: 24,
			peso: 69.5,
			programmer: true,
			anda: function(){
				alert('andando');
			},
			o2: {
				name: 'Oxigen'
			}
		}
		// also, with recurssiveness
		o.o3= o;
		
		// a Function
		var corre= function()
		{
			alert('correndo');
		}
		// let's edit this function, changing even its prototype
		corre.status= 'A';
		corre.prototype.teste= function(){};
		
		// mixed Array
		var arr= Array(10,12,18,32);
		arr['x']= 'bla';
		
		// ordinary variables
		var nome= "Felipe";
		var idade= 25;
		var valor_hora= 22.35;
		
		// regular expression pattern
		var regEx= "/[0-9]/";
		// real Regular Expression Object
		var rE= new RegExp('[a-z]', 'ig');
		
		// a date string pattern, and a Date Object
		var strDate= '31/12/1999';
		var curDate= new Date();
		
		// let's see the outputs
		document.getElementById('container').innerHTML= print_j(o);
		document.getElementById('container').innerHTML+= print_j(corre);
		document.getElementById('container').innerHTML+= print_j(arr);
		document.getElementById('container').innerHTML+= print_j(nome);
		document.getElementById('container').innerHTML+= print_j(idade);
		document.getElementById('container').innerHTML+= print_j(valor_hora);
		document.getElementById('container').innerHTML+= print_j(regEx);
		document.getElementById('container').innerHTML+= print_j(rE);
		document.getElementById('container').innerHTML+= print_j(strDate);
		document.getElementById('container').innerHTML+= print_j(curDate);
		
		// these two last examples will write a LOT of lines ;) 
		// they show the analysis of HTML elements
			//document.getElementById('container').innerHTML+= print_j(document.getElementById('container'));
			//document.getElementById('container').innerHTML+= print_j(document.getElementsByTagName('input')[0]);
			
		/*
			// if you want, you can even show native objects structure, like Errors, for example:
			try
			{
				inexistentFunction();
			}catch(e)
			{
				document.getElementById('container').innerHTML+= print_j(e);
			}
		*/
	</script>
</html>