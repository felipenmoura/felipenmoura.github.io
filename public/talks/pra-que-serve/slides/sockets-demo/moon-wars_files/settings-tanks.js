var COUNTRIES = new Array();		//countries
var TYPES = new Array();		//tanks types config

COUNTRIES = {
	us: {
		name: 'United States', 
		file: 'us',
		description: 'Strong offensive country. High damage units per second will allow you to shine at offensive strategy.',
		pros: 'High damage units per second will allow you to shine at offensive strategy.',
		cons: 'Enemy mines',
		buffs: [
			{ name: 'damage',	power: 1.1, },
			],
		tanks_lock: ['Heavy', 'Miner', 'TRex'],
		tank_unique: 'Bomber',
		bonus: {weapon: 0, armor: 0},	//Research bonus, resets on start
		},
	ru: {
		name: 'Russia',
		file: 'ru',
		description: 'Defensive country. Units will excel at defence.',
		pros: 'Units will excel at defence.',
		cons: 'Issues in offensive strategy',
		buffs: [
			{ name: 'health',	power: 1.15,	},
			],
		tanks_lock: ['Cruiser', 'TRex', 'Bomber'],
		tank_unique: 'Heavy',
		bonus: {weapon: 0, armor: 0},
		},
	ch: {
		name: 'China', 
		file: 'ch',
		description: 'Rush-attack country.',
		pros: 'Excel at rush attacks.',
		cons: 'Units have less health.',
		buffs: [
			{ name: 'respawn',	power: 0.5, },
			{ name: 'speed',	power: 1.15,},
			{ name: 'health',	power: 0.9,	},
			{ name: 'cost',		power: 0.9,	},
			],
		tanks_lock: ['Heavy', 'Stealth', 'Bomber'],
		tank_unique: 'TRex',
		bonus: {weapon: 0, armor: 0},
		},
	};

//====== TANKS =================================================================

//Tiger
TYPES.push({
	name: 'Tiger',
	type: 'tank',					//values: tank, human, building
	description: ["Extreme damage", "Strong against slow enemies", "Light armor"],
	life: [210, 12],				//[tank life in level 0, life increase in each level]
	damage: [30, 1.5],	//30 dps		//[tank damage in level 0, damage increase in each level]
	range: 80, 					//tank shooting range
	scout: 110,					//tank scout range
	armor: [15, 0.5, 40],				//[tank armor in level 0, armor increase in each level, max armor]
	speed: 28,					//moving speed
	attack_delay: 1.05,				//pause between shoots in seconds
	turn_speed: 2.5,				//turn speed, higher - faster
	//no_repawn: 1,					//if tank dies - he will not respawn
	//no_collisions: 1,				//tank can go other walls and other tanks
	//bonus: 1,					//tank will be available only in single mode, random and mirror
	//flying: true,					//can fly
	//ignore_armor: 1,				//tank will ignore armor
	abilities: [					//name, active/passive, broadcast activation in multiplayer (0-no, 1-yes, 2-yes, but on later)
		{name: 'Blitzkrieg',	passive: false,		broadcast: 1},
		{name: 'Frenzy',	passive: false,		broadcast: 1}, 
		{name: 'AA Bullets',	passive: true,		broadcast: 1},
		],
	size: ['M', 50, 50],				//[tank size S/M/L (for radar), icon width and height]
	preview: true,					//tank preview image
	icon_top: true,					//tank base images
	icon_base: true,				//tank top images
	bullet: 'bullet',				//bullet_image
	fire_sound: 'shoot',				//shooting sound
	//mode: 'quick',				//if set, unit available only in quick/craft mode
	cost: 100,					//unit cost in full mode
	});

//Heavy
TYPES.push({
	name: 'Heavy',
	type: 'tank',
	description: ["Heavy armor, high defence", "Low damage", "Weak only against Stealth and Tiger"],
	life: [230, 12],
	damage: [15, 1],	//15 dps
	range: 80,
	scout: 110,
	armor: [40, 0.5, 65],
	speed: 25,
	attack_delay: 1.09,
	turn_speed: 2.5,
	abilities: [
		{name: 'Rest',		passive: false,		broadcast: 1}, 
		{name: 'Rage',		passive: false,		broadcast: 1}, 
		{name: 'Health',	passive: true,		broadcast: 1}, 
		],
	size: ['M', 50, 50],
	icon_top: true,
	icon_base: true,
	preview: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	cost: 60,
	});

//Cruiser
TYPES.push({
	name: 'Cruiser',
	type: 'tank',
	description: ["Fast scout", "Repair and damage boost for allies", "Light armor"],
	life: [180, 11],
	damage: [18, 1.3],	//18 dps
	range: 80,
	scout: 110,			
	armor: [20, 0.5, 45],
	speed: 30,
	attack_delay: 0.95,
	turn_speed: 3,
	abilities: [
		{name: 'Turbo',		passive: false,		broadcast: 1}, 
		{name: 'Repair',	passive: false,		broadcast: 0}, 
		{name: 'Boost',		passive: false,		broadcast: 0}, 
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: true,
	icon_base: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	cost: 70,
	});

//Launcher
TYPES.push({
	name: 'Launcher',
	type: 'tank',
	description: ["Long range attacks", "Slow"],
	life: [150, 10],
	damage: [15, 1.1],	//15 dps
	range: 100,
	scout: 120,
	armor: [10, 0, 10],
	speed: 25,
	attack_delay: 1.02,
	turn_speed: 2,
	abilities: [
		{name: 'Missile',	passive: false,		broadcast: 2}, 
		{name: 'Mortar',	passive: false,		broadcast: 2}, 
		{name: 'MM Missile',	passive: false,		broadcast: 2},
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: true,
	icon_base: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	cost: 60,
	});

//Stealth
TYPES.push({
	name: 'Stealth',
	type: 'tank',
	description: ["Camouflage", "Long range and huge damage", "Penetrates armor", "Slow speed and attack"],
	life: [150, 10],
	damage: [40, 2],	//20 dps
	range: 100,
	scout: 120,
	armor: [10, 0.2, 20],
	speed: 28,
	attack_delay: 1.92,
	turn_speed: 2,
	abilities: [
		{name: 'Strike',	passive: false,		broadcast: 2}, 
		{name: 'Camouflage',	passive: false,		broadcast: 1}, 
		{name: 'Scout',		passive: false,		broadcast: 0},
		],
	size: ['M', 50, 50],
	ignore_armor: 1,
	preview: true,
	icon_top: true,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	cost: 70,
	});

//Miner
TYPES.push({
	name: 'Miner',
	type: 'tank',
	description: ["Lands poweful mines", "Light armor", "Low tank damage"],
	life: [180, 11],
	damage: [15, 1],	//15 dps
	range: 80,
	scout: 110,
	armor: [20, 0.5, 45],
	speed: 28,
	attack_delay: 1.07,
	turn_speed: 3,
	abilities: [
		{name: 'Mine',		passive: false,		broadcast: 1}, 
		{name: 'Explode',	passive: false,		broadcast: 1}, 
		{name: 'SAM',		passive: false,		broadcast: 1}, 
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: true,
	icon_base: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	cost: 50,
	});

//Tech
TYPES.push({
	name: 'Tech',
	type: 'tank',
	description: ["Deactivates enemies", "Boosts team defence", "Light armor"],
	life: [150, 10],
	damage: [20, 1.4],	//20 dps
	range: 80,
	scout: 110,
	armor: [20, 0.5, 45],
	speed: 28,
	attack_delay: 1.08,
	turn_speed: 3,
	abilities: [
		{name: 'Virus',		passive: false,		broadcast: 2}, 
		{name: 'EMP Bomb',	passive: false,		broadcast: 2},
		{name: 'M7 Shield',	passive: false,		broadcast: 0},
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: true,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	cost: 50,
	});

//Truck
TYPES.push({
	name: 'Truck',
	type: 'tank',
	description: ["Uses elite soldiers for attack", "Low tank damage"],
	life: [150, 10],
	damage: [15, 1],	//15 dps
	range: 80,
	scout: 110,
	armor: [10, 0, 10],
	speed: 25,
	attack_delay: 1.03,
	turn_speed: 3,
	abilities: [
		{name: 'Fire bomb',	passive: false,		broadcast: 2}, 
		{name: 'Soldiers',	passive: false,		broadcast: 1}, 
		{name: 'Medicine',	passive: false,		broadcast: 0}, 
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: false,
	icon_base: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	mode: 'quick',
	cost: 0,
	});

//Mechanic	
TYPES.push({
	name: 'Mechanic',
	type: 'tank',
	description: ["Constructs, rebuilds and occupies enemy building", "Essential unit in Full mode"],
	life: [120, 10],
	damage: [10, 1],	//10 dps
	range: 80,
	scout: 110,
	armor: [10, 0, 10],
	speed: 25,
	attack_delay: 1.04,
	turn_speed: 3,
	abilities: [
		{name: 'Construct',	passive: true,		broadcast: 0}, 
		{name: 'Rebuild',	passive: true,		broadcast: 0}, 
		{name: 'Occupy',	passive: true,		broadcast: 0}, 
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: false,
	icon_base: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	mode: 'craft',
	cost: 30,
	});	

//TRex
TYPES.push({
	name: 'TRex',
	type: 'tank',
	description: ["Plasma shots", "Jumps", "Huge damage, low range", "Light armor"],
	life: [170, 11],
	damage: [20, 1.4],	//20 dps
	range: 40,
	scout: 100,
	armor: [30, 0.5, 55],
	speed: 28,
	attack_delay: 0.98,
	turn_speed: 3,
	abilities: [
		{name: 'Plasma',	passive: false,		broadcast: 2}, 
		{name: 'Jump',		passive: false,		broadcast: 2}, 
		{name: 'PL Shield',	passive: false,		broadcast: 1},
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: true,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	cost: 50,
	});

//Apache
TYPES.push({
	name: 'Apache',
	type: 'tank',
	description: ["Missiles", "Light armor", "Strong against all"],
	life: [180, 11],
	damage: [20, 1.3],	//20 dps
	range: 90,
	scout: 120,
	armor: [20, 0.5, 45],	
	speed: 32,
	attack_delay: 0.99,
	turn_speed: 3,
	//bonus: 1,
	no_collisions: 1,
	flying: true,
	abilities: [
		{name: 'Airstrike',	passive: false,		broadcast: 2}, 
		{name: 'Scout',		passive: false,		broadcast: 0}, 
		{name: 'AA Bullets',	passive: true,		broadcast: 1},
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: false,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	cost: 70,
	});

//Bomber
TYPES.push({
	name: 'Bomber',
	type: 'tank',
	description: ["Bombs", "Fast speed", "Low defence"],
	life: [150, 10],
	damage: [20, 1.3],	//20 dps
	range: 80,
	scout: 120,
	armor: [10, 0.2, 20],
	speed: 37,
	attack_delay: 1.01,
	turn_speed: 3,
	//bonus: 1,
	no_collisions: 1,
	flying: true,
	abilities: [
		{name: 'Bomb',		passive: false,		broadcast: 2}, 
		{name: 'AA bomb',	passive: false,		broadcast: 2}, 
		{name: 'Rest',		passive: false,		broadcast: 1},
		],
	size: ['M', 50, 50],
	preview: true,
	icon_top: false,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	cost: 60,
	});

//Soldier
TYPES.push({
	name: 'Soldier',
	type: 'human',
	description: ["Infantry", "No armor", "Low damage", "Supports tanks in battle"],
	life: [120, 6],
	damage: [11, 0.7],	//11 dps
	range: 70,
	scout: 100,
	armor: [0, 0, 0],
	speed: 25,
	attack_delay: 1.06,
	turn_speed: 4,
	no_repawn: 1,
	abilities: [],
	size: ['S', 20, 22],
	preview: true,
	icon_top: false,
	icon_base: true,
	bullet: 'small_bullet',
	fire_sound: 'shoot',
	cost: 30,
	});

//Tower
TYPES.push({
	name: 'Tower',
	type: 'building',
	description: ["Tower for defence"],
	life: [1200,0],
	damage: [30, 0],	//30 dps
	range: 110,
	scout: 130,
	armor: [20, 0, 20],
	speed: 0,
	attack_delay: 1.13,
	turn_speed: 2.5,
	no_repawn: 1,
	abilities: [
		{name: 'Freak out',		passive: false,		broadcast: 1}, 
		],
	size: ['L', 50, 50],
	preview: false,
	icon_top: true,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	attack_type: 'ground',
	cost: 80,
	});
	
//SAM Tower
TYPES.push({
	name: 'SAM_Tower',
	type: 'building',
	description: ["Tower for air defence"],
	life: [800,0],
	damage: [50, 0],	//40 dps
	range: 110,
	scout: 130,
	armor: [20, 0, 20],
	speed: 0,
	attack_delay: 1.15,
	turn_speed: 2.5,
	no_repawn: 1,
	abilities: [],
	size: ['L', 50, 50],
	preview: false,
	icon_top: true,
	icon_base: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	attack_type: 'air',
	cost: 60,
	});

//Scout Tower
TYPES.push({
	name: 'Scout_Tower',
	type: 'building',
	description: ["Tower for scouting"],
	life: [300,0],
	damage: [0, 0],	//0 dps
	range: 110,
	scout: 140,
	armor: [0, 0, 0],
	speed: 0,
	attack_delay: 999,
	turn_speed: 0,
	no_repawn: 1,
	abilities: [],
	size: ['L', 22, 20],
	preview: false,
	icon_top: true,
	icon_base: false,
	no_base_rotate: true,
	cost: 40,
	});

//Base
TYPES.push({
	name: 'Base',
	type: 'building',
	description: ["Main base"],
	life: [2500, 0],
	damage: [45, 0],	//45 dps
	range: 110,
	scout: 130,
	armor: [50, 0, 50],
	speed: 0,
	attack_delay: 1.12,
	turn_speed: 2.5,
	no_repawn: 1,
	abilities: [
		{name: 'Mechanic',		passive: false,		broadcast: 2}, 
		],
	size: ['L', 90, 90],
	preview: false,
	icon_top: false,
	icon_base: true,
	no_base_rotate: true,
	bullet: 'bullet',
	fire_sound: 'shoot',
	cost: 450,
	});

//Factory
TYPES.push({
	name: 'Factory',
	type: 'building',
	description: ["Tanks factory"],
	life: [800,0],
	damage: [0, 0],		//0 dps
	range: 0,
	scout: 90,
	armor: [0, 0, 0],
	speed: 0,
	attack_delay: 999,
	turn_speed: 0,
	no_repawn: 1,
	abilities: [
		{name: 'War units',	passive: true,		broadcast: 0,}, 
		{name: 'Towers',	passive: true,		broadcast: 0,},
		],
	size: ['L', 68, 56],
	preview: false,
	icon_top: false,
	icon_base: true,
	no_base_rotate: true,
	cost: 110,
	});

//Research
TYPES.push({
	name: 'Research',
	type: 'building',
	description: ["Research station"],
	life: [900,0],
	damage: [0, 0],		//0 dps
	range: 0,
	scout: 90,
	armor: [0, 0, 0],
	speed: 0,
	attack_delay: 999,
	turn_speed: 0,
	no_repawn: 1,
	abilities: [
		{name: 'Weapons',	passive: false,		broadcast: 1}, 
		{name: 'Armor',		passive: false,		broadcast: 1},
		],
	size: ['L', 50, 40],
	preview: false,
	icon_top: false,
	icon_base: true,
	no_base_rotate: true,
	cost: 145,
	});

//Silo
TYPES.push({
	name: 'Silo',
	type: 'building',
	description: ["Structure for generating Helium-3."],
	life: [300,0],
	damage: [0, 0],		//0 dps
	range: 0,
	scout: 50,
	armor: [0, 0, 0],
	speed: 0,
	attack_delay: 999,
	turn_speed: 0,
	no_repawn: 1,
	abilities: [],
	size: ['L', 46, 46],
	preview: false,
	icon_top: false,
	icon_base: true,
	no_base_rotate: true,
	cost: 50,
	});
