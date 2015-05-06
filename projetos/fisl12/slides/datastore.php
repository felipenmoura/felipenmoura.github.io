<div style='padding-top:60px;'>
	<div id='table'>
		<div>
			<table class='grid add' style='width:700px;' align='center'>
				<tr>
					<td>
						#Id
					</td>
					<td>
						Nome
					</td>
					<td>
						<br/>
					</td>
				</tr>
				<tbody id='grid'>
				</tbody>
			</table>
		</div>
		<center>
			<input type='text' id='usuarioNome' />
			<input type='button' value='Adicionar Usuário' onclick="addThis();">
			<div id='db-log'>
				<br/>
			</div>
		</center>
	</div>
	<div style='display:none;padding:4px;' id='code'>
		<pre>
    db = <b>openDatabase</b>("DBFelipe", "1.0", "HTML5 dataBase", 20000);

    db.<b>transaction</b>(function(t)
              {
                 t.<b>executeSql</b>(<s>
                              "DELETE FROM usuarios WHERE id=?"</s>,
                              [id],
                              function(t, result){
                                 showLines();
                              },
                              onError);
              });
        </pre>
	</div>
	<div style='display:none;padding:4px;' id='code2'>
		<pre>
    db.<b>transaction</b>(function(t){
    t.<b>executeSql</b>(<s>"SELECT * FROM usuarios"</s>,
            [],
            function(t, result){
              <b>for</b> (<i>var</i> i = <s>0</s>, item = <s>null</s>; i &lt; <b>result.rows.length</b>; i<s>++</s>)
              {
                item = <b>result.rows.item(<s>i</s>)</b>;
                alert(item[<s>'id'</s>]);
              }
            });
    });
		</pre>
		<div style='display:none;padding:4px;' id='code3'>
			<pre>
    <b>window</b>.localStorage[<s>'nome'</s>] = form.nome.value;
    <b>window</b>.localStorage[<s>'idade'</s>] = form.idade.value;
    
    alert(<b>window</b>.localStorage[<s>'nome'</s>]);
			</pre>
		</div>
	</div>
</div>
<script>
	if(!db)
	{
		var db = openDatabase("DBFelipe", "1.0", "HTML5 dataBase", 500000);
	}
	var log = document.getElementById('db-log');
	
	function onError(t, error) {
		//log.innerHTML += '<p>' + error.message + '</p>';
	}
	
	function showRecords() {
		document.getElementById('grid').innerHTML = '';
		db.transaction(function(t){
			var tr;
			var td;
			t.executeSql("SELECT * FROM usuarios",
						  [],
						  function(t, result){
								for (var i = 0, item = null; i < result.rows.length; i++){
									item = result.rows.item(i);
									//$('#grid').html($('#grid').html() +"<tr><td>"item['id']   +'</td><td>'+item['nome'] + '</td><td><a href="#" onclick="deleteRecord('+item['id']+')">[Delete]</a></td></tr>');
									tr= document.createElement('TR');
									td= document.createElement('TD');
									td.innerHTML= item['id'];
									tr.appendChild(td);
									td= document.createElement('TD');
									td.innerHTML= item['nome'];
									tr.appendChild(td);
									td= document.createElement('TD');
									td.innerHTML= "<a href='#' onclick=\"deleteRecord("+item['id']+")\"><center><input type='image' src='images/delete.png' width='24' style='cursor:pointer;' /></center></a>";
									tr.appendChild(td);
									document.getElementById('grid').appendChild(tr);
								}
						  });
		});
	}
	db.transaction(function(t) {
		t.executeSql("CREATE TABLE usuarios (id REAL UNIQUE, nome TEXT)",
					  [],
					  function(t){
					  	log.innerHTML = '';
					  },
					  onError);
	});
	function addThis(){
		var num = Math.round(Math.random() * 10000); // random data
		db.transaction( function(t) {
						t.executeSql("INSERT INTO usuarios (id, nome) VALUES (?, ?)",
									  [num, document.querySelector('#usuarioNome').value],
									  function(t, result) {
										log.innerHTML = '';
										showRecords();
									  },
									  onError);
		}); 
	}
	function deleteRecord(id) {
		if(confirm('Tem certeza que deseja excluir este usuário?'))
			db.transaction(function(t) {
							t.executeSql("DELETE FROM usuarios WHERE id=?", [id],
							function(t, result){
								showRecords();
							},
							onError);
			});
	}
	showRecords();
	
	Slides.slides[Slides.slideNumber].action= Array();
	Slides.slides[Slides.slideNumber].action[0]= function(){
		$('#table').fadeOut(function(){
			$('#code').fadeIn();
		});
	};
	Slides.slides[Slides.slideNumber].action[1]= function(){
		$('#code').fadeOut(function(){
			$('#code2').fadeIn();
		});
	};
	Slides.slides[Slides.slideNumber].action[2]= function(){
		$('#code3').fadeIn();
	};
</script>
