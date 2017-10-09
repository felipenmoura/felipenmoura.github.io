//check support
if(document.getElementById("canvas_map").getContex==false) alert('Error, your browser does not support canvas.');
window.onscroll = function(){ window.scroll(0,0);}	//disable scroll-click

var ctrl_pressed = false;
var alt_pressed = false;
var shift_pressed = false;
var mouse_inside = true;
var chat_mode = 0;			//if 1, show textbox for writing

//=== keyboard =================================================================

function on_keyboard_action(event){
	k = event.keyCode;	//log(k);
	
	//shift
	if(k==16)
		shift_pressed = true; 
	//ctrl
	else if(k==17)
		ctrl_pressed = true; 
	//alt
	else if(k==18)
		alt_pressed = true;
	
	//add shortcuts
	if(PLACE == 'game'){
		if(MY_TANK.dead != 1 && chat_mode==0){
			if(k == 49 || k == 97 )
				UNITS.do_abilities(1, MY_TANK);	//special 1
			else if(k == 50 || k == 98)
				UNITS.do_abilities(2, MY_TANK);	//sepcial 2
			else if(k == 51 || k == 99)
				UNITS.do_abilities(3, MY_TANK);	//special 3
			else if(k == 38)
				MAP.scoll_map(0, 1);	//up
			else if(k == 40)
				MAP.scoll_map(0, -1); 	//down
			else if(k == 39)
				MAP.scoll_map(-1, 0);	//left
			else if(k == 37)
				MAP.scoll_map(1, 0); 	//right
			else if(k == 46){ 		//del
				if(MY_TANK.data.name != "Base"){
					if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
						if(MY_TANK.data.name != 'human')
							UNITS.player_data[MY_TANK.nation].he3 += round(MY_TANK.data.cost/2);
						}
					UNITS.do_damage(MY_TANK, MY_TANK, {damage: UNITS.get_tank_max_hp(MY_TANK), pierce_armor: 100});
					}
				}
			else if(k == 27){		//esc
				if(PLACE == 'game'){
					//stop move
					if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
						if(MY_TANK.move == 1)
							MP.register_tank_action('move', opened_room_id, MY_TANK.id, [round(MY_TANK.x), round(MY_TANK.y), round(MY_TANK.x), round(MY_TANK.y)]);
						}
					else
						MY_TANK.move = 0;
					//reset scroll
					if(MAP_SCROLL_MODE==2){
						MAP_SCROLL_MODE = 1;
						MAP.auto_scoll_map();
						}
					//
					if(mouse_click_controll == true){
						UNITS.prepare_tank_move(MY_TANK);
						delete MY_TANK.try_construct;
						mouse_click_controll = false;	log('70.');
						}
					}	
				}
			else if(k == 77){	//m
				if(DEBUG == true){
					//reveal map - base gets 9999 sight
					for(var i in TANKS){
						if(TANKS[i].data.name == 'Base'){
							if(TANKS[i].sight != 9999)
								TANKS[i].sight = 9999;
							else
								TANKS[i].sight = TANKS[i].data.scout + round(TANKS[i].width()/2);
							}
						TANKS[i].scouted = true;
						}
					}	
				}
			}
		if(k==9){				
			//TAB
			if(tab_scores==false)
				tab_scores=true;	
			else
				tab_scores=false;
			}
		if(k==85){
			//u
			ABILITIES_MODE++;
			if(ABILITIES_MODE>3) ABILITIES_MODE = 0;
			if(MY_TANK.abilities_lvl[ABILITIES_MODE-1]==MAX_ABILITY_LEVEL){
				ABILITIES_MODE++;
				if(MY_TANK.abilities_lvl[ABILITIES_MODE-1]==MAX_ABILITY_LEVEL){
					ABILITIES_MODE++;
					if(MY_TANK.abilities_lvl[ABILITIES_MODE-1]==MAX_ABILITY_LEVEL)
						ABILITIES_MODE++;
					}	
				}
			if(ABILITIES_MODE>3) ABILITIES_MODE = 0;
			INFOBAR.draw_tank_abilities();
			}
		}
	if(k==13){
		//enter
		if(PLACE=='rooms' || PLACE=='room' || PLACE=='game' || PLACE=='select'){
			if(chat_mode==0){
				//begin write
				chat_mode=1;
				document.getElementById("chat_write").style.visibility = 'visible';
				document.getElementById("chat_text").focus();
				if(shift_pressed==true)
					chat_shifted = true;
				else
					chat_shifted = false;
				}
			else{
				//end write
				chat_mode=0;
				document.getElementById("chat_write").style.visibility = 'hidden';
				MAIN.chat();
				}
			}
		}
	if(k==83 && chat_mode==0){
		//s
		if(MAP_SCROLL_MODE==1) MAP_SCROLL_MODE = 2;
		else{
			MAP_SCROLL_MODE = 1;
			MAP.auto_scoll_map();
			}
		}
	if(k == 27){	//esc
		if(PLACE == 'library' || PLACE == 'intro')
			MAIN.quit_game();
		}
	
	//disable some keys
	if(k >= 37 && k <= 40 && chat_mode != 1) return false;	//scroll with left, rigth, up and down
	if(k==9)	return false;	//TAB
	if(k==32 && chat_mode != 1) 	return false;	//space
		
	return true;
	}
//keyboard release
function on_keyboardup_action(event){
	k = event.keyCode;
	//shift
	if(k==16)
		shift_pressed = false; 
	//ctrl
	else if(k==17)
		ctrl_pressed = false; 
	//alt
	else if(k==18)
		alt_pressed = false; 
	}

//=== mouse scroll =============================================================

function MouseWheelHandler(e){
	var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
	if(PLACE != 'game') return true;
	
	//enable manual scroll
	if(MAP_SCROLL_MODE == 1)
		MAP_SCROLL_MODE = 2;
	
	//scroll	
	if(delta == 1)
		MAP.scoll_map(0, 1);
	else if(delta == -1)
		MAP.scoll_map(0, -1);
	
	//disable page scroll - dont worry, only on started game area
	e.preventDefault();
	return false;
	}

//=== mouse move ===============================================================

//mouse move on map
function on_mousemove(event){
	mouse_inside = true;
	mouse_last_move = Date.now();
	if(event.offsetX) {
		mouseX = event.offsetX;
		mouseY = event.offsetY;
		}
	else if(event.layerX) {
		mouseX = event.layerX;
		mouseY = event.layerY;
		}
	if(selection.drag == true){
		selection.x2 = mouseX;
		selection.y2 = mouseY;
		}
	//info about crystals
	if(PLACE == 'game' && (game_mode == 'single_craft' || game_mode == 'multi_craft')){
		INFOBAR.ability_hover_text = '';
		var found = false;
		for(var c in MAP_CRYSTALS){
			if(mouseX-map_offset[0] < MAP_CRYSTALS[c].x || mouseX-map_offset[0] > MAP_CRYSTALS[c].x + MAP_CRYSTALS[c].w) continue;
			if(mouseY-map_offset[1] < MAP_CRYSTALS[c].y || mouseY-map_offset[1] > MAP_CRYSTALS[c].y + MAP_CRYSTALS[c].h) continue;
			INFOBAR.ability_hover_text = MAP_CRYSTALS[c].power+"/"+CRYSTAL_POWER+" HE-3";
			INFOBAR.show_skill_description();
			found = true;
			break;
			}
		if(found == false){
			INFOBAR.ability_hover_text = '';
			INFOBAR.show_skill_description();
			}
		}
	mouse_pos = [mouseX, mouseY];
	}
function on_mousemove_background(event){
	mouse_inside = false;
	mouse_last_move = Date.now();
	if(event.offsetX) {
		mouseX = event.offsetX;
		mouseY = event.offsetY;
		}
	else if(event.layerX) {
		mouseX = event.layerX;
		mouseY = event.layerY;
		}
	mouse_pos = [mouseX, mouseY];
	//full screen fix
	if(FS==true){
		mouseX = mouseX - status_x;	
		mouseY = mouseY + APP_SIZE_CACHE[1] - HEIGHT_APP;
		}
	//settings actions
	if(PLACE == 'init'){
		if(preloaded==false)
			return false;
		var found = false;
		for (i in DRAW.settings_positions){
			if(mouseX > DRAW.settings_positions[i].x && mouseX < DRAW.settings_positions[i].x + DRAW.settings_positions[i].width){
				if(mouseY > DRAW.settings_positions[i].y && mouseY < DRAW.settings_positions[i].y + DRAW.settings_positions[i].height){
					//we have mouse over button
					DRAW.add_settings_buttons(canvas_backround, ["Single player"], i);
					found = true;
					}
				}
			}
		if(found == false)
			DRAW.add_settings_buttons(canvas_backround, ["Single player"], 99);		
		}
	if(PLACE=='game'){
		//mouse over abilities
		var new_i;
		for(var i=0; i < INFOBAR.ABILITIES_POS.length; i++){
			if(mouseX > INFOBAR.ABILITIES_POS[i].x && mouseX < INFOBAR.ABILITIES_POS[i].x + INFOBAR.ABILITIES_POS[i].width){
				if(mouseY > INFOBAR.ABILITIES_POS[i].y && mouseY < INFOBAR.ABILITIES_POS[i].y + INFOBAR.ABILITIES_POS[i].height){
					new_i = i;
					}
				}
			}
		if(new_i != INFOBAR.ability_hover_id){
			INFOBAR.ability_hover_id = new_i;
			if(new_i != undefined && TYPES[MY_TANK.type].abilities[new_i] != undefined){
				function_name = TYPES[MY_TANK.type].abilities[new_i].name.replace(/ /g,'_');
				INFOBAR.ability_hover_text = SKILLS[function_name](MY_TANK, true);
				}
			else
				INFOBAR.ability_hover_text = '';
			//renew
			INFOBAR.show_skill_description();	
			}
		//mouse over training tanks list
		if( (game_mode == 'single_craft' || game_mode == 'multi_craft') && MY_TANK.constructing == undefined){
			var ns = UNITS.get_selected_count(MY_TANK.team);
			if(TYPES[MY_TANK.type].name == 'Factory'){
				var stats = INFOBAR.draw_factory_gui(undefined, true);
				j=0;
				row=0;
				//units
				for(var i in TYPES){
					if(TYPES[i].type == 'building') continue;
					if(UNITS.check_nation_tank(TYPES[i].name, MY_TANK.nation)==false) continue;
					var xx = stats.pos1+j*(stats.msize+stats.gap);
					var yy = stats.pos2+row*(stats.msize+stats.gap);
					if(mouseX > xx && mouseX < xx + stats.msize){
						if(mouseY > yy && mouseY < yy + stats.msize){
							var name = TYPES[i].name.replace("_"," ");
							var cost = TYPES[i].cost;
							cost = UNITS.apply_buff(MY_TANK, 'cost', cost);
							INFOBAR.ability_hover_text = name+" - "+cost+" HE-3";
							}
						}
					
					j++;
					}
				//towers
				j=0;
				row=1;
				for(var i in TYPES){
					if(TYPES[i].type != 'building') continue;
					if(HELPER.strpos(TYPES[i].name, "ower")==false) continue;
					if(UNITS.check_nation_tank(TYPES[i].name, MY_TANK.nation)==false) continue;
					var xx = stats.pos1+j*(stats.msize+stats.gap);
					var yy = stats.pos2+row*(stats.msize+stats.gap);
					if(mouseX > xx && mouseX < xx + stats.msize){
						if(mouseY > yy && mouseY < yy + stats.msize){
							var name = TYPES[i].name.replace("_"," ");
							var cost = TYPES[i].cost;
							cost = UNITS.apply_buff(MY_TANK, 'cost', cost);
							INFOBAR.ability_hover_text = name+" - "+cost+" HE-3";
							}
						}
					
					j++;
					}
				}
			else if(TYPES[MY_TANK.type].name == 'Mechanic' && ns == 1){
				var stats = INFOBAR.draw_factory_gui(undefined, true);
				j=0;
				row=0;
				//towers
				for(var i in TYPES){
					if(TYPES[i].type != 'building') continue;
					
					var xx = stats.pos1+j*(stats.msize+stats.gap);
					var yy = stats.pos2+row*(stats.msize+stats.gap);
					if(mouseX > xx && mouseX < xx + stats.msize){
						if(mouseY > yy && mouseY < yy + stats.msize){
							var name = TYPES[i].name.replace("_"," ");
							var cost = TYPES[i].cost;
							cost = UNITS.apply_buff(MY_TANK, 'cost', cost);
							INFOBAR.ability_hover_text = name+" - "+round(cost)+" HE-3";
							}
						}
					
					j++;
					}
				}
			//renew
			INFOBAR.show_skill_description();
			}
		//mini map scrolling
		if(MAP_SCROLL_CONTROLL==true)
			INFOBAR.move_to_place(mouseX, mouseY);
		}		
	}
function on_mousemove_parent(event){
	if(FS == false)
		mouse_inside = false;
	}
	
//=== mouse right ==============================================================

var selection = false;
//mouse right click
function on_mouse_right_click(event){
	//mouse position
	if(event.offsetX) {
		mouseX = event.offsetX-map_offset[0];
		mouseY = event.offsetY-map_offset[1];
		}
	else if(event.layerX) {
		mouseX = event.layerX-map_offset[0];
		mouseY = event.layerY-map_offset[1];
		}
	if(PLACE == 'game'){
		if(mouse_click_controll == true){
			mouse_click_controll = false;		log('375.');
			}
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			for(var i in TANKS){
				if(TANKS[i].team != MY_TANK.team) continue;
				if(TANKS[i].data.name != "Factory" && TANKS[i].data.name != "Base") continue;
				if(TANKS[i].selected == undefined) continue;
				if(TANKS[i].flag != undefined){
					TANKS[i].flag.x = mouseX;
					TANKS[i].flag.y = mouseY;
					}
				}
			//move tank
			UNITS.draw_tank_move(mouseX, mouseY);
			}
		else
			AI.soldiers_move(mouseX, mouseY);
		}
	return false;
	}

//=== mouse click ==============================================================

function on_mousedown(event){
	//mouse position
	if(event.offsetX) {
		mouseX = event.offsetX;
		mouseY = event.offsetY;
		}
	else if(event.layerX) {
		mouseX = event.layerX;
		mouseY = event.layerY;
		}
	if(event.which != 3){	//not right click
		if(PLACE == 'game' && (game_mode == 'single_craft' || game_mode == 'multi_craft') && mouse_click_controll == false){
			selection = {
				x: mouseX, 
				y: mouseY,
				x2: mouseX,
				y2: mouseY,
				drag: true,
				};
			}
		}
	if(PLACE == 'game'){
		mouseX = mouseX-map_offset[0];
		mouseY = mouseY-map_offset[1];
		mouse_click_pos = [mouseX, mouseY];
	
		if(mouse_click_controll==true){
			SKILLS.do_missile(MY_TANK.id);
			SKILLS.do_bomb(MY_TANK.id);
			SKILLS.do_jump(MY_TANK.id);
			SKILLS.do_construct(MY_TANK.id);
			
			return true;
			}
	
		if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
			//move tank
			UNITS.draw_tank_move(mouseX, mouseY);
			}
		}
	else{
		menu_pressed = false;	
		for(var i in BUTTONS){
			if(BUTTONS[i].place != '' && BUTTONS[i].place != PLACE) continue;
			if(mouseX < BUTTONS[i].x || mouseX > BUTTONS[i].x+BUTTONS[i].width)  continue;
			if(mouseY < BUTTONS[i].y || mouseY > BUTTONS[i].y+BUTTONS[i].height)  continue;
			if(typeof BUTTONS[i].function == 'string')
				window[BUTTONS[i].function](mouseX, mouseY, BUTTONS[i].extra);
			else
				BUTTONS[i].function(mouseX, mouseY, BUTTONS[i].extra);
			break;
			}
		}
	}
//mouse click on background
function on_mousedown_back(event){
	if(event.offsetX) {
		mouseX = event.offsetX;
		mouseY = event.offsetY;
		}
	else if(event.layerX) {
		mouseX = event.layerX;
		mouseY = event.layerY;
		}
	menu_pressed = false;
	mouseX_old = mouseX;
	mouseY_old = mouseY;
	//full screen fix
	if(FS==true){
		mouseX = mouseX - status_x;	
		mouseY = mouseY + APP_SIZE_CACHE[1] - HEIGHT_APP;
		}
	for(var i in BUTTONS){
		if(BUTTONS[i]==undefined) continue;
		if(BUTTONS[i].place != '' && BUTTONS[i].place != PLACE) continue;
		if(BUTTONS[i].type != 'nofix'){
			if(mouseX < BUTTONS[i].x || mouseX > BUTTONS[i].x+BUTTONS[i].width)  continue;
			if(mouseY < BUTTONS[i].y || mouseY > BUTTONS[i].y+BUTTONS[i].height)  continue;
			}
		else{
			if(mouseX_old < BUTTONS[i].x || mouseX_old > BUTTONS[i].x+BUTTONS[i].width)  continue;
			if(mouseY_old < BUTTONS[i].y || mouseY_old > BUTTONS[i].y+BUTTONS[i].height)  continue;
			}
		if(typeof BUTTONS[i].function == 'string')
			window[BUTTONS[i].function](mouseX, mouseY, BUTTONS[i].extra);
		else
			BUTTONS[i].function(mouseX, mouseY, BUTTONS[i].extra);
		if(PLACE != 'game')
			break;
		}
	}
var last_click_time = Date.now();
//mouse click release
function on_mouseup(event){
	if(event.offsetX) {
		mouseX = event.offsetX-map_offset[0];
		mouseY = event.offsetY-map_offset[1];
		}
	else if(event.layerX) {
		mouseX = event.layerX-map_offset[0];
		mouseY = event.layerY-map_offset[1];
		}
	if(mouse_click_controll==true){
		selection.drag = false;
		return true;
		}
	if(event.which == 3) return true;	//right click release
	if(PLACE=='game'){
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			//select object
			var selected_n = 0;
			var last_selected_i; 
			if(selection.drag == true){
				selection.x2 = mouseX + map_offset[0];
				selection.y2 = mouseY + map_offset[1];
				if(Math.abs(selection.x - selection.x2) < 10 && Math.abs(selection.y - selection.y2) < 10)
					selection.drag = false;	
			
				//unselect?
				if(shift_pressed == false){
					for(var i in TANKS){
						if(TANKS[i].team != MY_TANK.team) continue;
						if(TYPES[TANKS[i].type].type == 'building') continue;
						if(TANKS[i].dead == 1) continue;
						if(TANKS[i].cx() + map_offset[0] < Math.min(selection.x, selection.x2) || TANKS[i].cx() + map_offset[0] > Math.max(selection.x, selection.x2) ) continue;
						if(TANKS[i].cy() + map_offset[1] < Math.min(selection.y, selection.y2) || TANKS[i].cy() + map_offset[1] > Math.max(selection.y, selection.y2) ) continue;
						for(var j in TANKS) delete TANKS[j].selected; //unselect all
						break
						}
					}
				//select area
				var redraw = false;
				for(var i in TANKS){
					if(TANKS[i].team != MY_TANK.team) continue;
					if(TYPES[TANKS[i].type].type == 'building') continue;
					if(TANKS[i].dead == 1) continue;
					if(TANKS[i].cx() + map_offset[0] < Math.min(selection.x, selection.x2) || TANKS[i].cx() + map_offset[0] > Math.max(selection.x, selection.x2) ) continue;
					if(TANKS[i].cy() + map_offset[1] < Math.min(selection.y, selection.y2) || TANKS[i].cy() + map_offset[1] > Math.max(selection.y, selection.y2) ) continue;
					TANKS[i].selected = 1;
					selected_n++;
					last_selected_i = i;
					redraw = true;
					}
				if(selected_n > 0)
					MY_TANK = TANKS[last_selected_i];
				if(redraw == true)
					INFOBAR.draw_infobar();
				}
			if(selection.drag == false){
				//select 1
				for(var i in TANKS){
					if(MY_TANK.team != TANKS[i].team) continue;
					if(TANKS[i].constructing != undefined) continue;
					if(Math.abs(TANKS[i].cx() - mouseX) < TANKS[i].width()/2 && Math.abs(TANKS[i].cy() - mouseY) < TANKS[i].height()/2){
						if(shift_pressed == false){
							for(var j in TANKS) delete TANKS[j].selected; //unselect all
							}
						TANKS[i].selected = 1;
						selected_n++;
						MY_TANK = TANKS[i];
						INFOBAR.draw_infobar();
						break;
						}
					}
				if(Date.now() - last_click_time < 300 && selected_n == 1){
					//double click - selecting all units with same type
					for(var i in TANKS){
						if(MY_TANK.team != TANKS[i].team) continue;
						if(MY_TANK.type != TANKS[i].type) continue;
						if(TANKS[i].constructing != undefined) continue;
						//if not in screen
						if(TANKS[i].y > -1*map_offset[1] + HEIGHT_SCROLL || TANKS[i].y+TANKS[i].height < -1*map_offset[1] || TANKS[i].x > -1*map_offset[0] + WIDTH_SCROLL || TANKS[i].x+TANKS[i].width < -1*map_offset[0]) continue;
						
						TANKS[i].selected = 1;
						}
					INFOBAR.draw_infobar();
					}
				}
			}
		selection.drag = false;
		}
	last_click_time = Date.now();
	}	
//mouse click release on background
function on_mouseup_back(event){
	if(PLACE=='game' && MAP_SCROLL_CONTROLL==true){
		MAP_SCROLL_CONTROLL=false;
		if(MAP_SCROLL_MODE==1)
			MAP.move_to_place_reset();
		}
	}

//=== fullscreen ===============================================================

function fullscreen(object){
	if(FS==false){
		//turn on
		var elem = document.getElementById(object);
		if (elem.requestFullscreen)
			elem.requestFullscreen();		//support in future
		else if(elem.mozRequestFullScreen)
			elem.mozRequestFullScreen();		//Firefox
		else if(elem.webkitRequestFullscreen)
			elem.webkitRequestFullscreen();	//chrome, safari
		}
	else{	
		//turn off							
		if (document.cancelFullscreen)
			document.cancelFullscreen();		//support in future
		else if(document.mozCancelFullScreen)
			document.mozCancelFullScreen();	//Firefox
		else if(document.webkitCancelFullScreen)
			document.webkitCancelFullScreen();	//chrome, safari*/
		}
	}
//on exit full screen
function full_screenchange_handler(event){
	if(document.fullscreen==true || document.mozFullScreen==true || document.webkitIsFullScreen==true){
		//turn on
		FS = true;
		if(PLACE == 'game'){
			MAIN.check_canvas_sizes();
			MAP.draw_map(false);
			}
		}
	if(document.fullscreen==false || document.mozFullScreen==false || document.webkitIsFullScreen==false){
		//turn off
		FS = false;
		if(PLACE == 'game'){
			MAIN.check_canvas_sizes();
			MAP.draw_map(false);
			}
		else if(PLACE == 'init'){
			MAIN.check_canvas_sizes();
			MAIN.home(false);
			}	
		}
	}

//=== popup ====================================================================

function popup_save(){
	document.getElementById("popup").style.display="none";
	var response={};
	inputs = document.getElementsByTagName('input');
	for (i = 0; i<inputs.length; i++) {
		if(inputs[i].id.substr(0,11)=='popup_data_'){
			var key = inputs[i].id.substr(11);
			var value = inputs[i].value;
			response[key] = value;
			}
		}
	selects = document.getElementsByTagName('select');
	for (i = 0; i<selects.length; i++) {
		if(selects[i].id.substr(0,11)=='popup_data_'){
			var key = selects[i].id.substr(11);
			var value = selects[i].value;
			response[key] = value;
			}
		}
	handler = document.getElementById("popup_handler").value;
	popup_active = false;
	if(handler != ''){
		handler = ""+handler;
		window[handler](response);
		}
	}
function popup(title, handler, settings, can_be_canceled){
	var html='';
	popup_active = true;
	
	html += '<h2>'+title+'</h2>';
	html += '<input type="hidden" id="popup_handler" value="'+handler+'" />';
	html += '<table style="width:99%;">';
	for(var i in settings){
		html += '<tr>';
		html += '<td style="font-weight:bold;padding-right:3px;">'+settings[i].title+'</td>';
		if(settings[i].name != undefined){
			if(settings[i].value != undefined)
				html += '<td><input style="width:100%;" type="text" id="popup_data_'+settings[i].name+'" value="'+settings[i].value+'" /></td>';
			else if(settings[i].values != undefined){
				html += '<td><select id="popup_data_'+settings[i].name+'">';
				for(var j in settings[i].values)
					html += '<option value="'+settings[i].values[j]+'">'+settings[i].values[j]+'</option>';
				html += '</select></td>';
				}
			}
		else	
			//locked fields
			html += '<td><input style="width:100%;color:#393939;padding-left:5px;" disabled="disabled" type="text" id="popup_data_'+settings[i].name+'" value="'+settings[i].value+'" /></td>';
		html += '</tr>';
		}
	html += '</table>';
	html += '<div style="text-align:center;margin-top:20px;">';
	html += '<input type="button" onclick="popup_save();" class="button" value="OK" />';
	if(can_be_canceled==undefined || can_be_canceled==true)
		html += '<input type="button" onclick="popup_active=false;document.getElementById(\'popup\').style.display=\'none\';" class="button" value="Cancel" />';
	html += '</div>';
		
	document.getElementById("popup").innerHTML = html;
	document.getElementById("popup").style.display="block";
	}
function update_name(user_response){
	name = user_response.name;
	name = name.toLowerCase().replace(/[^\w]+/g,'').replace(/ +/g,'-');
	if(name==''){
		var popup_settings=[];
		popup_settings.push({
			name: "name",
			title: "Enter your name:",
			value: name,
			});
		popup('Player name', 'update_name', popup_settings, false);
		return false;
		}
	name = name[0].toUpperCase() + name.slice(1);
	name = name.substring(0, 10);
	HELPER.setCookie("name", name, 30);
	if(PLACE == 'library')
		DRAW.draw_settings();
	}
