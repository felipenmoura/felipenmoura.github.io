var BULLETS = new Array();		//tanks bullets array
var BULLETS_TYPES = new Array();	//bullets types config

BULLETS_TYPES.push({file: 'bullet',		size: [6, 6], 		speed: 999,	rotate: false, });
BULLETS_TYPES.push({file: 'small_bullet',	size: [4, 4], 		speed: 999,	rotate: false, });
BULLETS_TYPES.push({file: 'missle',		size: [8, 23], 		speed: 140,	rotate: true, });
BULLETS_TYPES.push({file: 'airstrike',		size: [38, 15], 	speed: 140,	rotate: true, });
BULLETS_TYPES.push({file: 'bomb',		size: [12, 12], 	speed: 120,	rotate: false, });
BULLETS_TYPES.push({file: 'plasma',		size: [15, 15], 	speed: 140,	rotate: false, });

/* //slow mode bullets
BULLETS_TYPES.push({file: 'bullet',		size: [6, 6], 		speed: 160,	rotate: false, });
BULLETS_TYPES.push({file: 'small_bullet',	size: [4, 4], 		speed: 160,	rotate: false, });
BULLETS_TYPES.push({file: 'missle',		size: [8, 23], 		speed: 140,	rotate: true, });
BULLETS_TYPES.push({file: 'airstrike',		size: [38, 15], 	speed: 140,	rotate: true, });
BULLETS_TYPES.push({file: 'bomb',		size: [12, 12], 	speed: 120,	rotate: false, });
BULLETS_TYPES.push({file: 'plasma',		size: [15, 15], 	speed: 140,	rotate: false, });
*/
