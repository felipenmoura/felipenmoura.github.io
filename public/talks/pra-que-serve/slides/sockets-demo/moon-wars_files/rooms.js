var ROOM = new ROOM_CLASS();

function ROOM_CLASS(){
	//rooms list window
	this.draw_rooms_list = function(message){
		PLACE = 'rooms';
		MAIN.dynamic_title();
		MAIN.unregister_buttons('rooms');
		
		MP.room_controller();
	
		x = 10;
		y = 10;
		gap = 10;
		letter_padding_left = 15;
		document.getElementById("chat_box").style.display = 'block';
		document.getElementById("chat_box").innerHTML = "";
		
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		
		if(MP.socket_live == false){
			//cconnecting block
			width = 300;
			height = 50;
			canvas_backround.strokeStyle = "#000000";
			canvas_backround.fillStyle = "#8fc74c";
			HELPER.roundRect(canvas_backround, (WIDTH_APP-width)/2, (HEIGHT_APP-27-150-height)/2, width, height, 5, true);
			
			//text
			canvas_backround.fillStyle = "#000000";
			canvas_backround.font = "Bold 13px Helvetica";
			text = "Connecting...";
			text_width = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, (WIDTH_APP-text_width)/2, (HEIGHT_APP-27-150-height)/2+30);
			
			//abort, not connected
			return false;
			}
		
		//create button
		width = 100;
		height = 30;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			ROOM.draw_create_room();
			});
		//text
		text = "Create";
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		canvas_backround.fillText(text, x+letter_padding_left+12, y+(height + HELPER.font_pixel_to_height(13))/2);
		x = x + 100+10;
		
		//refresh button
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			ROOMS = [];
			MP.register_tank_action('ask_rooms', false, name);
			ROOM.draw_rooms_list();
			});
		//text
		text = "Refresh";
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		canvas_backround.fillText(text, x+letter_padding_left+12, y+(height + HELPER.font_pixel_to_height(13))/2);
		x = x + 100+10;
		
		//back button
		width = 80;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#c50000";
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			document.getElementById("chat_box").style.display = 'none';
			MAIN.home(false);
			});
		//text
		text = "Menu";
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 14px Arial";
		canvas_backround.fillText(text, x+letter_padding_left+5, y+(height + HELPER.font_pixel_to_height(14))/2);
	
		//waiting players text
		text = "Waiting Soldiers: "+MP.get_waiting_players_count();
		canvas_backround.fillStyle = "#000000";
		canvas_backround.font = "Bold 12px Helvetica";
		canvas_backround.fillText(text, x+width+gap*2, y+(height + HELPER.font_pixel_to_height(14))/2);
		
		//error
		if(message != undefined){
			canvas_backround.fillStyle = "#c50000";
			canvas_backround.font = "Bold 14px Helvetica";
			canvas_backround.fillText(message, 500, y+(height + HELPER.font_pixel_to_height(14))/2);
			}
		
		y = y + height+10;
		x = x - 100-10;
			
		//show rooms
		padding_top = 20;
		height = 37;
		
		x = 10;
		y = 50;
		width = WIDTH_APP-20;
		height = 22.5;
		gap = 7;
		letter_padding_left = 15;
		for (var i=0; i<10; i++){
			if(ROOMS[i] != undefined){
				canvas_backround.strokeStyle = "#196119";
				canvas_backround.fillStyle = "#ffffff";
				HELPER.roundRect(canvas_backround, x, y, width, height, 0, true);
				
				//num block
				canvas_backround.strokeStyle = "#000000";
				canvas_backround.fillStyle = "#ffffff";
				HELPER.roundRect(canvas_backround, x, y, 70, height, 0, true);
	
				canvas_backround.strokeStyle = "#8fc74c";
				canvas_backround.fillStyle = "#8fc74c";
				if(ROOMS[i].progress == undefined)
					HELPER.roundRect(canvas_backround, x+1, y+1, round((70-2)*ROOMS[i].players.length/ROOMS[i].max), height-2, 0, true);
				else
					HELPER.roundRect(canvas_backround, x+1, y+1, 70-2, height-2, 0, true);
	
				//num text
				canvas_backround.fillStyle = "#3f3b30";
				canvas_backround.font = "Bold 14px Helvetica";
				if(ROOMS[i].progress == undefined)
					text = ROOMS[i].players.length+"/"+ROOMS[i].max;
				else
					text = ROOMS[i].players.length+"/"+ROOMS[i].players.length;	
				canvas_backround.fillText(text, x+letter_padding_left, y+(height + HELPER.font_pixel_to_height(14))/2);
				
				//join block
				canvas_backround.strokeStyle = "#000000";
				if(ROOMS[i].progress == undefined)
					canvas_backround.fillStyle = "#8fc74c";
				else
					canvas_backround.fillStyle = "#e2f4cd";
				HELPER.roundRect(canvas_backround, x+width-70, y, 70, height, 0, true);
				
				//on click event
				MAIN.register_button(x+width-70, y, 70, height, PLACE, function(xx, yy, extra){
					var room = ROOM.get_room_by_id(extra); 
					if(room.progress != undefined) return false;
					if(room != false && room.players.length < room.max){
						if(room.version == VERSION){
							ROOM.draw_room(extra);
							room_id_to_join = extra;
							MP.room_controller("room"+room_id_to_join);
							}
						else
							ROOM.draw_rooms_list("Error, version mismatch.");
						}
					else
						ROOM.draw_rooms_list("Error, room does not exists.");
					}, ROOMS[i].id);
		
				//join text
				canvas_backround.fillStyle = "#196119";
				canvas_backround.font = "Bold 14px Helvetica";
				if(ROOMS[i].progress == undefined)
					var text = "Join";
				else
					var text = ROOMS[i].progress+"%";
				canvas_backround.fillText(text, x+width+letter_padding_left-70, y+(height + HELPER.font_pixel_to_height(14))/2);
				
				//title text
				canvas_backround.fillStyle = "#3f3b30";
				canvas_backround.font = "Bold 12px Helvetica";
				text = ROOMS[i].name;
				canvas_backround.fillText(text, x+70+letter_padding_left,y+15);
				
				//more info text
				canvas_backround.fillStyle = "#69a126";
				canvas_backround.font = "Normal 12px Helvetica";
				if(ROOMS[i].settings[3] == 'multi_quick')
					text = "QUICK mode, "+HELPER.ucfirst(ROOMS[i].settings[0])+", "+ROOMS[i].settings[2];
				else
					text = "FULL mode, "+ROOMS[i].settings[2];
				canvas_backround.fillText(text, x-140+10+width-130, y+15);
				}
			else{
				//empty
				canvas_backround.strokeStyle = "#aaaaaa";
				canvas_backround.fillStyle = "#ffffff";
				HELPER.roundRect(canvas_backround, x, y, width, height, 0, true);
				}
			y = y + height+gap;
			}
		};
	//create new room window
	this.draw_create_room = function(game_players, mode, game_type, game_map, nation1, nation2){
		PLACE = 'create_room';
		MAIN.unregister_buttons('create_room');
		MAIN.dynamic_title();
		document.getElementById("chat_box").style.display = 'none';
		
		var offset_left = 120;
		var button_width = 80;
		var button_height = 20;
		var button_gap = 10;
		if(game_players==undefined)	game_players='20';
		if(mode==undefined)		mode='normal';	
		if(game_type==undefined)	game_type='';
		if(game_map==undefined)		game_map='Main';
		if(nation1==undefined){
			nation_tmp = [];
			for(var n in COUNTRIES){
				if(n != nation2)
					nation_tmp.push(n);
				}
			nation1 = nation_tmp[HELPER.getRandomInt(0, nation_tmp.length-1)];
			}
		if(nation2==undefined){
			nation_tmp = [];
			for(var n in COUNTRIES){
				if(n != nation1)
					nation_tmp.push(n);
				}
			nation2 = nation_tmp[HELPER.getRandomInt(0, nation_tmp.length-1)];
			}
				
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		
		
		//mode
		var offset_top = 20;
		var params = [game_players, mode, game_type, game_map, nation1, nation2];
		offset_top = DRAW.draw_mode_selection(offset_top, 'multi', params);
		offset_top = offset_top + 20;
		
		
		//NAME
		game_name = name+"'s room";
		button_active_color = '#69a126';
		button_inactive_color = '#d6d6d6';	
		//name
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		text = "Name:";
		canvas_backround.fillText(text, 10+15, offset_top+15);
		//border
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#ffffff";
		HELPER.roundRect(canvas_backround, 130, offset_top, 300, 20, 0, true);
		MAIN.register_button(130, offset_top, 300, 20, PLACE, function(){
			var name_tmp = prompt("Please enter game name", game_name);
			if(name_tmp != null){
				game_name = name_tmp;
				var offset_top = 95;
				
				//clean old name
				canvas_backround.strokeStyle = "#000000";
				canvas_backround.fillStyle = "#ffffff";
				HELPER.roundRect(canvas_backround, 130, offset_top, 300, 20, 0, true);
				
				//redraw name text value
				canvas_backround.fillStyle = "#000000";
				canvas_backround.font = "Normal 12px Arial";
				text = game_name;
				canvas_backround.fillText(text, 135, offset_top+15);
				}
			});
		//value
		canvas_backround.fillStyle = "#000000";
		canvas_backround.font = "Normal 12px Arial";
		text = game_name;
		canvas_backround.fillText(text, 135, offset_top+15);
		offset_top = offset_top + 40;
		
		
		//map
		button_height_cp = button_height;
		button_height = 50;
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		text = "Map:";
		canvas_backround.fillText(text, 10+15, offset_top+15);
		j=0;
		for(var i in MAPS){
			if(MAPS[i].singleplayer_only != undefined) continue;
			//block
			canvas_backround.strokeStyle = "#000000";
			if(MAPS[i].name == game_map)
				canvas_backround.fillStyle = button_active_color;
			else
				canvas_backround.fillStyle = button_inactive_color;
			HELPER.roundRect(canvas_backround, 10+offset_left+j*(button_width+button_gap), offset_top, button_width, button_height, 2, true);
			//action
			MAIN.register_button(10+offset_left+j*(button_width+button_gap), offset_top, button_width, button_height, PLACE, function(xx, yy, extra){
				game_map = extra;
				ROOM.draw_create_room(game_players, mode, game_type, game_map, nation1, nation2);
				}, MAPS[i].name);
			//text
			if(MAPS[i].name == game_map)
				canvas_backround.fillStyle = "#ffffff";
			else
				canvas_backround.fillStyle = "#3f3b30";
			canvas_backround.font = "Normal 12px Arial";
			text = HELPER.ucfirst(MAPS[i].name);
			var text_top = offset_top+(button_height + HELPER.font_pixel_to_height(12))/2;
			text_width = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, 10+offset_left+j*(button_width+button_gap)+(button_width-text_width)/2, text_top);
			j++;
			}
		offset_top = offset_top + 40 + button_height - button_height_cp;
		button_height = button_height_cp;
		
		
		//players
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		text = "Max players:";
		canvas_backround.fillText(text, 10+15, offset_top+15);
		values = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20];
		if(game_mode == 'multi_craft'){
			values = [2];
			game_players = 2;
			}
		button_width = button_width - 40;
		for(var i in values){
			//block
			canvas_backround.strokeStyle = "#000000";
			if(values[i] == game_players)
				canvas_backround.fillStyle = button_active_color;
			else
				canvas_backround.fillStyle = button_inactive_color;
			HELPER.roundRect(canvas_backround, 10+offset_left+i*(button_width+button_gap), offset_top, button_width, button_height, 2, true);
			//action
			MAIN.register_button(10+offset_left+i*(button_width+button_gap), offset_top, button_width, button_height, PLACE, function(xx, yy, extra){
				game_players = extra;
				ROOM.draw_create_room(game_players, mode, game_type, game_map, nation1, nation2);
				}, values[i]);
			//text
			if(values[i] == game_players)
				canvas_backround.fillStyle = "#ffffff";
			else
				canvas_backround.fillStyle = "#3f3b30";
			canvas_backround.font = "Normal 12px Arial";
			text = values[i];
			canvas_backround.fillText(text, 10+offset_left+10+i*(button_width+button_gap), offset_top+15);
			}
		button_width = button_width + 40;
		offset_top = offset_top + 40;
		
		
		//mode
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		text = "Game Mode:";
		canvas_backround.fillText(text, 10+15, offset_top+15);
		if(game_mode == 'multi_quick'){
			values = ['normal', 'random', 'mirror'];
			for(var i in values){
				//block
				canvas_backround.strokeStyle = "#000000";
				if(values[i] == mode)
					canvas_backround.fillStyle = button_active_color;
				else
					canvas_backround.fillStyle = button_inactive_color;
				HELPER.roundRect(canvas_backround, 10+offset_left+i*(button_width+button_gap), offset_top, button_width, button_height, 2, true);
				//action
				MAIN.register_button(10+offset_left+i*(button_width+button_gap), offset_top, button_width, button_height, PLACE, function(xx, yy, extra){
					mode = extra;
					ROOM.draw_create_room(game_players, mode, game_type, game_map, nation1, nation2);
					}, values[i]);
				//text
				if(values[i] == mode)
					canvas_backround.fillStyle = "#ffffff";
				else
					canvas_backround.fillStyle = "#3f3b30";
				canvas_backround.font = "Normal 12px Arial";
				text = HELPER.ucfirst(values[i]);
				canvas_backround.fillText(text, 10+offset_left+10+i*(button_width+button_gap), offset_top+15);
				}
			}
		offset_top = offset_top + 40;
		
		
		//my nation
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		text = "First nation:";
		canvas_backround.fillText(text, 10+15, offset_top+15);
		button_width = button_width + 30;
		j=0;
		for(var i in COUNTRIES){
			//block
			canvas_backround.strokeStyle = "#000000";
			if(COUNTRIES[i].file == nation1)
				canvas_backround.fillStyle = button_active_color;
			else if(COUNTRIES[i].file == nation2)
				canvas_backround.fillStyle = "#f0f9e4";
			else
				canvas_backround.fillStyle = button_inactive_color;
			HELPER.roundRect(canvas_backround, 10+offset_left+j*(button_width+button_gap), offset_top, button_width, button_height, 2, true);
			
			if(COUNTRIES[i].file == nation2){
				j++;
				continue;
				}
			//action
			MAIN.register_button(10+offset_left+j*(button_width+button_gap), offset_top, button_width, button_height, PLACE, function(xx, yy, extra){
				if(extra==nation2) return false;
				nation1 = extra;
				ROOM.draw_create_room(game_players, mode, game_type, game_map, nation1, nation2);
				}, COUNTRIES[i].file);
			//flag
			DRAW.draw_image(canvas_backround, COUNTRIES[i].file, 10+offset_left+10+j*(button_width+button_gap), offset_top+5);
			//text
			if(COUNTRIES[i].file == nation1)
				canvas_backround.fillStyle = "#ffffff";
			else
				canvas_backround.fillStyle = "#3f3b30";
			canvas_backround.font = "Normal 12px Arial";
			text = HELPER.ucfirst(COUNTRIES[i].name);
			canvas_backround.fillText(text, 20+10+offset_left+10+j*(button_width+button_gap), offset_top+15);
			j++;
			}
		offset_top = offset_top + 30;
		
		
		//enemy nation
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		text = "Second nation:";
		canvas_backround.fillText(text, 10+15, offset_top+15);
		j=0;
		for(var i in COUNTRIES){
			//block
			canvas_backround.strokeStyle = "#000000";
			if(COUNTRIES[i].file == nation2)
				canvas_backround.fillStyle = button_active_color;
			else if(COUNTRIES[i].file == nation1)
				canvas_backround.fillStyle = "#f0f9e4";
			else
				canvas_backround.fillStyle = button_inactive_color;
			HELPER.roundRect(canvas_backround, 10+offset_left+j*(button_width+button_gap), offset_top, button_width, button_height, 2, true);
			
			if(COUNTRIES[i].file == nation1){
				j++;
				continue;
				}
			//action
			MAIN.register_button(10+offset_left+j*(button_width+button_gap), offset_top, button_width, button_height, PLACE, function(xx, yy, extra){
				if(extra==nation1) return false;
				nation2 = extra;
				ROOM.draw_create_room(game_players, mode, game_type, game_map, nation1, nation2);
				}, COUNTRIES[i].file);
			//flag
			DRAW.draw_image(canvas_backround, COUNTRIES[i].file, 10+offset_left+10+j*(button_width+button_gap), offset_top+5);
			//text
			if(COUNTRIES[i].file == nation2)
				canvas_backround.fillStyle = "#ffffff";
			else
				canvas_backround.fillStyle = "#3f3b30";
			canvas_backround.font = "Normal 12px Arial";
			text = HELPER.ucfirst(COUNTRIES[i].name);
			canvas_backround.fillText(text, 20+10+offset_left+10+j*(button_width+button_gap), offset_top+15);
			j++;
			}
		offset_top = offset_top + 40;
		
		//create button
		button_width = 130;
		button_height = 40;
		offset_top = offset_top + 20;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";
		HELPER.roundRect(canvas_backround, 10+offset_left, offset_top, button_width, button_height, 2, true);
		//text
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Arial";
		text = "Create Game";
		text_width = canvas_backround.measureText(text).width;
		var text_top = offset_top+(button_height + HELPER.font_pixel_to_height(13))/2;
		canvas_backround.fillText(text, 10+offset_left+round((button_width-text_width)/2), text_top);
		//register button
		MAIN.register_button(10+offset_left, offset_top, button_width, button_height, PLACE, function(){
			new_id = MP.register_new_room(game_name, mode, game_type, game_players, game_map, nation1, nation2, game_mode);
			ROOM.draw_room(new_id);
			MP.room_controller("room"+new_id);
			});
		offset_left = offset_left + button_width + 10;
		
		//back button
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#c50000";
		HELPER.roundRect(canvas_backround, 10+offset_left, offset_top, button_width, button_height, 2, true);
		//texts
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Arial";
		text = "Back";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, 10+offset_left+round((button_width-text_width)/2), text_top);
		//register back button
		MAIN.register_button(10+offset_left, offset_top, button_width, button_height, PLACE, function(){
			room_id_to_join = -1;
			ROOM.draw_rooms_list();
			});
		offset_top = offset_top + 30+10;
		
		//notice
		offset_left = 120;
		canvas_backround.fillStyle = "#000000";
		canvas_backround.font = "Normal 12px Arial";
		text = "Notice: If you are hosting game, please do not switch this tab or minimize browser while game is active.";
		canvas_backround.fillText(text, 10+offset_left, 30+offset_top);
		};
	//room waiting for players
	this.draw_room = function(room_id){
		PLACE = 'room';
		MAIN.dynamic_title(room_id);
		MAIN.unregister_buttons('room');
		
		room = ROOM.get_room_by_id(room_id);
		opened_room_id = room.id;
		players = room.players;
		
		x = 10;
		y = 10;
		width = 135;
		height = 35;
		gap = 10;
		letter_padding_left = 15;
		document.getElementById("chat_box").style.display = 'block';
		document.getElementById("chat_box").innerHTML = "";
		
		//count players
		var team_r_n=0;
		var team_b_n=0;
		for(var j in room.players){
			if(room.players[j].team=='R') team_r_n++;
			else 	if(room.players[j].team=='B') team_b_n++;
			}
		
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		
		//back button
		width = 80;
		height = 30;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#c50000";
		height = 35;
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			MP.register_tank_action('leave_room', room.id, name);
			room_id_to_join = -1;
			ROOM.draw_rooms_list();
			});
		//text
		text = "Back";
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 14px Arial";
		canvas_backround.fillText(text, x+letter_padding_left+5, y+(height + HELPER.font_pixel_to_height(14))/2);
		
		x = x + 80+10;
		
		//start button
		width = 130;
		if(room.host==name){
			canvas_backround.strokeStyle = "#000000";
			if(room.players.length%2==0 && team_r_n == team_b_n)
				canvas_backround.fillStyle = "#69a126";	//active
			else
				canvas_backround.fillStyle = "#e2e2e2";	//inactive
			HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
			if(room.players.length%2==0 && team_r_n == team_b_n || DEBUG==true){
				MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
					//check if room has correct player number
					var room_tmp = ROOM.get_room_by_id(opened_room_id);
					if(room_tmp == false || room_tmp.players.length%2==1){
						if(DEBUG==false) 
							return false;	//error or wrong count
						}
					//count teams
					//show select tanks room
					host_enemy_name = '';
					host_team = '';
					room = ROOM.get_room_by_id(room_id);
					for(var i in room.players){
						if(room.players[i].name == room.host){
							host_team = room.players[i].team;
							break;
							}	
						}
					for(var i in room.players){
						if(room.players[i].team != host_team){
							host_enemy_name = room.players[i].name;
							break;
							}	
						}
					MP.register_tank_action('prepare_game', opened_room_id, host_enemy_name);
					});
				}
		
			//text
			text = "Start this game";
			if(room.players.length%2==0 && team_r_n == team_b_n)
				canvas_backround.fillStyle = "#ffffff";	//enabled
			else
				canvas_backround.fillStyle = "#000000";	//disabled
			canvas_backround.font = "Bold 13px Helvetica";
			canvas_backround.fillText(text, x+letter_padding_left, y+(height + HELPER.font_pixel_to_height(13))/2);
			}
		x = x + width+10;
			
		//switch block	
		width = 60;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#8fc74c";
		HELPER.roundRect(canvas_backround, x, y, width, height, 3, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			MP.send_packet('switch_side', [opened_room_id, name]);
			});
		//text
		text = "Switch";
		canvas_backround.fillStyle = "#000000";
		canvas_backround.font = "Bold 12px Arial";
		canvas_backround.fillText(text, x+letter_padding_left-5, y+(height + HELPER.font_pixel_to_height(14))/2);
		x = x + width+10;	
		
		//Waiting players text
		text = "Waiting Soldiers: "+MP.get_waiting_players_count();
		canvas_backround.fillStyle = "#000000";
		canvas_backround.font = "Bold 11px Helvetica";
		canvas_backround.fillText(text, x, y+(height + HELPER.font_pixel_to_height(14))/2);	
		
		x = WIDTH_APP - 350;
	
		//game name
		text = room.name;
		canvas_backround.fillStyle = "#196119";
		canvas_backround.font = "Bold 12px Helvetica";
		canvas_backround.fillText(text, x+60, y+15);
		y = y + 20;
		
		//game settings
		if(game_mode == 'multi_craft')
			text = "Full mode, " + HELPER.ucfirst(room.settings[2])+", "+room.max+" player";
		else
			text = HELPER.ucfirst(room.settings[0])+", "+HELPER.ucfirst(room.settings[2])+", "+room.max+" players";
		canvas_backround.fillStyle = "#69a126";
		canvas_backround.font = "Normal 12px Helvetica";
		canvas_backround.fillText(text, x+60, y+15);
		y = y - 20;	
	
		y = y + height+20;	
		x = x - 80-10;
		
		//show players
		height = 21;
		gap = 7;
		width = (WIDTH_APP-20-gap)/2;
		letter_padding_left = 10;
		x1 = 10;
		x2 = 10+gap+width;
		flag_space = (height - UNITS.flag_height)/2;
		y_begin = y;
		icon_width = height;
		
		//LEFT
		left_n = 0;
		for(var i in players){
			if(players[i].team=="B"){
				left_n++;
				//man block
				canvas_backround.strokeStyle = "#196119";
				canvas_backround.fillStyle = "#8fc74c";
				HELPER.roundRect(canvas_backround, x1, y, width, height, 0, true);
				
				//flag
				DRAW.draw_image(canvas_backround, room.nation1, x1+flag_space, y+flag_space);
				
				//name
				text = players[i].name;
				canvas_backround.fillStyle = "#000000";
				canvas_backround.font = "Bold 13px Helvetica";
				canvas_backround.fillText(text, x1+icon_width+letter_padding_left, y+(height + HELPER.font_pixel_to_height(13))/2);
		
				if(room.host==name && players[i].name != name){
					//kick block
					canvas_backround.strokeStyle = "#000000";
					canvas_backround.fillStyle = "#c50000";
					HELPER.roundRect(canvas_backround, x1+width-50, y, 50, height, 0, true);
					
					//kick text
					text = "Kick";
					canvas_backround.fillStyle = "#ffffff";
					canvas_backround.font = "Bold 12px Helvetica";
					canvas_backround.fillText(text, x1+width-50+letter_padding_left, y + (height + HELPER.font_pixel_to_height(12))/2);
					
					//onkick event
					MAIN.register_button(x1+width-50, y, 50, height, PLACE, function(xx, yy, extra){
						ROOM.on_kick_player('left', extra, opened_room_id);
						}, left_n-1);
					}			
				}
			else
				continue;
			y = y + height+gap;
			}
		for (var i=left_n; i<10; i++){
			//empty
			canvas_backround.strokeStyle = "#aaaaaa";
			canvas_backround.fillStyle = "#ffffff";
			HELPER.roundRect(canvas_backround, x1, y, width, height, 0, true);
			
			y = y + height+gap;
			}
		
		//RIGHT
		y = y_begin;
		right_n = 0;
		for(var i in players){
			if(players[i].team=="R"){
				right_n++;
				//man block
				canvas_backround.strokeStyle = "#196119";
				canvas_backround.fillStyle = "#8fc74c";
				HELPER.roundRect(canvas_backround, x2, y, width, height, 0, true);
				
				//flag
				DRAW.draw_image(canvas_backround, room.nation2, x2+flag_space, y+flag_space);
				
				//name
				text = players[i].name;
				canvas_backround.fillStyle = "#000000";
				canvas_backround.font = "Bold 13px Helvetica";
				canvas_backround.fillText(text, x2+icon_width+letter_padding_left, y+(height + HELPER.font_pixel_to_height(13))/2);
				
				if(room.host==name && players[i].name != name){
					//kick block
					canvas_backround.strokeStyle = "#000000";
					canvas_backround.fillStyle = "#c50000";
					HELPER.roundRect(canvas_backround, x2+width-50, y, 50, height, 0, true);
					
					//kick text
					text = "Kick";
					canvas_backround.fillStyle = "#ffffff";
					canvas_backround.font = "Bold 12px Helvetica";
					canvas_backround.fillText(text, x2+width-50+letter_padding_left, y+(height + HELPER.font_pixel_to_height(12))/2);
					
					//onkick event
					MAIN.register_button(x2+width-50, y, 50, height, PLACE, function(xx, yy, extra){
						ROOM.on_kick_player('right', extra, opened_room_id);	
						}, right_n-1);
					}	
				}
			else
				continue;
			y = y + height+gap;
			}
		for (var i=right_n; i<10; i++){
			//empty
			canvas_backround.strokeStyle = "#aaaaaa";
			canvas_backround.fillStyle = "#ffffff";
			HELPER.roundRect(canvas_backround, x2, y, width, height, 0, true);
			
			y = y + height+gap;
			}
		};
	//kick button was pressed - find player
	this.on_kick_player = function(side, index, room_id){
		left_n = 0;
		right_n = 0;
		room = ROOM.get_room_by_id(room_id);
		for(var i in room.players){
			if(side=='left' &&  room.players[i].team=="B"){
				if(index==left_n)
					MP.register_tank_action('kick_player', room_id,  room.players[i].name);
				left_n++;
				}
			if(side=='right' &&  room.players[i].team=="R"){
				if(index==right_n)
					MP.register_tank_action('kick_player', room_id,  room.players[i].name);
				right_n++;
				}
			}
		};
	//returns room by id
	this.get_room_by_id = function(room_id){
		for(var i in ROOMS){
			if(ROOMS[i].id == room_id){
				return ROOMS[i];
				}
			}
		return false;
		};
	this.get_active_room_progress = function(){
		room = ROOM.get_room_by_id(opened_room_id);
		var progress = 0;
		var towers_hp = 0;
		var towers_total_hp = 0;
		var base_hp = 0;
		var base_total_hp = 0;
		var towers_n = 0;
		var bases_n = 0;
		var teams = ['B', 'R'];	
		for(var t in teams){
			var team = teams[t];
			var progress_tmp = 0;
			towers_n = 0;
			bases_n = 0;
			towers_hp = 0;
			towers_total_hp = 0;
			base_hp = 0;
			base_total_hp = 0;
			
			//find data
			for(var i in MAPS){
				if(MAPS[i].name == room.settings[2]){
					for(var t in MAPS[i].towers){
						if(MAPS[i].towers[t][0]==team){
							if(MAPS[i].towers[t][3]=='Tower')
								towers_n++;
							else if(MAPS[i].towers[t][3]=='Base')
								bases_n++;
							}
						}
					}
				}
			for(var i in TYPES){
				if(TYPES[i].name == 'Tower'){
					towers_total_hp = towers_n * TYPES[i].life[0];
					}
				else if(TYPES[i].name == 'Base'){
					base_total_hp = bases_n * TYPES[i].life[0];
					}
				}
			for(var i in TANKS){
				if(TANKS[i].team == team){
					if(TYPES[TANKS[i].type].name == 'Tower')
						towers_hp +=  TANKS[i].hp;
					else if(TYPES[TANKS[i].type].name == 'Base')
						base_hp +=  TANKS[i].hp;
					}
				}
			//calc
			if(towers_total_hp == 0)
				progress_tmp += 30;
			else
				progress_tmp += 0.3*((towers_total_hp-towers_hp)*100/towers_total_hp);
			if(base_total_hp == 0)
				progress_tmp += 70;
			else
				progress_tmp += 0.7*((base_total_hp-base_hp)*100/base_total_hp);
			if(progress_tmp > progress)
				progress = progress_tmp;
			}
		return round(progress);
		};
	}
