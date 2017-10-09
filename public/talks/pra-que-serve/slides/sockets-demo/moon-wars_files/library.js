var LIBRARY = new LIBRARY_CLASS(); AI.check

function LIBRARY_CLASS(){	
	var TOP = 0;
	this.draw_library_list = function(next, type){
		PLACE = 'library';
		MAIN.unregister_buttons(PLACE);
		map_offset = [0, 0];
		var selected_color = "#196119";
		
		x = 10;
		y = 10;
		
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		
		//Units button
		width = 100;
		height = 30;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";		
		if(type == 'Units')
			canvas_backround.fillStyle = selected_color;
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			LIBRARY.draw_library_units();
			});
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		text = "Units";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		x = x + 100+10;
		
		//maps button
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";		
		if(type == 'Maps')
			canvas_backround.fillStyle = selected_color;
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			LIBRARY.draw_library_maps();
			});
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		text = "Maps";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		x = x + 100+10;
		
		//countries button
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";		
		if(type == 'Countries')
			canvas_backround.fillStyle = selected_color;
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			LIBRARY.draw_library_countries();
			});
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		text = "Countries";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		x = x + 100+10;
		
		//elements button
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#69a126";		
		if(type == 'Elements')
			canvas_backround.fillStyle = selected_color;
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			LIBRARY.draw_library_elements();
			});
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		text = "Elements";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		x = x + 100+10;
		
		//back button
		width = 80;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#c50000";
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			DRAW.last_selected = -1;
			MAIN.home(false);
			});
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Helvetica";
		text = "Back";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		
		TOP = y + height + 20;
		
		if(next == undefined)
			LIBRARY.draw_library_units();	
		};
	this.draw_library_units = function(selected_tank){
		LIBRARY.draw_library_list(false, 'Units');
		var y = TOP;
		var gap = 8;
		
		if(selected_tank==undefined) selected_tank = 0;
		//show all possible tanks
		j = 0;
		preview_x = 70;
		preview_y = 70;
		for(var i in TYPES){
			if(15+j*(preview_x+gap)+ preview_x > WIDTH_APP){
				y = y + preview_y+gap;
				j = 0;
				}
			//reset background
			var back_color = '';
			if(selected_tank != undefined && selected_tank == i)
				back_color = "#8fc74c"; //selected
			else
				back_color = "#dbd9da";
			canvas_backround.fillStyle = back_color;
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, 10+j*(preview_x+gap), y, preview_x, preview_y, 5, true);
			
			//logo
			var pos1 = 10+j*(preview_x+gap);
			var pos2 = y;
			var pos_left = pos1 + (preview_x-TYPES[i].size[1])/2;
			var pos_top = pos2 + (preview_y-TYPES[i].size[2])/2;
			if(TYPES[i].size[1] < preview_x && TYPES[i].size[2] < preview_y)
				UNITS.draw_tank_clone(i, pos_left, pos_top, 0, 1, canvas_backround);
			else{
				//image too big - draw only inside active zone
				canvas_backround.save();
				canvas_backround.beginPath();
				canvas_backround.rect(pos1, pos2, preview_x, preview_y);
				canvas_backround.clip();
				UNITS.draw_tank_clone(i, pos_left, pos_top, 0, 1, canvas_backround);
				canvas_backround.restore();
				}
			
			//register button
			MAIN.register_button(10+j*(preview_x+gap)+1, y+1, preview_x, preview_y, PLACE, function(mouseX, mouseY, index){
				//index;
				LIBRARY.draw_library_units(index);
				}, i);
			j++;
			}
		DRAW.last_selected = selected_tank;
		y = y + preview_y+gap;	
		
		//tank info block
		var info_left = 10;
		var info_block_height = HEIGHT_APP-27-y-10;
		var info_block_width = WIDTH_APP-20;
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.strokeStyle = "#196119";
		HELPER.roundRect(canvas_backround, info_left, y, info_block_width, info_block_height, 5, true);
	
		//tank stats
		if(selected_tank != undefined){
			var pos1 = info_left+10 + (preview_x-preview_x)/2;	
			var pos2 = y + round((info_block_height-preview_y)/2) + (preview_y-preview_y)/2;
			
			//hero	
			DRAW.draw_image(canvas_backround, TYPES[selected_tank].name, pos1, pos2);
			
			//name
			canvas_backround.font = "bold 18px Verdana";
			canvas_backround.fillStyle = "#196119";
			text = TYPES[selected_tank].name.replace("_"," ");
			text_width = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, info_left+preview_x+40, y+25);
			
			//description
			var text = '';
			for(var d in TYPES[selected_tank].description){
				text = text + TYPES[selected_tank].description[d];
				if(parseInt(d)+1 != TYPES[selected_tank].description.length)
					text = text + ", ";
				}
			canvas_backround.font = "bold 11px Verdana";
			canvas_backround.fillStyle = "#69a126";
			canvas_backround.fillText(text, info_left+preview_x+40+text_width+10, y+25);
			
			var height_space = 16;
			var st=0;
			var xx = info_left+preview_x+40;
			var value = [round(TYPES[selected_tank].damage[0]/TYPES[selected_tank].attack_delay), round(TYPES[selected_tank].damage[1]/TYPES[selected_tank].attack_delay*10)/10];
			LIBRARY.lib_show_stats("DPS", value, xx, y+50+st*height_space, 90, false, 9, 30); st++;
			LIBRARY.lib_show_stats("Life", TYPES[selected_tank].life, xx, y+50+st*height_space, 90, false, 100, 250); st++;
			LIBRARY.lib_show_stats("Armor", TYPES[selected_tank].armor, xx, y+50+st*height_space, 90, false, 0, 40); st++;
			LIBRARY.lib_show_stats("Speed", TYPES[selected_tank].speed, xx, y+50+st*height_space, 90, false, 20, 35); st++;
			LIBRARY.lib_show_stats("Range", TYPES[selected_tank].range, xx, y+50+st*height_space, 90); st++;
			LIBRARY.lib_show_stats("Scout", TYPES[selected_tank].scout, xx, y+50+st*height_space, 90); st++;
			LIBRARY.lib_show_stats("Turn speed", TYPES[selected_tank].turn_speed, xx, y+50+st*height_space, 90); st++;
			LIBRARY.lib_show_stats("Ignore armor", TYPES[selected_tank].ignore_armor, info_left+preview_x+40, y+50+st*height_space, 90); st++;
			//1st ability
			var value = "";
			if(TYPES[selected_tank].abilities[0] != undefined){
				function_name = TYPES[selected_tank].abilities[0].name.replace(/ /g,'_');
				value = TYPES[selected_tank].abilities[0].name + " - "+SKILLS[function_name]({abilities_lvl: [1,1,1], type: selected_tank}, true);
				}
			LIBRARY.lib_show_stats("1st ability", value, xx, y+50+st*height_space, 90, true); st++;
			//2nd ability
			var value = "";
			if(TYPES[selected_tank].abilities[1] != undefined){
				function_name = TYPES[selected_tank].abilities[1].name.replace(/ /g,'_');
				value = TYPES[selected_tank].abilities[1].name + " - "+SKILLS[function_name]({abilities_lvl: [1,1,1], type: selected_tank}, true);
				}
			LIBRARY.lib_show_stats("2nd ability", value, xx, y+50+st*height_space, 90, true); st++;
			//3rd ability
			var value = "";
			if(TYPES[selected_tank].abilities[2] != undefined){
				function_name = TYPES[selected_tank].abilities[2].name.replace(/ /g,'_');
				value = TYPES[selected_tank].abilities[2].name + " - "+SKILLS[function_name]({abilities_lvl: [1,1,1], type: selected_tank}, true);
				}
			LIBRARY.lib_show_stats("3rd ability", value, xx, y+50+st*height_space, 90, true); st++;
			LIBRARY.lib_show_stats("Cost", TYPES[selected_tank].cost+" HE-3", xx, y+50+st*height_space, 90); st++;
			}
		};
	this.draw_library_maps = function(){
		LIBRARY.draw_library_list(false, 'Maps');
		var y = TOP;
		var gap = 8;
		
		MAP.maps_positions = [];
		game_mode = 'single_quick';
		MAP.show_maps_selection(canvas_backround, y, true);
		y = y + 80 + 40;
		var active_map = MAPS[level-1];
		
		//tank info block
		var info_block_height = 150; //HEIGHT_APP-27-y-10;
		var info_block_width = WIDTH_APP-20;
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.strokeStyle = "#196119";
		HELPER.roundRect(canvas_backround, 10, y, info_block_width, info_block_height, 5, true);
		
		//name
		canvas_backround.font = "bold 18px Verdana";
		canvas_backround.fillStyle = "#196119";
		text = active_map.name;
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, 20, y+25);
		
		var height_space = 16;
		var st=0;
		LIBRARY.lib_show_stats("Description", active_map.description, 20, y+50+st*height_space, 90); st++;
		LIBRARY.lib_show_stats("Size", active_map.width+"x"+active_map.height+" px", 20, y+50+st*height_space, 90); st++;
		LIBRARY.lib_show_stats("Players", active_map.team_allies+" vs "+active_map.team_enemies, 20, y+50+st*height_space, 90); st++;
		LIBRARY.lib_show_stats("Total towers", active_map.towers.length, 20, y+50+st*height_space, 90); st++;
		LIBRARY.lib_show_stats("Bots groups", active_map.bots.length, 20, y+50+st*height_space, 90); st++;
		};
	this.lib_show_stats = function(name, value, x, y, gap, nobold, min_char_value, max_char_value){
		value_copy = value;
		//check
		if(value == undefined)		value = "-";
		if(typeof value == 'object')	value = value[0]+" + "+value[1];
		if(value == 1)			value = "Yes";
		//name
		canvas_backround.font = "normal 10px Verdana";
		canvas_backround.fillStyle = "#444444";
		canvas_backround.fillText(name, x, y);
		//value
		if(nobold !== true)
			canvas_backround.font = "bold 11px Verdana";
		else
			canvas_backround.font = "normal 11px Verdana";
		canvas_backround.fillStyle = "#196119";
		canvas_backround.fillText(value, x+gap, y);
		//chart
		if(max_char_value != undefined){
			value = value_copy;
			if(typeof value == 'object')	value = value[0];
			value = value - min_char_value;
			max_char_value = max_char_value - min_char_value;
			x = x + gap + 90;
			height = 5;
			var max_width = WIDTH_APP-x-20;
			width = round((value * max_width) / max_char_value);
			if(width<0) width = 0;
			if(width >= max_width){
				width = max_width;
				canvas_backround.fillStyle = "#c50000";					
				}
			else
				canvas_backround.fillStyle = "#69a126";
			canvas_backround.fillRect(x, y-height, width, height);
			}
		};
	this.draw_library_countries = function(selected_item){
		LIBRARY.draw_library_list(false, 'Countries');
		var y = TOP;
		var gap = 8;
		
		if(selected_item==undefined) selected_item = 0;
		//show list
		preview_x = 90;
		preview_y = 80;
		var j=0;
		var country;
		for(var i in COUNTRIES){
			if(selected_item == j)
				country = i;
			
			//reset background
			var back_color = '';
			if(selected_item == j)
				back_color = "#8fc74c"; //selected
			else
				back_color = "#dbd9da";
			canvas_backround.fillStyle = back_color;
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, 10+j*(preview_x+gap), y, preview_x, preview_y, 5, true);
			
			//logo
			var flag_size = IMAGES_SETTINGS.general[COUNTRIES[i].file];
			var pos1 = 10+j*(preview_x+gap) + round((preview_x-flag_size.w)/2);
			var pos2 = y + round((preview_y-flag_size.h)/2);
			DRAW.draw_image(canvas_backround, COUNTRIES[i].file, pos1, pos2);
			
			//name
			if(selected_item == j)
				canvas_backround.fillStyle = "#c10000"; //selected
			else
				canvas_backround.fillStyle = "#196119";
			canvas_backround.font = "bold 14px Helvetica";
			var letters_width = canvas_backround.measureText(COUNTRIES[i].name).width;
			var padding_left = Math.round((preview_x-letters_width)/2);
			canvas_backround.fillText(COUNTRIES[i].name, 10+j*(preview_x+gap)+padding_left, y+preview_y+gap+10);
			
			//register button
			MAIN.register_button(10+j*(preview_x+gap)+1, y+1, preview_x, preview_y, PLACE, function(mouseX, mouseY, index){
				//index;
				LIBRARY.draw_library_countries(index);
				}, j);
			j++;
			}
		y = y + preview_y+40;	
		
		//tank info block
		var info_left = 10;
		var info_block_height = 220; //HEIGHT_APP-27-y-10;
		var info_block_width = WIDTH_APP-20;
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.strokeStyle = "#196119";
		HELPER.roundRect(canvas_backround, info_left, y, info_block_width, info_block_height, 5, true);
	
		//stats
		
		//flag
		DRAW.draw_image(canvas_backround, COUNTRIES[country].file, info_left+10, y+13);
		
		//name
		canvas_backround.font = "bold 18px Verdana";
		canvas_backround.fillStyle = "#196119";
		text = COUNTRIES[country].name;
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, info_left+30, y+25);
		
		//description
		var height_space = 16;
		var st=0;
		var xx = info_left+10;
		LIBRARY.lib_show_stats("Description", COUNTRIES[country].description, xx, y+50+st*height_space, 90); st++;st++;
		for(var b in COUNTRIES[country].buffs){
			var title = "Changes";
			if(b!="0") title = '';
			var value = HELPER.ucfirst(COUNTRIES[country].buffs[b].name);
			value_tmp = round((COUNTRIES[country].buffs[b].power)*100-100);
			if(value_tmp > 0)
				value += ": +"+value_tmp+"%";
			else
				value += ": "+value_tmp+"%";
			LIBRARY.lib_show_stats(title, value, xx, y+50+st*height_space, 90); st++;
			}
		st++;
		LIBRARY.lib_show_stats("Weak point", COUNTRIES[country].cons, xx, y+50+st*height_space, 90, true); st++;
		LIBRARY.lib_show_stats("Unique unit", COUNTRIES[country].tank_unique, xx, y+50+st*height_space, 90); st++;
		LIBRARY.lib_show_stats("Locked units", COUNTRIES[country].tanks_lock.join(', '), xx, y+50+st*height_space, 90); st++;
		};
	this.draw_library_elements = function(selected_item){
		LIBRARY.draw_library_list(false, 'Elements');
		var y = TOP;
		var gap = 8;
		
		if(selected_item==undefined) selected_item = 0;
		//show list
		preview_x = 90;
		preview_y = 80;
		var j=0;
		var element;
		for(var i in ELEMENTS){
			if(selected_item == j)
				element = i;
			
			//reset background
			var back_color = '';
			if(selected_item == j)
				back_color = "#8fc74c"; //selected
			else
				back_color = "#dbd9da";
			canvas_backround.fillStyle = back_color;
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, 10+j*(preview_x+gap), y, preview_x, preview_y, 5, true);
			
			//logo
			element_w = IMAGES_SETTINGS.elements[ELEMENTS[i].name].w;
			element_h = IMAGES_SETTINGS.elements[ELEMENTS[i].name].h;
			var pos1 = 10+j*(preview_x+gap) + round((preview_x-element_w)/2);
			var pos2 = y + round((preview_y-element_h)/2);
			if(element_w < preview_x && element_h < preview_y)
				DRAW.draw_image(canvas_backround, ELEMENTS[i].name, pos1, pos2);
			else{
				//image too big - draw only inside active zone
				pos1 = 10+j*(preview_x+gap);
				pos2 = y;
				canvas_backround.save();
				canvas_backround.beginPath();
				canvas_backround.rect(pos1, pos2, preview_x, preview_y);
				canvas_backround.clip();
				DRAW.draw_image(canvas_backround, ELEMENTS[i].name, 
					pos1, pos2, Math.min(preview_x, element_w), Math.min(preview_y, element_h), 
					undefined, undefined, element_w, element_h);
				canvas_backround.restore();
				}
			
			//name
			if(selected_item == j)
				canvas_backround.fillStyle = "#c10000"; //selected
			else
				canvas_backround.fillStyle = "#196119";
			canvas_backround.font = "bold 14px Helvetica";
			var letters_width = canvas_backround.measureText(ELEMENTS[i].name).width;
			var padding_left = Math.round((preview_x-letters_width)/2);
			canvas_backround.fillText(ELEMENTS[i].name, 10+j*(preview_x+gap)+padding_left, y+preview_y+gap+10);
			
			//register button
			MAIN.register_button(10+j*(preview_x+gap)+1, y+1, preview_x, preview_y, PLACE, function(mouseX, mouseY, index){
				//index;
				LIBRARY.draw_library_elements(index);
				}, j);
			j++;
			}
		y = y + preview_y+40;	
		
		//info block
		var info_left = 10;
		var info_block_height = 150; //HEIGHT_APP-27-y-10;
		var info_block_width = WIDTH_APP-20;
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.strokeStyle = "#196119";
		HELPER.roundRect(canvas_backround, info_left, y, info_block_width, info_block_height, 5, true);
	
		//stats
		element_w = IMAGES_SETTINGS.elements[ELEMENTS[element].name].w;
		element_h = IMAGES_SETTINGS.elements[ELEMENTS[element].name].h;
		
		//flag
		DRAW.draw_image(canvas_backround, ELEMENTS[element].name, info_left+200, y+13);
		
		//name
		canvas_backround.font = "bold 18px Verdana";
		canvas_backround.fillStyle = "#196119";
		text = ELEMENTS[element].name;
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, info_left+30, y+25);
		
		//description	
		var height_space = 16;
		var st=0;
		var xx = info_left+10;
		LIBRARY.lib_show_stats("Collission", ELEMENTS[element].collission, xx, y+50+st*height_space, 90); st++;
		LIBRARY.lib_show_stats("Dimensions", element_w+"x"+element_h, xx, y+50+st*height_space, 90, true); st++;
		};
	}
