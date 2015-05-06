var MP = new MP_CLASS();

function MP_CLASS(){
	this.socket_live = false;
	var orbiter;
	var Rooms_obj;
	var Room_id_obj;
	var waiting_users = 0;
	var SOCKET_ROOMS = '';
	var SOCKET_ROOM_ID = '';
	var SOCKET_ROOM_PREFIX = 'mv_';
	
	//===== LIBRARY ==========================================================
	
	//connecto to sockets server
	this.connect_server = function(){
		orbiter = new net.user1.orbiter.Orbiter();
		orbiter.getConnectionMonitor().setAutoReconnectFrequency(15000);
		orbiter.getLog().setLevel(net.user1.logger.Logger.FATAL);
		if (!orbiter.getSystem().isJavaScriptCompatible())
			return alert("Error: your browser do not support JavaScript.");
		orbiter.addEventListener(net.user1.orbiter.OrbiterEvent.READY, MP.readyListener, this);
		orbiter.addEventListener(net.user1.orbiter.OrbiterEvent.CLOSE, MP.disconnect_server, this);
		orbiter.connect(SOCKET[0], SOCKET[1]);
		};
	//on connection ready
	this.readyListener = function(e){
		SOCKET_ROOMS = SOCKET_ROOM_PREFIX+"rooms";
		Rooms_obj = orbiter.getRoomManager().createRoom(SOCKET_ROOMS);
		Rooms_obj.addEventListener(net.user1.orbiter.RoomEvent.JOIN, MP.joinRoomsListener);
		Rooms_obj.addEventListener(net.user1.orbiter.RoomEvent.ADD_OCCUPANT, MP.addOccupantListener);
		Rooms_obj.addEventListener(net.user1.orbiter.RoomEvent.REMOVE_OCCUPANT, MP.removeOccupantListener);  
		Rooms_obj.addMessageListener("CHAT_MESSAGE", MP.get_packet_inner);
		Rooms_obj.join();
		//status
		MP.socket_live = true;
		try{parent.document.getElementById("connected").innerHTML = 'single';}catch(error){}
		};
	//controlls which rooms to join and leave
	this.room_controller = function(new_room){
		if(MP.socket_live == false) return false;
		if((PLACE == 'rooms' || PLACE == 'room' || PLACE == 'create_room') && SOCKET_ROOMS==''){
			//connect to rooms list
			SOCKET_ROOMS = SOCKET_ROOM_PREFIX+"rooms";
			Rooms_obj = orbiter.getRoomManager().createRoom(SOCKET_ROOMS);
			Rooms_obj.addEventListener(net.user1.orbiter.RoomEvent.JOIN, MP.joinRoomsListener);	
			Rooms_obj.addEventListener(net.user1.orbiter.RoomEvent.ADD_OCCUPANT, MP.addOccupantListener);
			Rooms_obj.addEventListener(net.user1.orbiter.RoomEvent.REMOVE_OCCUPANT, MP.removeOccupantListener);  
			Rooms_obj.addMessageListener("CHAT_MESSAGE", MP.get_packet_inner);
			Rooms_obj.join();
			}
		else if(PLACE == 'select' && SOCKET_ROOMS != ''){
			room = ROOM.get_room_by_id(opened_room_id);
			if(room.host != name){	//let host be connected to all and broadcast game status
				//disconnect from all rooms
				SOCKET_ROOMS = '';
				Rooms_obj.removeEventListener(net.user1.orbiter.RoomEvent.JOIN, MP.joinRoomsListener);
				Rooms_obj.removeEventListener(net.user1.orbiter.RoomEvent.ADD_OCCUPANT, MP.addOccupantListener);
				Rooms_obj.removeEventListener(net.user1.orbiter.RoomEvent.REMOVE_OCCUPANT, MP.removeOccupantListener);
				Rooms_obj.removeMessageListener("CHAT_MESSAGE", MP.get_packet_inner);
				Rooms_obj.leave();
				}
			}
		else if((PLACE == 'rooms' || PLACE == 'init') && SOCKET_ROOM_ID != ''){
			//disconnect from last room
			SOCKET_ROOM_ID = '';
			Room_id_obj.removeEventListener(net.user1.orbiter.RoomEvent.JOIN, MP.joinRoomListener_id);
			Room_id_obj.removeEventListener(net.user1.orbiter.RoomEvent.ADD_OCCUPANT, MP.addOccupantListener_id);
			Room_id_obj.removeEventListener(net.user1.orbiter.RoomEvent.REMOVE_OCCUPANT, MP.removeOccupantListener_id);
			Room_id_obj.removeMessageListener("CHAT_MESSAGE", MP.get_packet_inner_id);
			Room_id_obj.leave();
			}
		else if((PLACE == 'room' || PLACE == 'select' || PLACE == 'game') && SOCKET_ROOM_ID==''){
			//connect to room
			SOCKET_ROOM_ID = SOCKET_ROOM_PREFIX+new_room;
			Room_id_obj = orbiter.getRoomManager().createRoom(SOCKET_ROOM_ID);
			Room_id_obj.addEventListener(net.user1.orbiter.RoomEvent.JOIN, MP.joinRoomListener_id);
			Room_id_obj.addEventListener(net.user1.orbiter.RoomEvent.ADD_OCCUPANT, MP.addOccupantListener_id);
			Room_id_obj.addEventListener(net.user1.orbiter.RoomEvent.REMOVE_OCCUPANT, MP.removeOccupantListener_id);  
			Room_id_obj.addMessageListener("CHAT_MESSAGE", MP.get_packet_inner_id);
			Room_id_obj.join();
			if(SOCKET_ROOMS != '' && PLACE != 'room'){
				room = ROOM.get_room_by_id(opened_room_id);
				if(room.host != name){
					//disconnect from all rooms
					SOCKET_ROOMS = '';
					Rooms_obj.removeEventListener(net.user1.orbiter.RoomEvent.JOIN, MP.joinRoomsListener);
					Rooms_obj.removeEventListener(net.user1.orbiter.RoomEvent.ADD_OCCUPANT, MP.addOccupantListener);
					Rooms_obj.removeEventListener(net.user1.orbiter.RoomEvent.REMOVE_OCCUPANT, MP.removeOccupantListener);
					Rooms_obj.removeMessageListener("CHAT_MESSAGE", MP.get_packet_inner);
					Rooms_obj.leave();
					}
				}
			}
		try{
			if(SOCKET_ROOM_ID != '' && SOCKET_ROOMS != '')
				parent.document.getElementById("connected").innerHTML = 'dual';
			else if(SOCKET_ROOMS != '')
				parent.document.getElementById("connected").innerHTML = 'single';
			else if(SOCKET_ROOM_ID != '')
				parent.document.getElementById("connected").innerHTML = 'single-id';
			else
				parent.document.getElementById("connected").innerHTML = 'none';
			}
		catch(error){}
		};
	//we joined the room
	this.joinRoomsListener = function(e){
		//redraw list
		MP.register_tank_action('ask_rooms', false, name);
		waiting_users = Rooms_obj.getNumOccupants();
		if(PLACE=='rooms')
			ROOM.draw_rooms_list();
		else if(PLACE=='room')
			ROOM.draw_room(opened_room_id);
		};
	this.joinRoomListener_id = function(e){
		if(room_id_to_join != -1){
			MP.register_tank_action('join_room', room_id_to_join, name);
			ROOM.draw_room(room_id_to_join);
			room_id_to_join = -1;
			}	
		};
	//client joins room
	this.addOccupantListener = function(e) {
		if(Rooms_obj.getSyncState() != net.user1.orbiter.SynchronizationState.SYNCHRONIZING) { 
			waiting_users = Rooms_obj.getNumOccupants();
			if(PLACE=='rooms')
				ROOM.draw_rooms_list();
			else if(PLACE=='room')
				ROOM.draw_room(opened_room_id);
			}
		};
	this.addOccupantListener_id = function(e) {};
	//client leaves room
	this.removeOccupantListener = function(e){
		waiting_users = Rooms_obj.getNumOccupants();
		if(PLACE=='rooms')
			ROOM.draw_rooms_list();
		else if(PLACE=='room')
			ROOM.draw_room(opened_room_id);
		};
	this.removeOccupantListener_id = function(e) {};
	//do clean disconnect from server
	this.disconnect_server = function(e){
		//disconnect
		if(MP.socket_live == true){
			if(SOCKET_ROOMS != '')
				Rooms_obj.leave();
			if(SOCKET_ROOM_ID != '')	
				Room_id_obj.leave();
			orbiter.disconnect();
			}
		//update status
		MP.socket_live = false;
		try{parent.document.getElementById("connected").innerHTML = 'none';}catch(error){}
		};
	this.get_packet_inner = function(fromClient, message){
		MP.get_packet(fromClient, message);
		};
	this.get_packet_inner_id = function(fromClient, message){
		MP.get_packet(fromClient, message);
		};
	
	//===== COMMUNICATION ====================================================
	
	//send packet to server
	this.send_packet = function(type, message, force_list_connection){
		if(message.length == 0){
			console.log('Error: empty message, type: '+type);
			return false;
			}
		if(MP.socket_live==false){
			console.log('Error: trying to send without connection: '+type);
			return false;
			}
		/*if(DEBUG==true){
			if(type=="tank_update")
				console.log("["+type+"]------->"+message[0]);
			else
				console.log("["+type+"]------->");
			}*/
		
		//log packets count
		packets_used++;
		if(packets_used > MAX_SENT_PACKETS){
			console.log('Error: '+MAX_SENT_PACKETS+' packets reached.');
			return false;
			}
		try{	
			var string;
			if(packets_used>999)
				string = round(packets_used/1000)+"k/";
			else
				string = packets_used+"/";
			if(packets_all>999)
				string = string+round(packets_all/1000)+"k";
			else
				string = string+packets_all;
			parent.document.getElementById("packets").innerHTML = string;
			}catch(error){}
		
		//make and send message
		message = {
			type: type,
			message: message,
			};
		message = JSON.stringify(message);
		
		if(force_list_connection != undefined && SOCKET_ROOMS != '')
			Rooms_obj.sendMessage("CHAT_MESSAGE", "true", null, message);		//forced to use all rooms
		else if((PLACE == 'select' || PLACE == 'game' || PLACE == 'score') && SOCKET_ROOM_ID != '')
			Room_id_obj.sendMessage("CHAT_MESSAGE", "true", null, message);		//use our room
		else if(SOCKET_ROOMS != '')
			Rooms_obj.sendMessage("CHAT_MESSAGE", "true", null, message);		//use all rooms
		else
			console.log('Error: we are not joined any room, place: '+PLACE);	//error
		};
	//get packets from server
	this.get_packet = function(fromClient, message){
		packets_all++;	
		try{
			var string;
			if(packets_used>999)
				string = round(packets_used/1000)+"k/";
			else
				string = packets_used+"/";
			if(packets_all>999)
				string = string+round(packets_all/1000)+"k";
			else
				string = string+packets_all;
			parent.document.getElementById("packets").innerHTML = string;
			}catch(error){}
		DATA = JSON.parse(message);
		var type = DATA.type;
		DATA = DATA.message;
		//if(DEBUG==true) 	console.log("<-------["+type+"]");
		
		if(type == 'new_room'){		//new room was created
			var n = ROOMS.length;
			if(ROOM.get_room_by_id(DATA.id) != false) return false;
			ROOMS.push(DATA);
			if(PLACE=='rooms')
				ROOM.draw_rooms_list();
			}
		else if(type == 'delete_room'){	//room was deleted
			for(var i=0; i < ROOMS.length; i++){	
				if(ROOMS[i].id == DATA){
					ROOMS.splice(i, 1); i--;
					if(PLACE=='rooms')
						ROOM.draw_rooms_list();
					if(PLACE=='room' && opened_room_id == DATA){
						//room was deleted, go to list
						ROOM.draw_rooms_list();
						}
					}
				}
			}
		else if(type == 'ask_rooms'){	//somebody is asking rooms list
			if(PLACE == 'room'){
				room = ROOM.get_room_by_id(opened_room_id);
				if(room.host == name)
					MP.send_packet('new_room', room);	//broadcast it
				}
			else if(PLACE == 'select'){ //i am host and i can broadcast started game status...
				room = ROOM.get_room_by_id(opened_room_id);
				room.progress = 0;
				MP.send_packet('new_room', room, true);	//broadcast it
				}
			else if(PLACE == 'game'){ //i am host and i can broadcast started game status...
				room = ROOM.get_room_by_id(opened_room_id);
				room.progress = ROOM.get_active_room_progress();
				MP.send_packet('new_room', room, true);	//broadcast it
				}
			}
		else if(type == 'leave_room'){	//player leaving room
			//DATA = [room_id, player_name]
			var room = ROOM.get_room_by_id(DATA[0]);
			if(room != false){
				for(var j=0; j < room.players.length; j++){
					if(room.players[j].name == DATA[1]){
						room.players.splice(j, 1); j--;
						if(PLACE=='room')
							ROOM.draw_room(room.id);
						return false;
						}
					}
				}
			else
				log('Error: can not find room for leaving.');
			}
		else if(type == 'kick_player'){	//player was kicked
			//DATA = [room_id, player_name]
			var room = ROOM.get_room_by_id(DATA[0]);
			if(room.host==DATA[1]){
				console.log('Error: attempt to kick host from room...');
				return false; // host was kicked, this is probably hack from outside
				}
			if(room != false){
				for(var j=0; j < room.players.length; j++){
					if(room.players[j].name == DATA[1]){
						room.players.splice(j, 1);  j--;
						if(DATA[1] == name){
							if(PLACE=='room'){
								//i was kicked ... go back
								ROOM.draw_rooms_list();
								}
							}
						else{
							//other player was kicked - repaint room
							if(PLACE=='room')
								ROOM.draw_room(room.id);
							return false;
							}
						}
					}
				}
			}
		else if(type == 'join_room'){	//player joining room
			//DATA = [room_id, player_name]
			if(PLACE != 'room'){ //game started
				if(DATA[1] == MY_TANK.name){	//if me
					room_id_to_join = -1;
					ROOM.draw_rooms_list();
					}
				return false;
				}	
			var room = ROOM.get_room_by_id(DATA[0]);
			if(room != false){
				//find team
				player_team = 'R';
				team_r_n=0;
				team_b_n=0;
				for(var j in room.players){
					if(room.players[j].team=='R') team_r_n++;
					else 	if(room.players[j].team=='B') team_b_n++;
					}
				if(team_b_n<team_r_n)
					player_team = 'B';	
				//join
				room.players.push({
					name: DATA[1], 
					team: player_team,
					nation: UNITS.get_nation_by_team(player_team),
					});
				
				//repaint
				if(PLACE=='room')
					ROOM.draw_room(room.id);
				}
			}
		else if(type == 'switch_side'){	//player switch sides
			//DATA = [room_id, player_name]
			if(PLACE != 'room') return false;
			if(DATA[0] != opened_room_id) return false;
			if(PLACE != 'room') return false; //game started
			var room = ROOM.get_room_by_id(DATA[0]);
			if(room != false){
				//find team
				player_team = 'R';
				team_r_n=0;
				team_b_n=0;
				for(var j in room.players){
					if(room.players[j].team=='R') team_r_n++;
					else 	if(room.players[j].team=='B') team_b_n++;
					}
				if(team_b_n<team_r_n)
					player_team = 'B';
				
				//try to switch
				for(var j in room.players){
					if(room.players[j].name==DATA[1]){
						if(room.players[j].team == 'R' && room.max/2 > team_b_n)
							room.players[j].team = 'B';
						else if(room.players[j].team == 'B' && room.max/2 > team_r_n)
							room.players[j].team = 'R';
						room.players[j].nation = UNITS.get_nation_by_team(room.players[j].team);
						}
					}
							
				//repaint
				if(PLACE=='room')
					ROOM.draw_room(room.id);
				}
			}
		else if(type == 'prepare_game'){	//prepare game - select tanks/maps screen
			//DATA = [room_id, host_enemy_name]
			if(PLACE=="room" && opened_room_id==DATA[0]){
				room = ROOM.get_room_by_id(DATA[0]);
				game_mode = room.settings[3];
				room.host_enemy_name = DATA[1];
				room.players_max = room.players.length;
				if(game_mode == 'multi_quick'){
					start_game_timer_id = setInterval(MAIN.starting_game_timer_handler, 1000);
					DRAW.draw_tank_select_screen();
					if(room.host==name && room.settings[0] != 'normal'){
						UNITS.choose_and_register_tanks(room);
						}
					}
				else if(game_mode == 'multi_craft'){
					DRAW.draw_tank_select_screen(); //jsut let system to prepare here
					MP.register_tank_action('start_game', opened_room_id, false, room.players);
					}
				}
			else if(PLACE=="rooms"){
				for(var i=0; i < ROOMS.length; i++){	
					if(ROOMS[i].id == DATA[0]){
						ROOMS.splice(i, 1); i--;
						}
					}
				ROOM.draw_rooms_list();
				}
			}
		else if(type == 'change_tank'){		//change map in selecting screen
			//DATA = room_id, tank_index, player_name, in_game]
			if(PLACE=="select"){
				var room = ROOM.get_room_by_id(DATA[0]);
				if(room != false){
					//find and update player
					for(var p in room.players){
						if(room.players[p].name == DATA[2]){
							room.players[p].tank = DATA[1];
							}
						}
					if(DATA[2]==name){
						//me
						my_tank_nr = DATA[1];
						DRAW.draw_tank_select_screen(my_tank_nr);
						}
					else
						DRAW.draw_tank_select_screen();
					}
				}
			}
		else if(type == 'start_game'){	//start game
			//DATA = game_id, players_data
			if(PLACE=="select" && opened_room_id==DATA[0]){
				room = ROOM.get_room_by_id(DATA[0]);
				var players_data = DATA[1];
				//sync players
				for(var p in players_data){
					for(var i in room.players){
						if(room.players[i].name == players_data[p].name){
							room.players[i].team = players_data[p].team;
							room.players[i].nation = UNITS.get_nation_by_team(room.players[i].team);
							room.players[i].tank = players_data[p].tank; 
							break;
							}
						}
					}
				
				//check map
				current_level = 1;
				for(var m in MAPS){
					if(MAPS[m].name == room.settings[2])
						current_level = parseInt(m)+1;
					}
				//check my team - make sure all players see same teams
				var my_team='B';
				for(var p in room.players){
					if(room.players[p].name == name)
						my_team = room.players[p].team;
					}
				//start	
				clearInterval(start_game_timer_id, my_team);
				MAIN.start_game(current_level, my_team);
				}
			}
		else if(type == 'end_game'){		//game ends
			//DATA = [game_id, win_team]
			//if me host, broadcast game end
			room = ROOM.get_room_by_id(opened_room_id);
			if(room.host == name){
				MP.send_packet('delete_room', room.id, true);
				}
			//draw scores
			if(PLACE=="game" && opened_room_id==DATA[0])
				DRAW.draw_final_score(false, DATA[1]);
			}
		else if(type == 'leave_game'){		//player leaving game
			//DATA = [room_id, player_name]
			MAIN.chat(DATA[1]+" left the game.", false, false);
			room = ROOM.get_room_by_id(DATA[0]);
			if(room.host == DATA[1]){	//host left game ... we are in trouble, unless we switch host to other person
				if(room.host == room.host_enemy_name){	//we lost second host - we are in trouble now
					MP.register_tank_action('end_game', opened_room_id, false, false);
					return false;
					}
				room.host = room.host_enemy_name;	//fixed
				}
			for(var p in room.players){
				if(room.players[p].name == DATA[1])
					room.players[p].ping = Date.now()-60*1000;
				}
			}
		else if(type == 'tank_move'){		//tank move
			//DATA = room_id, tank_id, [from_x, from_y, to_x, to_y, lock, direction] 
			if(PLACE=="game" && opened_room_id==DATA[0]){
				//sound
				if(DATA[1] == name && MUTE_FX==false){
					try{
						audio_finish = document.createElement('audio');
						audio_finish.setAttribute('src', '../sounds/click'+SOUND_EXT);
						audio_finish.volume = FX_VOLUME;
						audio_finish.play();
						}
					catch(error){}
					}
				//move tank
				var ids = [];
				if(typeof DATA[1] != 'object')
					ids = [DATA[1]];
				else
					ids = DATA[1];
				//unselect all teams units
				var tank_tmp = UNITS.get_tank_by_id(ids[0]);
				if(tank_tmp===false){
					console.log('Error: tank "'+ids[0]+'" was not found on tank_move.');
					return false;
					}
				for(var i in TANKS){
					if(TANKS[i].team != tank_tmp.team) continue;
					delete TANKS[i].selected;
					}
				for(var i in ids){
					TANK = UNITS.get_tank_by_id(ids[i]);
					if(TANK===false){
						console.log('Error: tank "'+ids[i]+'" was not found on tank_move.');
						return false;
						}
					MP.update_players_ping(TANK.name);
					if(ids.length == 1)
						UNITS.sync_movement(TANK, DATA[2][0], DATA[2][1], 100);
					if(game_mode == 'multi_quick'){
						TANK.move = 1;
						TANK.move_to = [DATA[2][2], DATA[2][3]];
						}
					else{
						TANK.selected = 1;
						if(DATA[2][4] == undefined)
							UNITS.calc_new_position(TANK.team, DATA[2][2], DATA[2][3]);
						}
					delete TANK.target_move_lock;
					if(DATA[2][4] != undefined){
						//target lock
						TANK.target_move_lock = DATA[2][4];
						TANK.target_shoot_lock = DATA[2][4];
						}
					if(DATA[2][5] != undefined)
						TANK.move_direction = DATA[2][5];
					}
				}
			}
		else if(type == 'skill_do'){	//tank skill start
			//DATA = room_id, tank_id, nr=[1,2,3], random
			if(PLACE != "game" || opened_room_id!=DATA[0]) return false;
			var ids = [];
			if(typeof DATA[1] != 'object')
				ids = [DATA[1]];
			else
				ids = DATA[1];
			for(var i in ids){
				TANK_FROM = UNITS.get_tank_by_id(ids[i]);
				if(TANK_FROM===false){
					console.log('Error: tank "'+ids[i]+'" was not found on skill_do.');
					return false;
					}
				var nr = DATA[2];	
				var ability_function = TYPES[TANK_FROM.type].abilities[nr-1].name.replace(/ /g,'_');
				//execute
				TANK_FROM.rand = DATA[3];
				var ability_reuse = SKILLS[ability_function](TANK_FROM);
				//reuse	
				if(ability_reuse != undefined && ability_reuse != 0){	
					TANK_FROM.abilities_reuse[nr-1] = Date.now() + ability_reuse;
					TANK_FROM.abilities_reuse_max[nr-1] = ability_reuse;
					}
				}
			}
		else if(type == 'chat'){		//chat
			//DATA = room_id, data, player, team, place, shift
			if(DATA[5] != 1){				
				if(PLACE != DATA[4]) return false;
				if(PLACE=='game' && DATA[0] != opened_room_id) return false;
				if(PLACE=='room' && DATA[0] != opened_room_id) return false;
				if(PLACE=='select' && DATA[0] != opened_room_id) return false;
				if(PLACE=='score' && DATA[0] != opened_room_id) return false;
				}
			else{		
				if((PLACE == 'game' || PLACE == 'score') && (DATA[4] != 'game' && DATA[4] != 'score') ) return false;
				if(DATA[4]=='game' && PLACE != 'game') return false;
				if(DATA[4]=='score' && PLACE != 'score') return false;
				if((PLACE == 'game' || PLACE == 'score') && DATA[3] != MY_TANK.team) return false;
				}
			MAIN.chat(DATA[1], DATA[2], DATA[3], DATA[5]);
			MP.update_players_ping(DATA[2]);
			}
		else if(type == 'skill_advanced'){	//advanced skill, with delayed execution
			/*DATA = room_id, unit_id, {
					function: 'function_name',
					fparam: [param1, param2, param3],
					tank_params: [	{key: 'xxxx', value: 'xxxx'},	]
					}*/
			if(PLACE != "game" || opened_room_id != DATA[0]) return false;
			TANK = UNITS.get_tank_by_id(DATA[1]);
			if(TANK===false){
				console.log('Error: tank "'+DATA[1]+'" was not found on skill_advanced.');
				return false;
				}
			var skill_data = DATA[2];
			delete TANK.target_move_lock;
			//adding extra info to tank
			for(var i in skill_data.tank_params){
				var key = skill_data.tank_params[i].key;
				TANK[key] = skill_data.tank_params[i].value;
				}
			//executing function
			var function_name = skill_data.function;
			if(function_name != ''){
				if(skill_data.ai === true)
					AI[function_name](skill_data.fparam[0], skill_data.fparam[1], skill_data.fparam[2]);
				else
					SKILLS[function_name](skill_data.fparam[0], skill_data.fparam[1], skill_data.fparam[2]);
				}
			}
		else if(type == 'tank_update'){		//tank updates 
			//DATA = [tank_id, params]
			if(PLACE != "game") return false;
			TANK = UNITS.get_tank_by_id(DATA[0]);
			if(TANK===false){
				console.log('Error: tank "'+DATA[0]+'" was not found on tank_update.');
				return false;
				}
			//adding extra info to tank
			for(var i in DATA[1]){
				var key = DATA[1][i].key;
				var value = DATA[1][i].value;
				if(key == 'buffs')
					TANK.buffs.push(value);
				else if(value == 'delete')
					delete TANK[key];
				else if(key == 'attacking'){
					var enemy = UNITS.get_tank_by_id(value);
					TANK[key] = enemy;
					delete TANK.attacking_sig_wait;
					}
				else{
					//default
					TANK[key] = value;
					}
				}
			}
		else if(type == 'tank_kill'){	//tank was killed
			//DATA = room_id, player, killed_tank_id
			TANK_TO = UNITS.get_tank_by_id(DATA[2]);
			if(TANK_TO===false){
				if(DEBUG == true)
					console.log('Error: tank_to "'+DATA[2]+'" was not found on tank_kill.');
				return false;
				}
			TANK_FROM = UNITS.get_tank_by_id(DATA[1]);
			if(TANK_FROM===false){
				console.log('Error: tank_from "'+DATA[1]+'" was not found on tank_kill.');
				return false;
				}
			
			TANK_TO.deaths = TANK_TO.deaths + 1;
			TANK_TO.score = TANK_TO.score + SCORES_INFO[2];
			
			if(TYPES[TANK_TO.type].name == "Tower"){
				//change base stats
				for(var b in TANKS){
					if(TYPES[TANKS[b].type].name == "Base" && TANKS[b].team == TANK_TO.team){
						//armor debuff
						TANKS[b].buffs.push({
							name: 'shield',
							type: 'static',
							power: -10,
							});	
						}
					}
				}
			if(TYPES[TANK_TO.type].no_repawn != undefined || game_mode == 'single_craft' || game_mode == 'multi_craft'){	
				UNITS.check_selection(TANK_TO);
				//removing
				for(var b=0; b < TANKS.length; b++){
					if(TANKS[b].id==TANK_TO.id){	
						TANKS.splice(b, 1);  b--;
						break;
						}
					}
				}
			//adding kill stats
			UNITS.player_data[TANK_TO.nation].kills += 1;
			if(TYPES[TANK_TO.type].no_repawn == undefined || game_mode == 'single_craft' || game_mode == 'multi_craft'){
				//player
				if(TANK_TO.dead != 1)
					TANK_FROM.kills = TANK_FROM.kills + 1;
				//score
				TANK_FROM.score = TANK_FROM.score + SCORES_INFO[1];
				UNITS.death(TANK_TO);
				}
			//show kill message
			if(TANK_FROM.name != '')
				MAIN.chat(TANK_TO.name+" was killed by "+TANK_FROM.name+"!", false, false);
			}
		else if(type == 'level_up'){	//tank leveled up
			//DATA = room_id, player_id, level, xxxxxxxxxxxxx
			TANK_TO = UNITS.get_tank_by_id(DATA[1]);
			if(TANK_TO===false){	
				console.log('Error: tank_to "'+DATA[1]+'" was not found on level_up.');
				return false;
				}
			TANK_TO.level = DATA[2];
			TANK_TO.score = TANK_TO.score + SCORES_INFO[0];
			
			TANK_TO.abilities_lvl[DATA[3]]++;
			if(TANK_TO.id == MY_TANK.id)
				INFOBAR.draw_tank_abilities();
			
			//update passive abilites
			for(a in TYPES[TANK_TO.type].abilities){ 
				if(TYPES[TANK_TO.type].abilities[a].passive == false) continue;
				var nr = 1+parseInt(a);
				var ability_function = TYPES[TANK_TO.type].abilities[a].name.replace(/ /g,'_');
				if(ability_function != undefined){
					try{
						SKILLS[ability_function](TANK_TO);
						}
					catch(err){console.log("Error: "+err.message);}
					}
				}
			}
		else if(type == 'del_invisible'){	//remove invisibility
			//DATA = [player_id]
			TANK = UNITS.get_tank_by_id(DATA[0]);
			if(TANK===false){	
				console.log('Error: tank "'+DATA[0]+'" was not found on del_invisible.');
				return false;
				}
			SKILLS.stop_camouflage(TANK);
			}
		else if(type == 'summon_bots'){	//send bots
			//DATA = [room_id, random_id]
			UNITS.add_bots(DATA[1]);
			}
		else if(type == 'do_research'){	//research weapon/armor bonus
			//DATA = [nation, type, power]
			COUNTRIES[DATA[0]].bonus[DATA[1]] += DATA[2];
			}	
		else if(type == 'new_unit'){	//new unit was added
			if(DATA.mode == 'sync'){	
				if(DATA.team != MY_TANK.team)
					UNITS.add_tank(1, DATA.id, DATA.name, DATA.type, DATA.team, DATA.nation, DATA.x, DATA.y, DATA.angle);
				}
			else if(DATA.mode == 'craft'){
				var new_tank = UNITS.add_tank(1, DATA.id, DATA.name, DATA.type, DATA.team, DATA.nation, DATA.x, DATA.y, DATA.angle);
				UNITS.player_data[new_tank.nation].units++;
				new_tank.move = 1;
				//randomize spawn position
				new_tank.move_to = [
					DATA.move_x, 
					DATA.move_y,
					];
				}
			}		
		else if(type == 'bullet'){	//tank hit
			//DATA = [target_id, source_id, angle, damage, instant_bullet, pierce_armor, unit_x, unit_y]
			TANK_TO = UNITS.get_tank_by_id(DATA[0]);
			TANK = UNITS.get_tank_by_id(DATA[1]);
			if(TANK_TO===false){	
				console.log('Error: tank_to "'+DATA[0]+'" was not found on tank_hit.');
				return false;
				}
			if(TANK===false){
				if(DEBUG == true)
					console.log('Error: tank "'+DATA[1]+'" was not found on tank_hit.');
				return false;
				}
			MP.update_players_ping(TANK.name);
			
			//create bullet
			var tmp = new Array();
			tmp.x = TANK.cx();
			tmp.y = TANK.cy();
			tmp.bullet_to_target = TANK_TO; 
			tmp.bullet_from_target = TANK;
			tmp.angle = DATA[2];
			tmp.skill = 1;
			if(DATA[3] != undefined && DATA[3] != false)
				tmp.damage = DATA[3];
			if(DATA[4] != undefined && DATA[4] != false)
				tmp.instant_bullet = 1;
			if(DATA[5] != undefined && DATA[5] != false)
				tmp.pierce_armor = DATA[5];
			BULLETS.push(tmp);
			if(TYPES[TANK_TO.type].type != 'human') TANK.bullets++;
			
			//extra updates
			TANK.attacking = TANK_TO;
			if(DATA[2] != 0){
				UNITS.draw_fire(TANK, TANK_TO);
				if(TANK.id == MY_TANK.id)
					UNITS.shoot_sound(TANK);
				}
			//check sync
			var distance = UNITS.get_distance_between_tanks(TANK, TANK_TO);
			if(distance > MAX_BULLET_RANGE){
				//unit shooting from very far location - sync its position
				TANK.x = DATA[6];
				TANK.y = DATA[7];				
				}
			}	
		};
	//sending action to other players
	this.register_tank_action = function(action, room_id, player, data, data2, data3){	//lots of broadcasting
		if(action=='move')
			MP.send_packet('tank_move', [room_id, player, data]);
		else if(action=='skill_up')
			MP.send_packet('skill_up', [room_id, player, data]);
		else if(action=='skill_do')
			MP.send_packet('skill_do', [room_id, player, data, data2]);
		else if(action=='leave_game')
			MP.send_packet('leave_game', [room_id, player]);
		else if(action=='kick_player')
			MP.send_packet('kick_player', [room_id, player]);
		else if(action=='kick_player')
			MP.send_packet('leave_room', [room_id, player]);
		else if(action=='join_room')
			MP.send_packet('join_room', [room_id, player]);
		else if(action=='end_game')
			MP.send_packet('end_game', [room_id, data]);
		else if(action=='ask_rooms')
			MP.send_packet('ask_rooms', player);
		else if(action=='prepare_game')
			MP.send_packet('prepare_game', [room_id, player]);
		else if(action=='start_game')
			MP.send_packet('start_game', [room_id, data]);
		else if(action=='kill')
			MP.send_packet('tank_kill', [room_id, player, data]);
		else if(action=='skill_advanced')
			MP.send_packet('skill_advanced', [room_id, player, data]);
		else if(action=='level_up')
			MP.send_packet('level_up', [room_id, player, data, data2]);
		else if(action=='change_tank')
			MP.send_packet('change_tank', [room_id, data, player, data2]);
		else if(action=='leave_room'){
			for(var i=0; i < ROOMS.length; i++){
				if(ROOMS[i].id == room_id){
					if(room.host == player){
						//host leaving room
						MP.send_packet('delete_room', room_id);
						ROOMS.splice(i, 1);  i--;
						}
					else{
						//player leaving room
						MP.send_packet('leave_room', [room_id, player]);
						}
					}
				}
			}
		else if(action=='chat'){
			var text_limit = 100;
			if(PLACE == 'room')
				text_limit = 500;
			if(data.length > text_limit)
				data = data.substring(0, text_limit);
			var team = '';
			if(PLACE=='game')
				team = MY_TANK.team;
			if(data2 == false)
				MP.send_packet('chat', [room_id, data, player, team, PLACE]);
			else
				//with shift
				MP.send_packet('chat', [room_id, data, player, team, PLACE, 1]);
			}
		
		//error
		else
			alert('Error, unknown action ['+action+'] in MP.register_tank_action();');	
		};
	//new room was created
	this.register_new_room = function(room_name, mode, type, max_players, map, nation1, nation2, main_mode){
		var players = [];
		players.push({
			name: name,
			team: 'B',
			nation: nation1,
			ping: Date.now(),
			});
		
		room = {
			id: Math.floor(Math.random()*9999999),
			name: room_name,
			settings: [mode, type, map, main_mode],
			max: max_players,
			host: name,
			players: players,
			version: VERSION,
			nation1: nation1,
			nation2: nation2,
			};
		ROOMS.push(room);
		MP.send_packet('new_room', room);						//broadcast it
		return room.id;
		};
	//sync multiplayer data to local room data
	this.sync_multiplayers = function(){
		if(game_mode == 'multi_quick'){
			var room = ROOM.get_room_by_id(opened_room_id);
			for(var i in room.players){
				if(room.players[i].team != MY_TANK.team){	//if not me
					var nation = UNITS.get_nation_by_team(room.players[i].team);
					UNITS.add_tank(1, room.players[i].name, room.players[i].name, room.players[i].tank, room.players[i].team, nation);
					}
				}
			}
		else if(game_mode == 'multi_craft'){
			for(var i in TANKS){
				if(TANKS[i].team != MY_TANK.team) continue;
				var unit_data = {
					mode: 'sync',
					id: TANKS[i].id,
					name: TANKS[i].name,
					type: TANKS[i].type,
					team: TANKS[i].team,
					nation: TANKS[i].nation,
					x: TANKS[i].x,
					y: TANKS[i].y,
					angle: TANKS[i].angle,
					};
				MP.send_packet('new_unit', unit_data);
				}
			}
		};
	this.get_waiting_players_count = function(){
		return waiting_users;
		};
	this.update_players_ping = function(name){
		if(PLACE != 'game') return false;
		room = ROOM.get_room_by_id(opened_room_id);
		for(var p in room.players){
			if(room.players[p].name == name)
				room.players[p].ping = Date.now();
			}
		};
	this.disconnect_game = function(e){
		if(PLACE=='room' && (game_mode == 'multi_quick' || game_mode == 'multi_craft') ){
			if(confirm("Do you really want to leave this room?")==false){
				return false;
				}
			MP.register_tank_action('leave_room', opened_room_id, name);
			}
		if(PLACE=='game' && (game_mode == 'multi_quick' || game_mode == 'multi_craft') ){
			if(confirm("Do you really want to quit game???")==false){
				return false;
				}
			MP.register_tank_action('leave_game', opened_room_id, name);
			}
		};
	}
