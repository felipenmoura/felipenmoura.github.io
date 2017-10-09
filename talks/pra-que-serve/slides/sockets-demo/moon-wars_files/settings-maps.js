var MAPS = new Array();			//maps config
var ELEMENTS = new Array();		//maps elements

//====== Maps elements =========================================================

ELEMENTS.push({	name: 'fence',	alt_color: '#4e4b44',	collission: true,	alpha: 1	});
ELEMENTS.push({	name: 'vfence',	alt_color: '#4e4b44',	collission: true,	alpha: 1	});
ELEMENTS.push({	name: 'hill',				collission: true,	alpha: 1	});
ELEMENTS.push({	name: 'rocks1',				collission: true,	alpha: 1	});
ELEMENTS.push({	name: 'rocks2',				collission: true,	alpha: 1	});
ELEMENTS.push({	name: 'bones',				collission: false,	alpha: 0.7	});
ELEMENTS.push({	name: 'crystals',			collission: false,	alpha: 0.8	});	

//====== Main ==================================================================

MAPS.push({
	name: "Main",
	width: 800,
	height: 1000,
	team_allies: 3,
	team_enemies: 3,
	description: "Default map balanced for all situations.",
	towers: [
			//team x,	 y, 	name
			['B',	400,	60,	'Base'],
			['B',	250,	150,	'Tower'],
			['B',	550,	150,	'Tower'],
			['B',	200,	350,	'Tower'],
			['B',	600,	350,	'Tower'],
			['R',	200,	650,	'Tower'],
			['R',	600,	650,	'Tower'],
			['R',	250,	850,	'Tower'],
			['R',	550,	850,	'Tower'],
			['R',	400,	940,	'Base'],
		],
	elements: [
			//name, 	x,	y,   max_width,	max_height
			['fence', 	100,	200,	50,	0],
			['fence', 	150,	200,	0,	0],
			['fence', 	250,	200,	0,	0],
			['fence', 	450,	200,	0,	0],
			['fence', 	550,	200,	0,	0],
			['fence', 	650,	200,	50,	0],
			['fence', 	100,	800,	50,	0],
			['fence', 	150,	800,	0,	0],
			['fence', 	250,	800,	0,	0],
			['fence', 	450,	800,	0,	0],
			['fence', 	550,	800,	0,	0],
			['fence', 	650,	800,	50,	0],
			['rocks1', 	-80,	410,	0,	0],
			['rocks2', 	-80,	490,	0,	0],
			['bones', 	420,	450,	0,	0],
			['hill', 	340,	10,	0,	0],
			['hill', 	340,	900,	0,	0],
			['crystals', 	100-20,	50-20,	0,	0],
			['crystals', 	700-20,	950-20,	0,	0],
			['crystals', 	90,	500-20,	0,	0],
			['crystals', 	750-20,	500-20,	0,	0],
		],
	roads: [
			//[width	[line/turn/curn x1,y1 x2,y2 (x3,y3 x4,y4)], [...], [...] ]
			[50, [['line', 400,200, 400,800]] ],
			[25, [['curve', 50,0, 50,350, 150,350, 150,500], ['curve', 150,500, 150,650, 50,650, 50,1000]] ],
		],
	bots: [
			['B',	35,	1,	[[5, 18],[25,50],[25,70],[5,82], [45,99]] ],
			['B',	50,	8,	[[50,99]] ],
			['B',	65,	1,	[[95,18],[75,50],[75,70],[95,82],[55,99]] ],
			['R',	35,	99,	[[5, 82],[25,50],[25,30],[5,18],[45,1]] ],
			['R',	50,	92,	[[50,1]] ],
			['R',	65,	99,	[[95,82],[75,50],[75,30],[95,18],[55,1]] ],
		],
	});

//====== Labyrinth =============================================================

MAPS.push({
	name: "Labyrinth",
	width: 800,
	height: 1000,
	team_allies: 3,
	team_enemies: 3,
	description: "Difficult map with lots of collisions. Beware of air units here! ",
	towers: [
			//team x,	 y, 	name
			['B',	400,	60,	'Base'],
			['B',	400,	150,	'Tower'],
			['B',	150,	250,	'Tower'],
			['R',	150,	750,	'Tower'],
			['R',	400,	850,	'Tower'],
			['R',	400,	950,	'Base'],
		],
	elements: [
			//name, 	x,	y,   max_width,	max_height
			['fence', 	0,	300,	0,	0],
			['fence', 	100,	300,	0,	0],
			['fence', 	200,	300,	0,	0],
			['fence', 	300,	300,	0,	0],
			['fence', 	400,	300,	0,	0],
			['fence', 	500,	300,	0,	0],
			['fence', 	600,	300,	0,	0],
			['fence', 	100,	500,	0,	0],
			['fence', 	200,	500,	0,	0],
			['fence', 	300,	500,	0,	0],
			['fence', 	400,	500,	0,	0],
			['fence', 	500,	500,	0,	0],
			['fence', 	600,	500,	0,	0],
			['fence', 	700,	500,	0,	0],
			['fence', 	0,	700,	0,	0],
			['fence', 	100,	700,	0,	0],
			['fence', 	200,	700,	0,	0],
			['fence', 	300,	700,	0,	0],
			['fence', 	400,	700,	0,	0],
			['fence', 	500,	700,	0,	0],
			['fence', 	600,	700,	0,	0],
			['bones', 	620,	400,	0,	0],
			['crystals', 	700-20,	50-20,	0,	0],
			['crystals', 	100-20,	950-20,	0,	0],
			['crystals', 	30,	260-20,	0,	0],
			['crystals', 	30,	740-20,	0,	0],
		],
	roads: [
			[25, [['line', 750,0, 750,300], ['curve', 750,300, 750,500, 50,300, 50,500], ['curve', 750,700, 750,500, 50,700, 50,500], ['line', 750,1000, 750,700]] ],
		],
	bots: [
			['B',	65,	5,	[[95,18],[95,40],[5, 40],[5, 60],[95,60],[95, 82],[50, 95]] ],
			['R',	65,	95,	[[95,82],[95,60],[5, 60],[5, 40],[95,40],[95, 18],[50, 5 ]] ],
		],
	});
	
//====== Decision ==================================================================

MAPS.push({
	name: "Decision",
	width: 800,
	height: 1000,
	team_allies: 3,
	team_enemies: 3,
	description: "Make a decision - attack from left, center or right, be careful - enemies can strike from all directions.",
	towers: [
			//team x,	 y, 	name
			//team x,	 y, 	name
			['B',	400,	60,	'Base'],
			['B',	300,	150,	'Tower'],
			['B',	500,	150,	'Tower'],
			['R',	300,	850,	'Tower'],
			['R',	500,	850,	'Tower'],
			['R',	400,	950,	'Base'],
		],
	elements: [
			//name, 	x,	y,   max_width,	max_height
			['vfence', 	150,	100,	0,	0],
			['vfence', 	150,	200,	0,	0],
			['vfence', 	150,	300,	0,	0],
			['vfence', 	150,	400,	0,	0],
			['vfence', 	150,	500,	0,	0],
			['vfence', 	150,	600,	0,	0],
			['vfence', 	150,	700,	0,	0],
			['vfence', 	150,	800,	0,	0],
			['vfence', 	650,	100,	0,	0],
			['vfence', 	650,	200,	0,	0],
			['vfence', 	650,	300,	0,	0],
			['vfence', 	650,	400,	0,	0],
			['vfence', 	650,	500,	0,	0],
			['vfence', 	650,	600,	0,	0],
			['vfence', 	650,	700,	0,	0],
			['vfence', 	650,	800,	0,	0],	
			['rocks1', 	300,	300,	0,	0],
			['rocks2', 	300,	550,	0,	0],
			['bones', 	0,	0,	0,	0],
			['bones', 	650,	900,	0,	0],
			['crystals', 	700-20,	50-20,	0,	0],
			['crystals', 	100-20,	950-20,	0,	0],
			['crystals', 	50-20,	480-20,	0,	0],
			['crystals', 	50-20,	520-20,	0,	0],	
			['crystals', 	80-20,	500-20,	0,	0],		
		],
	roads: [
			[50, [['line', 400,100, 400,300], ['line', 400,410, 400,550], ['line', 400,660, 400,890]] ],
		],
	bots: [
			['B',	50,	10,	[[30,30],[30,95],[50,95]] ],
			['B',	50,	10,	[[70,30],[70,95],[50,95]] ],
			['R',	50,	90,	[[30,70],[30,5],[50,5]] ],
			['R',	50,	90,	[[70,70],[70,5],[50,5]] ],
		],
	});	

//====== Mini ==================================================================

MAPS.push({
	name: "Mini",
	width: 800,
	height: 370,
	team_allies: 2,
	team_enemies: 2,
	description: "You, enemy, 4 towers, 2 bases and no time and space. Victory or defeat will come fast!",
	towers: [
			//team x,	 y, 	name
			['B',	60,	55,	'Base'],
			['B',	150,	50,	'Tower'],
			['B',	50,	160,	'Tower'],
			['R',	750,	210,	'Tower'],
			['R',	650,	320,	'Tower'],
			['R',	750,	320,	'Base'],
		],
	elements: [
			//name, 	x,	y,   max_width,	max_height
			['fence', 	0,	110,	0,	0],
			['fence', 	700,	240,	0,	0],
			['bones', 	330,	100,	0,	0],
			['bones', 	300,	150,	0,	0],
			['crystals', 	100,	90,	0,	0],
			['crystals', 	650,	220,	0,	0],
		],
	roads: [
			[25, [['line', 200,0, 200,370]] ],
			[25, [['line', 550,0, 550,370]] ],
			[50, [['line', 212,300, 538,300]] ],
		],
	bots: [
			['B',	25,	5,	[[95,20],[95,90]] ],
			['R',	75,	95,	[[5 ,80],[5 ,10]] ],
		],
	});
	
//====== Hell ==================================================================

MAPS.push({
	name: "Hell",
	width: 800,
	height: 600,
	team_allies: 1,
	team_enemies: 10,
	ground_only: true,
	mode: 'single_quick',
	singleplayer_only: true,
	description: "What the hell happened here? They are everywhere, heee... (signal lost)",
	towers: [
			//team x,	 y, 	name
			['B',	400,	60,	'Base'],
			['B',	420,	300,	'Tower'],
			['R',	400,	550,	'Base'],
		],
	elements: [
			//name, 	x,	y,   max_width,	max_height
			['fence', 	0,	300,	0,	0],
			['fence', 	100,	300,	0,	0],
			['fence', 	200,	300,	0,	0],
			['fence', 	300,	300,	0,	0],
			['fence', 	440,	300,	0,	0],
			['fence', 	540,	300,	0,	0],
			['fence', 	640,	300,	0,	0],
			['fence', 	740,	300,	60,	0],
			['bones', 	50,	500,	0,	0],
			['bones', 	700,	320,	0,	0],
			['rocks2', 	600,	480,	0,	0],
			['hill', 	340,	10,	0,	0],
			['crystals', 	50,	50,	0,	0],
			['crystals', 	500,	540,	0,	0],
		],
	roads: [
			[40, [['line', 420,130, 420,520]] ],
		],
	bots: [],
	});

//====== Huge ==================================================================

MAPS.push({
	name: "Huge",
	width: 1500,
	height: 2000,
	team_allies: 10,
	team_enemies: 10,
	description: "Huge area for epic battles only. Don't try to enter without big team - it will be too big for you.",
	towers: [
			//team x,	 y, 	name
			['B',	'rand',	60,	'Base'],
			['B',	150,	150,	'Scout_Tower'],
			['B',	1350,	150,	'Scout_Tower'],
			['B',	550,	430,	'Tower'],
			['B',	950,	430,	'Tower'],
			['B',	650,	640,	'Tower'],
			['B',	850,	640,	'Tower'],
			['B',	750,	950,	'Tower'],
			['R',	750,	1150,	'Tower'],
			['R',	650,	1360,	'Tower'],
			['R',	850,	1360,	'Tower'],
			['R',	550,	1570,	'Tower'],
			['R',	950,	1570,	'Tower'],
			['R',	150,	1850,	'Scout_Tower'],
			['R',	1350,	1850,	'Scout_Tower'],
			['R',	'rand',	1940,	'Base'],
		],
	elements: [
			//name, 	x,	y,   max_width,	max_height
			['fence', 	0,	1000,	0,	0],
			['fence', 	100,	1000,	0,	0],
			['fence', 	200,	1000,	0,	0],
			['fence', 	1200,	1000,	0,	0],
			['fence', 	1300,	1000,	0,	0],
			['fence', 	1400,	1000,	0,	0],
			['hill', 	1200,	1300,	0,	0],
			['rocks1', 	900,	700,	0,	0],
			['rocks2', 	200,	1100,	0,	0],
			['bones', 	1100,	200,	0,	0],
			['crystals', 	100-20,	150-20,	0,	0],
			['crystals', 	1400-20,150-20,	0,	0],
			['crystals', 	100-20,	1850-20,0,	0],
			['crystals', 	1400-20,1850-20,0,	0],
			['crystals', 	740-20,1000-20,	0,	0],
			['crystals', 	700-20,1000-20,	0,	0],
			['crystals', 	740-20,1040-20,	0,	0],
			['crystals', 	700-20,1040-20,	0,	0],
			['crystals', 	780-20,1000-20,	0,	0],
			['crystals', 	780-20,1040-20,	0,	0],
		],
	roads: [
			[100, [['line', 750,0, 750,2000]] ],
			[50, [['line', 0,500, 700,500]] ],
			[50, [['line', 800,1500, 1500,1500]] ],
		],
	bots: [],
	});
