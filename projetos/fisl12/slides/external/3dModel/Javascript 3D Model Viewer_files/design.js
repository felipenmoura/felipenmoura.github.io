function ship(fillcolor, linecolor)
{
    
this.points=[[0,0,0],
[-193.121536,-44.568363,-0.251513],
[-197.573380,-46.895039,-0.256472],
[-198.788773,-49.016193,-0.257825],
[-148.971069,-47.449108,0.487985],
[-157.748093,-48.462933,0.901612],
[-175.811340,-47.449108,2.064319],
[-193.124741,-44.568363,2.280679],
[-197.576004,-46.915585,1.802589],
[-198.790024,-49.024815,0.736692],
[-148.971756,-48.138371,1.010340],
[-157.749634,-50.179447,2.127501],
[-175.814957,-50.343334,4.924728],
[-193.128799,-48.681034,5.467995],
[-197.579208,-49.064030,4.336096],
[-198.791382,-49.925770,1.799131],
[-148.971741,-48.358227,1.004796],
[-157.749634,-51.695354,2.115620],
[-175.814941,-53.750546,4.897006],
[-193.128754,-52.477642,5.437099],
[-197.579193,-52.081844,4.311542],
[-198.791382,-51.191311,1.788833],
[-148.970978,-48.512630,0.424875],
[-157.748047,-52.759968,0.872927],
[-175.811249,-56.143414,1.997388],
[-193.124695,-55.143978,2.206096],
[-197.575897,-54.201244,1.743308],
[-198.790009,-52.080090,0.711832],
[-148.970215,-48.511135,-0.201412],
[-157.746658,-52.749645,-0.211188],
[-175.808426,-56.120220,-0.231307],
[-193.121536,-55.118137,-0.251513],
[-197.573380,-54.180706,-0.256472],
[-198.788773,-52.071476,-0.257825],
[-175.835815,-44.020111,2.520835],
[-192.249237,-44.020111,0.089022],
[-149.033737,-40.512054,5.957043],
[-157.821075,-40.512054,4.856255],
[-175.834793,-40.512054,1.718337],
[-190.096756,-40.512054,-0.249265],
[-193.319107,-32.981995,-0.252854],
[-149.033737,-32.981995,5.965450],
[-157.821075,-32.981995,4.858928],
[-175.834793,-32.981995,1.718337],
[-157.822510,-22.686403,5.986545],
[-175.835815,-22.686403,2.520832],
[-203.319458,-22.686403,-0.263400],
[-149.035294,-22.686403,7.187805],
[-149.033951,-13.661487,12.976438],
[-157.822800,-13.239704,11.364350],
[-175.841217,-12.341414,8.138739],
[-218.859848,-9.932562,-0.279986],
[-157.820206,-44.109818,4.159561],
[-157.795929,-46.143688,2.892030],
[-149.015671,-46.054623,4.377612],
[-149.033737,-44.092472,5.954969],
[-114.731369,-47.455616,1.648514],
[-114.808830,-46.061138,7.371684],
[-114.840164,-44.098980,9.729299],
[-114.840332,-40.518570,9.851958],
[-114.840347,-32.988510,9.877554],
[-114.842636,-22.692911,11.680110],
[-114.833809,-14.981619,16.619209],
[-86.866638,-47.462948,4.298918],
[-86.945099,-46.068466,10.841274],
[-86.976799,-44.106312,13.504797],
[-86.978119,-40.525902,14.543481],
[-86.979042,-32.995842,15.279140],
[-86.981201,-22.700230,16.973080],
[-27.674036,-43.568142,21.946110],
[-44.549297,-33.003426,19.780952],
[-44.550179,-22.707819,20.497684],
[-21.460979,-18.288401,21.435612],
[-44.437195,-47.470531,9.048497],
[-44.514172,-46.076050,14.422836],
[-44.546265,-44.113895,17.389896],
[85.055260,-47.467136,9.566951],
[84.978310,-46.072659,14.941110],
[84.946236,-44.110508,17.908043],
[68.021347,-43.564747,22.548162],
[84.943199,-33.000031,20.298161],
[75.746201,-22.704430,21.009447],
[70.970001,-19.101204,21.930876],
[85.067299,-47.467136,0.059286],
[-45.041111,-40.533417,18.943781],
[84.944374,-40.796600,19.374630],
[82.226730,-42.588669,18.427174],
[-41.828033,-42.589798,18.166464],
[79.673470,-39.247772,19.470383],
[-39.277756,-39.248901,19.220474],
[102.918846,-19.467031,21.246489],
[122.860519,-44.293362,8.534363],
[122.756577,-43.026093,13.986779],
[122.713524,-41.242935,17.011076],
[122.711594,-38.231323,18.543358],
[122.710190,-31.145979,19.637127],
[122.709312,-22.913336,20.333622],
[154.601456,-35.084190,17.534193],
[154.600418,-28.227760,18.357895],
[154.669479,-24.790649,19.310398],
[149.794647,-18.465145,19.951303],
[154.749863,-40.412964,7.742351],
[154.646179,-39.298981,13.078783],
[154.603317,-37.731514,16.040014],
[122.866699,-44.293362,3.635928],
[120.642647,-47.466251,0.104404],
[165.723557,-39.503567,7.885768],
[165.619827,-38.426041,13.331938],
[165.576935,-36.909866,16.361908],
[165.575211,-34.349174,17.790897],
[165.574158,-27.696560,18.635632],
[165.644394,-24.514065,19.685810],
[165.632629,-23.205051,19.933445],
[153.361526,-20.990608,20.149113],
[218.698013,-23.197134,17.409588],
[218.859879,-23.206814,0.233417],
[217.906036,-34.818779,0.232852],
[217.897858,-34.818779,7.380709],
[217.795074,-34.083824,12.370145],
[218.003616,-33.049683,15.120919],
[218.221451,-31.303102,16.453737],
[218.704147,-24.170685,17.239691],
[26.770920,-18.608509,21.686554],
[34.043495,-18.608231,21.725981],
[34.098499,-18.608231,-21.703093],
[26.825840,-18.608509,-21.679869],
[218.743103,-24.170685,-16.773199],
[218.258591,-31.303102,-15.987810],
[218.037659,-33.049683,-14.655252],
[217.822861,-34.083824,-11.904680],
[217.914215,-34.818779,-6.915005],
[218.738449,-23.197134,-16.831234],
[153.410522,-20.990608,-19.848755],
[165.680908,-23.205051,-19.612167],
[165.692078,-24.514065,-19.364510],
[165.619278,-27.696560,-18.314417],
[165.618240,-34.349174,-17.469687],
[165.616501,-36.909866,-16.040697],
[165.651978,-38.426041,-13.010636],
[165.742432,-39.503567,-7.564241],
[122.875648,-44.293362,-3.422154],
[154.642868,-37.731514,-15.746773],
[154.678360,-39.298981,-12.785454],
[154.768753,-40.412964,-7.448800],
[149.843933,-18.465145,-19.663754],
[154.717194,-24.790649,-19.017067],
[154.645752,-28.227760,-18.064655],
[154.644730,-35.084190,-17.240952],
[122.760559,-22.913336,-20.120155],
[122.759674,-31.145979,-19.423656],
[122.758270,-38.231323,-18.329887],
[122.756340,-41.242935,-16.797607],
[122.791702,-43.026093,-13.773222],
[122.881859,-44.293362,-8.320590],
[102.972412,-19.467031,-21.056477],
[-39.228889,-39.248901,-19.358833],
[79.722641,-39.247772,-19.363771],
[-41.781818,-42.589798,-18.310507],
[82.273254,-42.588669,-18.314878],
[84.993301,-40.796600,-19.256279],
[-44.992966,-40.533417,-19.094976],
[71.025414,-19.101204,-21.829052],
[75.799278,-22.704430,-20.901999],
[84.994453,-33.000031,-20.179810],
[68.078354,-43.564747,-22.467506],
[84.991455,-44.110508,-17.789692],
[85.015999,-46.072659,-14.822695],
[85.079361,-47.467136,-9.448378],
[-44.502033,-44.113895,-17.539997],
[-44.477455,-46.076050,-14.572871],
[-44.414082,-47.470531,-9.198376],
[-21.406540,-18.288401,-21.558340],
[-44.498085,-22.707819,-20.647781],
[-44.499001,-33.003426,-19.931049],
[-27.618309,-43.568142,-22.058607],
[-86.937897,-22.700230,-17.226698],
[-86.940025,-32.995842,-15.532762],
[-86.940956,-40.525902,-14.797100],
[-86.942299,-44.106312,-13.758418],
[-86.917328,-46.068466,-11.094831],
[-86.855408,-47.462948,-4.552318],
[-114.791275,-14.981464,-16.945929],
[-114.812637,-22.692911,-12.006871],
[-114.814926,-32.988510,-10.204315],
[-114.814972,-40.518570,-10.178719],
[-114.815102,-44.098980,-10.056059],
[-114.789734,-46.061138,-7.698379],
[-114.726784,-47.455616,-1.975055],
[-149.018173,-44.092472,-6.357917],
[-149.004089,-46.054623,-4.780525],
[-157.788071,-46.143688,-3.314508],
[-157.809143,-44.109818,-4.582088],
[-175.820068,-12.341250,-8.601345],
[-157.793457,-13.239477,-11.786820],
[-149.000549,-13.661228,-13.379333],
[-149.016586,-22.686403,-7.590753],
[-175.828827,-22.686403,-2.983499],
[-157.806839,-22.686403,-6.409072],
[-175.829819,-32.981995,-2.181006],
[-157.808243,-32.981995,-5.281456],
[-149.018158,-32.981995,-6.368398],
[-175.829819,-40.512054,-2.181006],
[-157.808243,-40.512054,-5.278782],
[-149.018158,-40.512054,-6.359990],
[-192.248352,-44.020111,-0.590104],
[-175.828827,-44.020111,-2.983502],
[-198.787521,-52.080090,-1.227486],
[-197.570847,-54.201244,-2.256252],
[-193.118423,-55.143978,-2.709126],
[-175.805588,-56.143414,-2.460002],
[-157.745285,-52.759968,-1.295303],
[-148.969376,-48.512630,-0.827696],
[-198.786148,-51.191311,-2.304485],
[-197.567612,-52.081844,-4.824486],
[-193.114319,-52.477642,-5.940127],
[-175.801941,-53.750546,-5.359620],
[-157.743759,-51.695354,-2.537997],
[-148.968674,-48.358227,-1.407619],
[-198.786148,-49.925770,-2.314782],
[-197.567566,-49.064030,-4.849041],
[-193.114304,-48.681034,-5.971020],
[-175.801895,-50.343334,-5.387342],
[-157.743698,-50.179447,-2.549878],
[-148.968674,-48.138371,-1.413163],
[-198.787506,-49.024815,-1.252344],
[-197.570755,-46.915585,-2.315533],
[-193.118317,-44.568363,-2.783705],
[-175.805511,-47.449108,-2.526933],
[-157.745270,-48.462933,-1.323988],
[-148.969315,-47.449108,-0.890806],
[-80.094856,-16.366798,-20.192406],
[-80.145653,-16.366798,19.944675],
[-95.864258,-15.039927,6.206345],
[-107.467216,-15.004230,6.197975],
[-107.449020,-15.004153,-6.484835],
[-95.844170,-15.039933,-6.482594],
[-107.460655,-12.876587,6.197990],
[-107.442490,-12.876509,-6.484818],
[-95.837608,-12.912290,-6.482576],
[-95.857697,-12.912283,6.206361],
[-107.426102,-7.562058,-6.484778],
[-95.821220,-7.597838,-6.482538],
[-95.841347,-7.597833,6.206399],
[-107.444267,-7.562137,6.198030],
[-111.808311,-7.548680,6.191773],
[-111.824669,-12.863129,6.191733],
[-111.806503,-12.863051,-6.491072],
[-111.790115,-7.548601,-6.491032],
[71.006943,-19.101204,-7.242425],
[70.988472,-19.101204,7.344247],
[34.080170,-18.608231,-7.226748],
[34.061840,-18.608231,7.249640],
[-21.350143,-7.427763,-21.558270],
[26.882221,-7.747872,-21.679798],
[34.154896,-7.747593,-21.703022],
[34.136551,-7.747593,-7.226677],
[71.063339,-8.240566,-7.242352],
[71.081810,-8.240566,-21.828981],
[103.028801,-8.606395,-21.056404],
[102.975235,-8.606395,21.246561],
[71.026398,-8.240566,21.930946],
[71.044868,-8.240566,7.344320],
[34.118221,-7.747593,7.249712],
[34.099892,-7.747593,21.726053],
[26.827316,-7.747872,21.686625],
[-21.404583,-7.427763,21.435682],
[-23.850100,-6.966564,-20.859394],
[-23.902718,-6.966564,20.706121],
[-23.885199,-6.966564,6.850965],
[-23.867649,-6.966564,-7.004236],
[-23.533968,-2.682079,-20.858994],
[-23.551517,-2.682079,-7.003835],
[-23.569067,-2.682079,6.851367],
[-23.586586,-2.682079,20.706522],
[-74.120796,-6.574910,-20.294436],
[-78.092445,-9.487654,-20.191195],
[-77.228287,-6.505365,-17.084606],
[-76.912163,-2.220882,-17.084206],
[-73.804665,-2.290426,-20.294039],
[-77.271225,-6.505365,16.840353],
[-78.143242,-9.487654,19.945889],
[-74.171867,-6.574910,20.058041],
[-73.855736,-2.290426,20.058441],
[-76.955093,-2.220882,16.840754],
[-73.679039,5.593889,20.058668],
[-76.778397,5.663433,16.840981],
[-76.735466,5.663433,-17.083979],
[-73.627968,5.593889,-20.293812],
[-56.149837,5.202236,-20.878201],
[-56.167385,5.202236,-7.023045],
[-56.184937,5.202236,6.832156],
[-56.202484,5.202236,20.687315],
[-56.003712,5.197935,15.158989],
[-23.387844,-2.686375,15.178197],
[-73.656967,-2.294722,14.530116],
[-73.480301,5.589588,14.530342],
[-73.443222,5.589582,-14.765001],
[-73.619888,-2.294727,-14.765227],
[-23.349226,-2.686380,-15.330184],
[-55.965096,5.197929,-15.349392],
[-56.083004,8.968954,-7.022938],
[-56.100555,8.968954,6.832263],
[-56.118073,8.968954,20.687424],
[-73.594658,9.360607,20.058777],
[-76.694016,9.430149,16.841087],
[-76.651085,9.430149,-17.083872],
[-73.543587,9.360607,-20.293705],
[-56.065456,8.968954,-20.878098],
[-66.006950,9.264441,-5.180267],
[-58.864384,9.104385,-5.312379],
[-58.883072,9.104385,5.108154],
[-66.025131,9.264441,4.962180],
[-59.995365,18.266634,3.180750],
[-64.496681,18.367502,3.088750],
[-64.485199,18.367502,-3.303547],
[-59.983597,18.266634,-3.386811],
[-7.724119,-7.281446,8.517172],
[-10.812283,-7.268494,11.267529],
[-4.621579,-7.351016,11.657533],
[-1.441457,15.301786,6.471271],
[-3.377544,15.345182,4.909741],
[-4.602257,-7.351017,-11.754386],
[-10.793686,-7.268492,-11.383029],
[-7.710023,-7.281446,-8.627288],
[-3.362122,15.345030,-4.995567],
[-1.426647,15.301691,-6.548023],
[11.589803,-7.713856,-8.758033],
[14.679115,-7.726812,-11.518564],
[8.487137,-7.644284,-11.843060],
[5.824824,15.139219,-6.555085],
[7.739266,15.096296,-5.033173],
[8.467769,-7.644286,11.802110],
[14.660228,-7.726815,11.496260],
[11.575425,-7.713856,8.730344],
[7.723810,15.096468,4.981758],
[5.810102,15.139311,6.494761],
[9.661969,15.053129,-0.018312],
[-5.251101,15.387262,-0.050158],
[2.211564,15.220198,-7.492658],
[2.199291,15.220198,7.424184],
[-8.148654,15.301786,-9.292356],
[-4.536936,15.301786,-12.189340],
[2.252211,15.301786,-13.952092],
[8.994812,15.301786,-12.202518],
[12.567273,15.301786,-9.362534],
[16.155155,15.301786,-0.004471],
[12.538436,15.301786,9.325991],
[8.967335,15.301786,12.149354],
[2.229321,15.301786,13.883718],
[-4.564579,15.301786,12.105520],
[-8.177430,15.301786,9.191602],
[-11.673625,15.301786,-0.063898],
[-4.564579,25.331264,12.105520],
[-8.177430,25.331264,9.191602],
[-11.673625,25.331264,-0.063897],
[-8.148654,25.331264,-9.292356],
[-4.536936,25.331264,-12.189340],
[2.252211,25.331264,-13.952092],
[8.994812,25.331264,-12.202518],
[12.567273,25.331264,-9.362534],
[16.155155,25.331264,-0.004471],
[12.538436,25.331264,9.325991],
[8.967335,25.331264,12.149354],
[2.229321,25.331264,13.883718],
[11.696464,25.331264,4.060451],
[10.309690,25.331264,5.156854],
[7.380241,25.331264,5.910896],
[4.424797,25.331264,5.137356],
[3.015162,25.331264,4.000420],
[1.487361,25.331264,-0.044122],
[3.027532,25.331264,-4.076335],
[4.436466,25.331264,-5.206450],
[7.389619,25.331264,-5.973214],
[10.321282,25.331264,-5.212503],
[11.708874,25.331264,-4.109426],
[13.277449,25.331264,-0.018191],
[10.321282,27.999378,-5.212503],
[11.708874,27.999378,-4.109426],
[13.277449,27.999378,-0.018191],
[11.696464,27.999378,4.060451],
[10.309690,27.999378,5.156854],
[7.380241,27.999378,5.910896],
[4.424797,27.999378,5.137356],
[3.015162,27.999378,4.000420],
[1.487361,27.999378,-0.044122],
[3.027532,27.999378,-4.076335],
[4.436466,27.999378,-5.206450],
[7.389619,27.999378,-5.973214],
[7.370870,56.143414,-0.031196],
[7.376258,27.999371,-1.219594],
[7.962594,27.999371,-1.067451],
[6.785621,27.999371,-1.066240],
[6.503841,27.999371,-0.840218],
[6.195807,27.999371,-0.033775],
[6.501358,27.999371,0.775133],
[6.783297,27.999371,1.002521],
[7.374376,27.999371,1.157228],
[7.960266,27.999371,1.006421],
[8.237617,27.999371,0.787140],
[8.553820,27.999371,-0.028589],
[8.240097,27.999371,-0.846836],
[73.408287,-8.258724,-19.460375],
[100.696426,-8.588238,-18.765371],
[100.648666,-8.588238,18.950254],
[73.358879,-8.258724,19.567587],
[73.374352,-8.258724,7.347268],
[73.392822,-8.258724,-7.239404],
[73.375023,-6.187043,19.567604],
[73.390511,-6.187043,7.347289],
[73.408966,-6.187043,-7.239382],
[73.424431,-6.187043,-19.460354],
[100.712578,-6.516557,-18.765354],
[100.664818,-6.516557,18.950272],
[71.097954,-6.168886,-21.828964],
[103.044952,-6.534715,-21.056387],
[102.991386,-6.534715,21.246578],
[71.042557,-6.168886,21.930964],
[71.061028,-6.168886,7.344340],
[71.079483,-6.168886,-7.242332],
[71.109116,2.369425,21.931049],
[71.127586,2.369425,7.344425],
[71.146042,2.369425,-7.242248],
[71.164513,2.369425,-21.828878],
[103.111481,2.003595,-21.056303],
[103.057915,2.003595,21.246662],
[106.177406,1.943451,-21.049290],
[106.110878,-6.594859,-21.049376],
[106.057304,-6.594859,21.253593],
[106.123833,1.943451,21.253679]];


this.faces=[[212,206,33,27,21,15,9,3,224,218],
[7,1,2,8],
[2,3,9,8],
[4,5,11,10],
[5,6,12,11],
[6,7,13,12],
[7,8,14,13],
[8,9,15,14],
[10,11,17,16],
[11,12,18,17],
[12,13,19,18],
[13,14,20,19],
[14,15,21,20],
[16,17,23,22],
[17,18,24,23],
[18,19,25,24],
[19,20,26,25],
[20,21,27,26],
[22,23,29,28],
[23,24,30,29],
[24,25,31,30],
[25,26,32,31],
[26,27,33,32],
[223,229,4,10,16,22,28,211,217],
[48,194,193,192,51,50,49],
[7,6,34,35],
[226,1,7,35,204],
[118,117,116,115,114,121,120,119],
[5,4,54,53],
[53,34,6,5],
[52,55,36,37],
[34,52,37,38],
[39,204,35],
[37,36,41,42],
[38,37,42,43],
[39,38,43,40],
[39,35,34,38],
[43,42,44,45],
[40,43,45,46],
[42,41,47,44],
[44,47,48,49],
[45,44,49,50],
[46,45,50,51],
[52,34,53],
[53,54,55,52],
[4,229,187,56],
[54,4,56,57],
[55,54,57,58],
[36,55,58,59],
[41,36,59,60],
[47,41,60,61],
[48,47,61,62],
[194,48,62,181],
[63,56,187,180],
[57,56,63,64],
[58,57,64,65],
[59,58,65,66],
[60,59,66,67],
[61,60,67,68],
[231,62,61,68],
[67,66,84,70],
[68,67,70,71],
[231,68,71,72],
[73,63,180,170],
[64,63,73,74],
[65,64,74,75],
[66,65,75,84],
[74,73,76,77],
[75,78,86,87],
[87,84,75],
[70,84,89],
[71,70,80,81],
[123,122,72,71,81,82],
[83,76,73,170,167],
[69,89,84],
[85,80,88],
[78,85,86],
[86,85,79],
[69,87,86,79],
[79,88,89,69],
[70,89,88,80],
[88,79,85],
[78,75,74,77],
[87,69,84],
[76,83,104,91],
[77,76,91,92],
[78,77,92,93],
[85,78,93,94],
[80,85,94,95],
[81,80,95,96],
[82,81,96,90],
[95,94,97,98],
[96,95,98,99],
[90,96,99,100],
[154,90,100,144],
[101,91,104,140,153,143],
[92,91,101,102],
[93,92,102,103],
[94,93,103,97],
[83,105,104],
[105,140,104],
[102,101,106,107],
[103,102,107,108],
[97,103,108,109],
[98,97,109,110],
[99,98,110,111],
[99,113,100],
[132,144,100,113],
[106,101,143,139],
[133,132,113,112],
[113,99,111,112],
[116,117,106,139,130],
[107,106,117,118],
[108,107,118,119],
[109,108,119,120],
[110,109,120,121],
[114,112,111,110,121],
[131,133,112,114,115],
[135,134,133,131,126],
[136,135,126,127],
[137,136,127,128],
[138,137,128,129],
[139,138,129,130],
[145,132,133,134],
[144,132,145],
[146,145,134,135],
[147,146,135,136],
[141,147,136,137],
[142,141,137,138],
[143,142,138,139],
[140,105,83],
[151,150,147,141],
[152,151,141,142],
[153,152,142,143],
[148,154,144,145],
[149,148,145,146],
[150,149,146,147],
[162,161,154,148],
[163,162,148,149],
[159,163,149,150],
[165,159,150,151],
[166,165,151,152],
[167,166,152,153],
[83,167,153,140],
[160,174,157],
[168,165,166,169],
[159,164,156],
[155,173,163,156],
[156,164,174,155],
[157,174,164,158],
[164,159,158],
[158,159,165],
[156,163,159],
[160,155,174],
[161,162,172,171,125,124],
[173,172,162,163],
[155,160,173],
[168,160,157],
[165,168,157,158],
[170,169,166,167],
[178,177,160,168],
[179,178,168,169],
[180,179,169,170],
[172,175,230,171],
[176,175,172,173],
[177,176,173,160],
[182,181,230,175],
[183,182,175,176],
[184,183,176,177],
[185,184,177,178],
[186,185,178,179],
[187,186,179,180],
[195,194,181,182],
[200,195,182,183],
[203,200,183,184],
[188,203,184,185],
[189,188,185,186],
[229,189,186,187],
[189,190,191,188],
[190,205,191],
[196,46,51,192],
[197,196,192,193],
[195,197,193,194],
[200,199,197,195],
[198,40,46,196],
[199,198,196,197],
[204,39,201,205],
[201,39,40,198],
[202,201,198,199],
[203,202,199,200],
[191,205,201,202],
[188,191,202,203],
[205,190,228,227],
[229,228,190,189],
[116,130,129,128,127,126,131,115],
[227,226,204,205],
[206,207,32,33],
[207,208,31,32],
[208,209,30,31],
[209,210,29,30],
[210,211,28,29],
[212,213,207,206],
[213,214,208,207],
[214,215,209,208],
[215,216,210,209],
[216,217,211,210],
[218,219,213,212],
[219,220,214,213],
[220,221,215,214],
[221,222,216,215],
[222,223,217,216],
[224,225,219,218],
[225,226,220,219],
[226,227,221,220],
[227,228,222,221],
[228,229,223,222],
[3,2,225,224],
[1,226,225,2],
[241,240,243,242],
[266,269,322,321,328,327,255,254,253,252],
[161,124,250,248],
[422,421,420,419,424,423],
[313,312,315,314],
[232,233,62,231],
[233,234,181,62],
[234,235,230,181],
[235,232,231,230],
[236,237,234,233],
[237,238,235,234],
[238,239,232,235],
[239,236,233,232],
[240,241,238,237],
[241,242,239,238],
[242,243,236,239],
[245,244,247,246],
[244,245,236,243],
[245,246,237,236],
[246,247,240,237],
[247,244,243,240],
[123,82,249,251],
[262,261,256,255],
[275,274,266,252,171,230],
[252,253,125,171],
[253,254,124,125],
[254,255,250,124],
[255,256,248,250],
[256,257,161,248],
[257,258,154,161],
[258,259,90,154],
[259,260,82,90],
[260,261,249,82],
[261,262,251,249],
[262,263,123,251],
[263,264,122,123],
[264,265,72,122],
[265,267,281,280,231,72],
[280,279,276,275,230,231],
[322,269,268,317,316,323],
[317,268,267,265,264,263,262,332,331,318],
[332,262,255,327,326,333],
[270,271,269,266],
[271,272,268,269],
[272,273,267,268],
[273,282,281,267],
[283,277,276,279],
[278,270,266,274],
[275,276,274],
[280,281,279],
[278,274,276,277],
[283,279,281,282],
[284,285,283,282],
[285,286,277,283],
[286,287,278,277],
[297,296,299,298],
[298,299,289,271],
[289,290,272,271],
[290,292,293,272],
[293,292,295,294],
[293,294,282,273],
[294,295,284,282],
[295,292,291,284],
[296,297,278,287],
[297,298,270,278],
[299,296,287,288],
[300,301,290,289],
[301,302,291,290],
[302,303,284,291],
[303,304,285,284],
[304,305,286,285],
[305,306,287,286],
[306,307,288,287],
[307,300,289,288],
[304,303,311,308,306,305],
[308,309,307,306],
[309,310,302,301,300,307],
[310,311,303,302],
[312,313,311,310],
[313,314,308,311],
[314,315,309,308],
[315,312,310,309],
[319,318,339],
[324,323,337],
[329,328,338],
[334,333,336],
[317,318,316],
[322,323,321],
[327,328,326],
[332,333,331],
[320,316,318,319],
[325,321,323,324],
[330,326,328,329],
[335,331,333,334],
[330,336,326],
[321,338,328],
[326,336,333],
[325,338,321],
[331,339,318],
[335,339,331],
[320,337,316],
[316,337,323],
[340,341,325,324],
[341,342,338,325],
[342,343,329,338],
[343,344,330,329],
[344,345,336,330],
[345,346,334,336],
[346,347,335,334],
[347,348,339,335],
[348,349,319,339],
[349,350,320,319],
[350,351,337,320],
[351,340,324,337],
[352,353,350,349],
[353,354,351,350],
[354,355,340,351],
[355,356,341,340],
[356,357,342,341],
[357,358,343,342],
[358,359,344,343],
[359,360,345,344],
[360,361,346,345],
[361,362,347,346],
[362,363,348,347],
[363,352,349,348],
[364,365,362,361],
[365,366,363,362],
[366,367,352,363],
[367,368,353,352],
[368,369,354,353],
[369,370,355,354],
[370,371,356,355],
[371,372,357,356],
[372,373,358,357],
[373,374,359,358],
[374,375,360,359],
[375,364,361,360],
[376,377,374,373],
[377,378,375,374],
[378,379,364,375],
[379,380,365,364],
[380,381,366,365],
[381,382,367,366],
[382,383,368,367],
[383,384,369,368],
[384,385,370,369],
[385,386,371,370],
[386,387,372,371],
[387,376,373,372],
[388,389,391],
[388,390,389],
[388,400,390],
[388,399,400],
[388,398,399],
[388,397,398],
[388,396,397],
[388,395,396],
[388,394,395],
[388,393,394],
[388,392,393],
[388,391,392],
[376,387,389,390],
[387,386,391,389],
[386,385,392,391],
[385,384,393,392],
[384,383,394,393],
[383,382,395,394],
[382,381,396,395],
[381,380,397,396],
[380,379,398,397],
[379,378,399,398],
[378,377,400,399],
[377,376,390,400],
[401,402,258,257],
[402,403,259,258],
[403,404,260,259],
[404,405,261,260],
[405,406,256,261],
[406,401,257,256],
[407,408,405,404],
[408,409,406,405],
[409,410,401,406],
[410,411,402,401],
[411,412,403,402],
[412,407,404,403],
[413,414,411,410],
[414,415,412,411],
[415,416,407,412],
[416,417,408,407],
[417,418,409,408],
[418,413,410,409],
[419,420,417,416],
[420,421,418,417],
[421,422,413,418],
[422,423,414,413],
[426,425,428,427],
[424,419,416,415],
[425,426,414,423],
[426,427,415,414],
[427,428,424,415],
[428,425,423,424]];

        this.normals = new Array();

        for (var i=0; i<this.faces.length; i++)
        {
          this.normals[i] = [0, 0, 0];
        }
        
        this.center = [0, 0, 0];
				
        for (var i=0; i<this.points.length; i++)
        {
          this.center[0] += this.points[i][0];
          this.center[1] += this.points[i][1];
          this.center[2] += this.points[i][2];
        }
				
				this.distances = new Array();
				for (var i=1; i<this.points.length; i++)
        {
          this.distances[i] = 0;
        }
				
				this.points_number = this.points.length;
				this.center[0] = this.center[0]/(this.points_number-1);
				this.center[1] = this.center[1]/(this.points_number-1);
				this.center[2] = this.center[2]/(this.points_number-1);
				
				this.faces_number = this.faces.length;
				this.axis_x = [1, 0, 0];
				this.axis_y = [0, 1, 0];
				this.axis_z = [0, 0, 1];
				this.fillcolor = fillcolor;
				this.linecolor = linecolor;
			}	
			
			