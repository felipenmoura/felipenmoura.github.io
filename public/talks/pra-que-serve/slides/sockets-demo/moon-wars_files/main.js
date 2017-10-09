/*
Name: Moon wars
Author: Vilius
Email: www.viliusl@gmail.com

TODO:
	easy/normal/hard/immposible
		in local only
		50% 100% 200% 300% hp
		icons?
*/

var MAIN = new MAIN_CLASS();
MAIN.home(true);

function MAIN_CLASS(){
	this.starting_timer=-1;
	this.IMAGE_BACK = new Image();
	this.IMAGE_LOGO = new Image();
	this.IMAGE_MOON = new Image();
	this.IMAGES_GENERAL = new Image();
	this.IMAGES_TANKS = new Image();
	this.IMAGES_BULLETS = new Image();
	this.IMAGES_ELEMENTS = new Image();
	this.IMAGES_INRO = new Image();
	this.intro_enabled = 1;			//if show intro
	this.enemy_nation;
	this.player_sync_done = false;
	var images_src_n = 7;			//images count to load, intro excluded
	var page_title_copy = 'Moon wars';	//copy of original title
	
	//init hello screen
	this.home = function(first_time){
		PLACE = 'init';
		MAIN.dynamic_title();
		CHAT_LINES = [];
		
		if(MP.socket_live == true)
			MP.room_controller();
		
		//sound effects
		var cookie = HELPER.getCookie("mute_fx");
		if(cookie == '0' || cookie == '')
			MUTE_FX = true;
		else{
			MUTE_FX = false;
			FX_VOLUME = cookie;
			}
		
		//music	
		var cookie = HELPER.getCookie("mute_music");
		if(cookie == '0' || cookie == '')
			MUTE_MUSIC = true;
		else{
			MUTE_MUSIC = false;
			MUSIC_VOLUME = cookie;
			}		
	
		if(DEBUG==true){
			MAX_SENT_PACKETS = 1000;
			START_GAME_COUNT = 5;
			}
			
		if(HELPER.getCookie("nointro") == '1')
			MAIN.intro_enabled = 0;
		level = 1;
		//set width and height
		if(first_time==true)
			MAIN.check_canvas_sizes();
		
		//detect sound extension, .ogg by default
		if(HELPER.isIE()==true)
			SOUND_EXT = '.mp3';
		
		//logo backround color
		canvas_backround.fillStyle = "#676767";
		canvas_backround.fillRect(0, 0, WIDTH_APP, HEIGHT_APP-27);
		//text
		var text = "Moon wars".split("").join(" ");
		canvas_backround.font = "Bold 70px Arial";
		canvas_backround.strokeStyle = '#ffffff';
		canvas_backround.strokeText(text, 160, 340);
		
		//button on logo
		MAIN.register_button((WIDTH_APP-598)/2, 15, 600, 266, PLACE, function(){
			if(MUTE_FX==false){
				var audio_fire = document.createElement('audio');
				audio_fire.setAttribute('src', '../sounds/shoot'+SOUND_EXT);
				audio_fire.volume = FX_VOLUME;
				audio_fire.play();
				}
			});
				
		if(first_time==true){
			MAIN.preload_all_files();
			if(chat_interval_id==undefined)
				chat_interval_id = setInterval(MAIN.controll_chat, 500);
			}
		if(preloaded==true)
			DRAW.add_first_screen_elements();
		};
	//start game
	this.start_game = function(map_nr, my_team){
		if(PLACE == 'game') return false;
		PLACE = 'game';
		MAIN.dynamic_title();
		MP.room_controller();
		CHAT_LINES = [];
		level = map_nr;
		if(my_tank_nr == -1)	my_tank_nr = 0;
		
		//prepare
		AI.init();
		MAIN.player_sync_done = false;
		MAIN.check_canvas_sizes();
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){
			enemy_nation_tmp = [];
			for(var n in COUNTRIES){
				if(n != my_nation) enemy_nation_tmp.push(n);
				}
			MAIN.enemy_nation = enemy_nation_tmp[HELPER.getRandomInt(0, enemy_nation_tmp.length-1)];
			}
		enemy_team = 'B';
		if(enemy_team == my_team) enemy_team = 'R';
		
		//me
		if(game_mode == 'single_quick'){
			if(MAPS[level-1].ground_only != undefined && TYPES[my_tank_nr].no_collisions==1)
				my_tank_nr = 0; //flying units not allowed in this map
			var my_id = TYPES[my_tank_nr].name+'-'+HELPER.getRandomInt(0, 999999);
			
			MY_TANK = UNITS.add_tank(1, my_id, name, my_tank_nr, my_team, my_nation);
			UNITS.add_towers(my_team, my_nation);
			UNITS.add_towers(enemy_team, MAIN.enemy_nation);
			}
		else if(game_mode == 'single_craft'){
			my_tank_nr = UNITS.get_unit_index('Soldier');
			mechanic_type = UNITS.get_unit_index('Mechanic');
			var my_id = TYPES[mechanic_type].name+'-'+HELPER.getRandomInt(0, 999999);
			
			MY_TANK = UNITS.add_tank(1, my_id, name, mechanic_type, my_team, my_nation);
			MY_TANK.selected = 1;
			UNITS.add_towers(my_team, my_nation);
			UNITS.add_towers(enemy_team, MAIN.enemy_nation);
			}
		else if(game_mode == 'multi_quick'){
			my_nation = UNITS.get_nation_by_team(my_team);
			MAIN.enemy_nation = UNITS.get_nation_by_team(enemy_team);
			var my_id = TYPES[my_tank_nr].name+'-'+HELPER.getRandomInt(0, 999999);
			
			MY_TANK = UNITS.add_tank(1, name, name, my_tank_nr, my_team, my_nation);
			UNITS.add_towers(my_team, my_nation);
			UNITS.add_towers(enemy_team, MAIN.enemy_nation);
			}
		else if(game_mode == 'multi_craft'){
			my_tank_nr = UNITS.get_unit_index('Soldier');
			mechanic_type = UNITS.get_unit_index('Mechanic');
			my_nation = UNITS.get_nation_by_team(my_team);
			MAIN.enemy_nation = UNITS.get_nation_by_team(enemy_team);
			var my_id = TYPES[mechanic_type].name+'-'+HELPER.getRandomInt(0, 999999);
			
			MY_TANK = UNITS.add_tank(1, my_id, name, mechanic_type, my_team, my_nation);
			MY_TANK.selected = 1;
			UNITS.add_towers(my_team, my_nation);
			}
		
		//my allies
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			UNITS.add_tank(1, TYPES[my_tank_nr].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), my_tank_nr, my_team, my_nation);
			UNITS.add_tank(1, TYPES[my_tank_nr].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), my_tank_nr, my_team, my_nation);
			UNITS.add_tank(1, TYPES[my_tank_nr].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), my_tank_nr, my_team, my_nation);
			}
		//enemies
		if(game_mode == 'single_craft'){
			UNITS.add_tank(1, TYPES[mechanic_type].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), mechanic_type, enemy_team, MAIN.enemy_nation, undefined, undefined, undefined, true);
			UNITS.add_tank(1, TYPES[my_tank_nr].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), my_tank_nr, enemy_team, MAIN.enemy_nation, undefined, undefined, undefined, true);
			UNITS.add_tank(1, TYPES[my_tank_nr].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), my_tank_nr, enemy_team, MAIN.enemy_nation, undefined, undefined, undefined, true);
			UNITS.add_tank(1, TYPES[my_tank_nr].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), my_tank_nr, enemy_team, MAIN.enemy_nation, undefined, undefined, undefined, true);
			}
		
		//add bots if single player
		if(game_mode == 'single_quick'){
			//get random type
			var possible_types = [];
			var random_type=0;
			for(var t in TYPES){
				if(TYPES[t].type != "tank") continue;
				if(TYPES[t].mode != undefined && TYPES[t].mode == 'craft') continue;
				possible_types.push(t);
				}
				
			//friends
			var n = MAPS[level-1].team_allies;
			for(var i=1; i<n; i++){
				random_type = possible_types[HELPER.getRandomInt(0, possible_types.length-1)];
				if(MAPS[level-1].ground_only != undefined && TYPES[random_type].no_collisions==1)
					continue;
				if(DEBUG==false){
					UNITS.add_tank(1, TYPES[random_type].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), random_type, my_team, my_nation, undefined, undefined, undefined, true);
					}
				}
			//enemies
			for(var i=0; i< MAPS[level-1].team_enemies; ){
				random_type = possible_types[HELPER.getRandomInt(0, possible_types.length-1)];
					//random_type = 3; //for testing
				if(MAPS[level-1].ground_only != undefined && TYPES[random_type].no_collisions==1)
					continue;
				UNITS.add_tank(1, TYPES[random_type].name+'-'+MAIN.get_unique_id(), HELPER.generatePassword(6), random_type, enemy_team, MAIN.enemy_nation, undefined, undefined, undefined, true);
				if(DEBUG==true) break;
				i++;
				}
			}
		
		MP.sync_multiplayers();
		MAIN.player_sync_done = true;
		UNITS.init_stats();
		
		//reset Research bonus
		for(var i in COUNTRIES){
			COUNTRIES[i].bonus.weapon = 0;
			COUNTRIES[i].bonus.armor = 0;
			}
		//handler for mini map
		MAIN.register_button(MINI_MAP_PLACE[0], HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+MINI_MAP_PLACE[1], MINI_MAP_PLACE[2], MINI_MAP_PLACE[3], 'game', function(xx, yy){ 
			MAP_SCROLL_CONTROLL = true; 
			INFOBAR.move_to_place(xx, yy);
			});
		if(game_mode == 'single_craft' || game_mode == 'multi_craft')
			MAP_SCROLL_MODE = 2;
			
		MAP.draw_map(false);
		MAP.auto_scoll_map();
	
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			//register crystals
			for(var e in MAPS[level-1].elements){
				if(MAPS[level-1].elements[e][0] != 'crystals') continue;
				var element = MAP.get_element_by_name(MAPS[level-1].elements[e][0]);
				MAP_CRYSTALS.push({
					id: HELPER.getRandomInt(0, 999999),
					x: MAPS[level-1].elements[e][1],
					y: MAPS[level-1].elements[e][2],
					cx: MAPS[level-1].elements[e][1] + IMAGES_SETTINGS.elements[element.name].w/2,
					cy: MAPS[level-1].elements[e][2] + IMAGES_SETTINGS.elements[element.name].h/2,
					w: IMAGES_SETTINGS.elements[element.name].w,
					h: IMAGES_SETTINGS.elements[element.name].h,
					power: CRYSTAL_POWER,
					});
				}
			//add flags
			for(var i in TANKS){
				if(TANKS[i].data.name != 'Base') continue;
				if(TANKS[i].team == 'B') //top
					TANKS[i].flag = { x: TANKS[i].cx(), y: TANKS[i].cy() + 100};
				else //bottom
					TANKS[i].flag = { x: TANKS[i].cx(), y: TANKS[i].cy() - 100};
				if(TANKS[i].flag.x < 100)		TANKS[i].flag.x = 100;
				if(TANKS[i].flag.x > WIDTH_MAP-100)	TANKS[i].flag.x = WIDTH_MAP-100;
				
				if(TANKS[i].team != MY_TANK.team && game_mode == 'single_craft')
					TANKS[i].use_AI = true;
				}
			}
		
		//detect draw mode support and init it
		var requestAnimationFrame = window.requestAnimationFrame 
					|| window.mozRequestAnimationFrame 
					|| window.webkitRequestAnimationFrame 
					|| window.msRequestAnimationFrame
					|| function(callback){ render_mode='setInterval'; setInterval(callback, 1000/25); };
		window.requestAnimationFrame = requestAnimationFrame;
		draw_interval_id = requestAnimationFrame(DRAW.draw_main);
		
		//start timed functions
		if(game_mode == 'single_quick' || game_mode == 'multi_quick')	
			bots_interval_id = setInterval(UNITS.add_bots, 1000*SOLDIERS_INTERVAl);
		level_hp_regen_id = setInterval(UNITS.level_hp_regen_handler, 1000);
		level_interval_id = setInterval(UNITS.tank_level_handler, 1000);
		timed_functions_id = setInterval(MAIN.timed_functions_handler, 100);
		
		//sound
		if(MUTE_MUSIC==false){
			audio_main = document.createElement('audio');
			audio_main.setAttribute('src', '../sounds/main'+SOUND_EXT);
			audio_main.setAttribute('loop', 'loop');
			audio_main.volume = MUSIC_VOLUME;
			try{
				audio_main.play();
				}
			catch(error){}
			}
		};
	//checks and resizes all canvas layers
	this.check_canvas_sizes = function(){
		if(FS==false){
			WIDTH_MAP = MAPS[level-1].width;
			HEIGHT_MAP = MAPS[level-1].height;
			WIDTH_APP = APP_SIZE_CACHE[0];
			HEIGHT_APP = APP_SIZE_CACHE[1];
			WIDTH_SCROLL = 800;
			if(WIDTH_MAP<800)
				WIDTH_SCROLL = WIDTH_MAP;
			HEIGHT_SCROLL = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT;
			parent.document.getElementById("main_iframe").style.paddingLeft = "0px";
			}
		else{
			//full screen
			var dimensions = HELPER.get_dimensions();
			//map
			WIDTH_MAP = MAPS[level-1].width;
			HEIGHT_MAP = MAPS[level-1].height;
			//app
			WIDTH_APP = dimensions[0];
			HEIGHT_APP = dimensions[1];
			if(WIDTH_APP > WIDTH_MAP)
				WIDTH_APP = WIDTH_MAP;
			if(WIDTH_APP < APP_SIZE_CACHE[0])
				WIDTH_APP = APP_SIZE_CACHE[0];	
			if(HEIGHT_APP > HEIGHT_MAP+INFO_HEIGHT+STATUS_HEIGHT)
				HEIGHT_APP = HEIGHT_MAP+INFO_HEIGHT+STATUS_HEIGHT;
			if(HEIGHT_APP < APP_SIZE_CACHE[1])
				HEIGHT_APP = APP_SIZE_CACHE[1];	
			//scroll
			WIDTH_SCROLL = dimensions[0];
			HEIGHT_SCROLL = HEIGHT_MAP;
			if(WIDTH_SCROLL > WIDTH_MAP)
				WIDTH_SCROLL = WIDTH_MAP;
			if(HEIGHT_SCROLL+INFO_HEIGHT+STATUS_HEIGHT > HEIGHT_APP)
				HEIGHT_SCROLL = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT;
			}
		//background
		document.getElementById("canvas_backround").width  = WIDTH_APP;
		document.getElementById("canvas_backround").height = HEIGHT_APP;
		//map
		document.getElementById("canvas_map").width  = WIDTH_MAP;
		document.getElementById("canvas_map").height = HEIGHT_MAP;
		
		//fog
		document.getElementById("canvas_fog").width  = WIDTH_MAP;
		document.getElementById("canvas_fog").height = HEIGHT_MAP;
		
		//map sight
		document.getElementById("canvas_map_sight").width  = WIDTH_SCROLL;
		document.getElementById("canvas_map_sight").height = HEIGHT_SCROLL;
		
		//objects
		canvas_base.width  = WIDTH_SCROLL;
		canvas_base.height = HEIGHT_SCROLL;
		//canvas_area
		document.getElementById("canvas_area").style.height = HEIGHT_APP+"px";
		document.getElementById("canvas_area").style.width = WIDTH_APP+"px";
		try{
			parent.document.getElementById("main_iframe").style.height = HEIGHT_APP+"px";
			parent.document.getElementById("main_iframe").style.width = WIDTH_APP+"px";
			//center screen
			if(WIDTH_MAP < dimensions[0]){
				var left_margin = round((dimensions[0] - WIDTH_APP)/2);
				parent.document.getElementById("main_iframe").style.paddingLeft = left_margin + "px";
				}
			}catch(error){}
		//chat elements
		document.getElementById("chat_write").style.top = (HEIGHT_APP-55)+"px";
		document.getElementById("chat_box").style.top = (HEIGHT_APP-175)+"px";
		};
	this.preload_all_files = function(){
		audio_to_preload = [
			'../sounds/click'+SOUND_EXT,
			'../sounds/main'+SOUND_EXT,
			'../sounds/shoot'+SOUND_EXT,
			'../sounds/metal'+SOUND_EXT,
			];
			
		//calculate files count
		preload_left = images_src_n + audio_to_preload.length;
		preload_total = preload_left;
		
		//preload images
		MAIN.IMAGE_BACK.onload = function(){ DRAW.update_preload(1); };		MAIN.IMAGE_BACK.src = '../img/background.jpg?'+VERSION;	
		MAIN.IMAGE_LOGO.onload = function(){ DRAW.update_preload(1); };		MAIN.IMAGE_LOGO.src = '../img/logo.png?'+VERSION;	
		MAIN.IMAGE_MOON.onload = function(){ DRAW.update_preload(1); };		MAIN.IMAGE_MOON.src = '../img/moon.jpg?'+VERSION;	
		MAIN.IMAGES_GENERAL.onload = function(){ DRAW.update_preload(1); };	MAIN.IMAGES_GENERAL.src = '../img/general.png?'+VERSION;	
		MAIN.IMAGES_TANKS.onload = function(){ DRAW.update_preload(1); };		MAIN.IMAGES_TANKS.src = '../img/tanks.png?'+VERSION;	
		MAIN.IMAGES_BULLETS.onload = function(){ DRAW.update_preload(1); };	MAIN.IMAGES_BULLETS.src = '../img/bullets.png?'+VERSION;	
		MAIN.IMAGES_ELEMENTS.onload = function(){ DRAW.update_preload(1); };	MAIN.IMAGES_ELEMENTS.src = '../img/elements.png?'+VERSION;
		
		//preload sound
		for(var i in audio_to_preload){
			MAIN.preload(audio_to_preload[i], 'audio');
			}
		};
	//preloading files	
	this.preload = function(file, type){	
		if(type=='image' || type==undefined){
			var imageObj = new Image();
			imageObj.onload = function(){
				DRAW.update_preload(10);	
				};
			imageObj.src=file;
			}
		else if(type=="audio"){	
			DRAW.update_preload(1);	//preload is buggy
			try{
				var audio_object = new Audio();
				audio_object.addEventListener('canplaythrough', function(event){	/*DRAW.update_preload(1);*/ }, false);
				audio_object.src = file;
				}
			catch(err){
				DRAW.update_preload(1);
				}
			
			}	
		else
			alert('Error, i can not preload ['+file+'], ['+type+'] type is not suported.');
		};
	//get unique id
	this.get_unique_id = function(){
		return HELPER.getRandomInt(0, 999999);
		};
	//tank moving speed conversion
	this.speed2pixels = function(speed, time_diff){
		return speed * 1.4 * time_diff/1000;
		};
	//repeat some functions in time
	this.timed_functions_handler = function(){
		//check map scrolling	//event.target.id
		if(PLACE == 'game' && MAP_SCROLL_MODE == 2 && Date.now() - mouse_last_move > 100 && mouse_inside == true){
			//move map if mouse in corners
			var gap = 50;
			var power = 50;
			if(mouse_pos[0] < gap)
				MAP.scoll_map(1, 0, power);	//left
			if(mouse_pos[0] > WIDTH_SCROLL - gap) 
				MAP.scoll_map(-1, 0, power);//right
			if(mouse_pos[1] < gap) 
				MAP.scoll_map(0, 1, power);	//up
			if(mouse_pos[1] > HEIGHT_SCROLL - gap) 
				MAP.scoll_map(0, -1, power);//down
			}
		INFOBAR.draw_ability_reuse();
		};
	//quit button - quits all possible actions
	this.quit_game = function(init_next_game){
		if(PLACE=='game' && (game_mode == 'multi_quick' || game_mode == 'multi_craft')){
			if(confirm("Do you really want to quit game?")==false)
				return false;
			}
		
		clearInterval(bots_interval_id);
		clearInterval(draw_interval_id);
		clearInterval(level_interval_id);
		clearInterval(level_hp_regen_id);
		clearInterval(timed_functions_id);	
		clearInterval(start_game_timer_id);
		//chrome bugfix
		clearInterval(chat_interval_id);	
		chat_interval_id = setInterval(MAIN.controll_chat, 500);
		
		canvas_fog.clearRect(0, 0, WIDTH_MAP, HEIGHT_MAP);	
		canvas_map_sight.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
		canvas_main.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
		canvas_map.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
		
		room_id_to_join = -1;
		MAIN.starting_timer = -1;
		MINES = [];
		TANKS = [];
		
		if(PLACE=='game'){
			pre_draw_functions = [];
					
			if(audio_main != undefined)
				audio_main.pause();
			
			if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
				MP.register_tank_action('leave_game', opened_room_id, name);
				MP.room_controller();
				}
		
			if(FS==true){
				fullscreen(false);
				PLACE = 'init';
				}
			}
		else if(PLACE == 'room'){
			if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && opened_room_id != -1){
				MP.register_tank_action('leave_room', opened_room_id, name);
				}
			opened_room_id = -1;
			}
		try{
			parent.document.getElementById("packets").innerHTML = "0/0";
			parent.document.getElementById("fps").innerHTML = "";	
			}catch(error){}
		
		//reset other variables
		ROOMS = [];
		PLAYERS = [];
		opened_room_id = -1;
		BULLETS = [];
		BUTTONS = [];
		opened_room_id = -1;
		CHAT_LINES = [];
		pre_draw_functions = [];
		mouse_click_controll = false;		log('504....');
		target_range = 0;
		INFOBAR.ABILITIES_POS = [];
		game_mode = 'single_quick';
		DRAW.last_selected = -1;
		my_tank_nr = -1;
		document.getElementById("chat_write").style.visibility = 'hidden';
		document.getElementById("chat_box").style.display = 'none';
		document.getElementById("popup").style.display="none";
		packets_used=0;
		packets_all=0;
		shift_pressed = false;
		chat_shifted=false;
		DRAW.frame_time = undefined;
		intro_page = 0;
		my_team = undefined;
		map_offset = [0, 0];
		target_mode = '';
		MAP_CRYSTALS = [];
		
		if(init_next_game != false)
			MAIN.home(false);
		};
	//register some are for mouse clicks
	this.register_button = function(x, y, width, height, place, myfunction, extra, type){
		for(var i in BUTTONS){
			if(BUTTONS[i].x == x && BUTTONS[i].y == y && BUTTONS[i].width == width && BUTTONS[i].height == height && BUTTONS[i].place == place){
				return false;
				}
			}
		BUTTONS.push({
			x: x,
			y: y,
			width: width,
			height: height,
			place: place,
			function: myfunction,
			extra: extra,
			type: type,
			});
		};
	this.unregister_buttons = function(button_place){
		for(var i=0; i<BUTTONS.length; i++){
			if(BUTTONS[i].place == button_place){
				BUTTONS.splice(i, 1); i--;
				}
			}
		};
	//timer in select screen
	this.starting_game_timer_handler = function(){
		MAIN.starting_timer--;
		DRAW.draw_timer_graph();
		
		//start game?
		if(MAIN.starting_timer==0){
			MAIN.starting_timer = -1;
			clearInterval(start_game_timer_id);
			if(game_mode != 'single_quick' && game_mode != 'single_craft'){
				room = ROOM.get_room_by_id(opened_room_id);
				if(room.host == name){
					room = ROOM.get_room_by_id(opened_room_id);
					MP.register_tank_action('start_game', opened_room_id, false, room.players);
					}
				}
			}
		};
	//save chat data
	this.chat = function(text, author, team, shift){
		if(text==undefined){
			//create
			var text = document.getElementById("chat_text").value;
			document.getElementById("chat_text").value = '';
			if(text=='') return false;
			author = name;
			if(PLACE=='game'){
				team = MY_TANK.team;
				}
			else
				team = '';	//shift
			
			if(PLACE=='rooms' || PLACE=='room' || ( (game_mode == 'multi_quick' || game_mode == 'multi_craft') && (PLACE=='select' || PLACE=='game' || PLACE == 'score'))){
				if(chat_shifted == false)
					MP.register_tank_action('chat', opened_room_id, name, text, 0);
				else
					MP.register_tank_action('chat', opened_room_id, name, text, 1);
				return false;
				}
			}
		if(text=='') return false;
		
		//save
		var time = new Date();
		time = time.getTime();
		
		var new_chat = {
			text: text,
			author: author,
			team: team,
			time: time,
			shift: shift,
			};
		CHAT_LINES.push(new_chat);
		if(CHAT_LINES.length > 17)
			CHAT_LINES.splice(0,1);	//remove first
		if(PLACE == 'room' || PLACE == 'rooms')
			DRAW.update_scrolling_chat(new_chat);
		};
	//controlls chat lines
	this.controll_chat = function(){
		if(CHAT_LINES.length==0) return false;
		
		//remove old
		var time = new Date();
		time = time.getTime();
		var max_time = 20000;	//20s
		if(PLACE != 'room'){
			for(var i=0; i < CHAT_LINES.length; i++){
				if(time - CHAT_LINES[i].time > max_time){
					CHAT_LINES.splice(i, 1); i--;
					}
				}
			}
		//show?
		if(PLACE == 'rooms' || PLACE == 'room' || PLACE == 'select'){
			canvas_main.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
			DRAW.show_chat();
			}
		};
	//dynamic title
	this.dynamic_title = function(data){
		try{
			if(page_title_copy=='') page_title_copy = parent.document.title;
			if(PLACE == 'rooms'){
				if(ROOMS.length==1)
					parent.document.title = page_title_copy + " ["+ROOMS.length+" room]";
				else if(ROOMS.length > 1)
					parent.document.title = page_title_copy + " ["+ROOMS.length+" rooms]";
				else
					parent.document.title = page_title_copy;
				}
			else if(PLACE == 'room'){
				room = ROOM.get_room_by_id(data);
				if(room.players.length==1)
					parent.document.title = page_title_copy + " ["+room.players.length+" player]";
				else
					parent.document.title = page_title_copy + " ["+room.players.length+" players]";
				}
			else{
				parent.document.title = page_title_copy;
				}
			}
		catch(err){
			console.log("Error: "+err.message);
			}
		};
	}
