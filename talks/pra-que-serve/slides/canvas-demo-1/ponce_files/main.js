var gfm = gfm || {};


gfm.Main = function(wx, wy)
{
    this._renderer = new gfm.Renderer("c0", false);
    
    this._width = 0;
    this._height = 0;
    this._N = 30;
    this.resize(wx, wy);   
    
    this._audioManager = new gfm.AudioManager();
    
    this._audioManager.addMusic("minidral_remix", 
                                "minidral_remix.ogg", 
                                "minidral_remix.mp3", 0.8);
                                
    
    this._localTime = 0.0;
    this._globalTime = 0.0;
    
    this._prims = new gfm.PrimVec(20 * this._N);
    
    this._spheres = new Array(this._N);
    
    this._V0 = new gfm.Vec3(0, 0, 0);
    this._VUP = new gfm.Vec3(0, 1, 0);
    this._eye = new gfm.Vec3(0, 0, 0);
    
    this._tempV1 = new gfm.Vec3(0,0,0);
    this._tempV2 = new gfm.Vec3(0,0,0);
    this._tempV3 = new gfm.Vec3(0,0,0);
    this._tempM1 = new gfm.Mat4();
    this._tempM2 = new gfm.Mat4();
    this._screenp = new gfm.Vec4(0,0,0,0);
        
    for (var i = 0; i < this._N; ++i)
    {        
        // placed in a cube
        var vx = Math.random() * 2 - 1;
        var vy = Math.random() * 2 - 1;
        var vz = Math.random() * 2 - 1;
        var vradius = 0.01 + Math.pow(Math.random(), 1.1) * 0.05 + 0.35 * Math.pow(Math.random(), 7);
        
        
        var vr = 0, vg = 0, vb = 0;
        
        switch (Math.floor(Math.random() * 4))
        {
            case 0:
                vr = 0xed / 0xff;
                vg = 0xed / 0xff; // yellow
                vb = 0xed / 0xff;
                break;
                
            case 1:
                vr = 0xf3 / 0xff;
                vg = 0xed / 0xff;
                vb = 0xf2 / 0xff;  //magenta
                break;
                
            case 2:                
                vr = 0x58 / 0xff;
                vg = 0x58 / 0xff;
                vb = 0x58 / 0xff;
                break;
                
            default:
                vr = 0xef / 0xff;
                vg = 0xef / 0xff;
                vb = 0xff / 0xff;
                break;
        }
        var DL = Math.random() * 0.2 - 0.1;
        vr += 0.3 * DL;
        vg += 0.6 * DL;
        vb += 0.1 * DL;
        vr = Math.max(0, Math.min(1, vr));
        vg = Math.max(0, Math.min(1, vg));
        vb = Math.max(0, Math.min(1, vb));
        
        
        this._spheres[i] = new gfm.Sphere(vx, vy, vz, vradius, vr, vg, vb);
    }
    
    this._bounds = new gfm.Vec4(0,0,0,0);
    this._firstFrame = true;
    this._persp = new gfm.Mat4();
    this._camera = new gfm.Mat4();
    this._matrix = new gfm.Mat4();
    this._bggradient = null;  
};

gfm.Main.prototype = {

	resize : function(wx, wy)
	{
        this._renderer.setSize(wx, wy);        
        this._width = wx;
        this._height = wy;
        this._firstFrame = true;
	},
	
	move: function(dt)
	{
    	var N = this._N;
    	var spheres = this._spheres;
    	
    	for (var i = 0; i < N; ++i)
    	    for (var j = 0; j < N; ++j)
    	        if (i !== j)
    	        {
        	        var A = spheres[i];
        	        var B = spheres[j];
        	        var dx = A._x[0] - B._x[0];
        	        var dy = A._y[0] - B._y[0];
        	        var dz = A._z[0] - B._z[0];
        	        
        	        var d = Math.sqrt(dx * dx + dy * dy + dz * dz);
        	        
        	        if (d < (A._radius + B._radius) * 1.3)
        	        {
            	        var d3 = -0.01 / (0.01 + d * d * d);
            	        B.accumForce(dx * d3, dy * d3, dz * d3);
        	        }
        	        else// if (d < (A._radius + B._radius))
        	        {
            	        var d3 = A.getMass() * 0.1 / (0.01 + d * d * d);
            	        B.accumForce(dx * d3, dy * d3, dz * d3);
    	            }    	            
        	    }
        	    
        for (var i = 0; i < N; ++i)
        {
            var B = spheres[i];
            var F = 0.5 / B._invMass;
            B.accumForce((0.001-B._x[0]) * F, (0.001-B._y[0]) * F, (0.001-B._z[0]) * F);        	    
        }
    	
        var frictionFactor = Math.exp(-0.1 * dt);
    	// move spheres
    	for (var i = 0; i < N; ++i)
    	{
        	spheres[i].progress(dt, frictionFactor);
    	}    	
	},
    
	loop: function(time, dt)
	{    	
    //	if (!this._audioManager.allLoaded())
    //	    return;
    	    
    	    
    	this._audioManager.nextMusic();
    	   
    	    
    	    
    	var aux = false;
    	
    	var context = aux ? this._renderer.getAuxContext() : this._renderer.getContext();
		this._localTime += dt;
		var lt = this._localTime;
		
		var prims = this._prims;
		var spheres = this._spheres;
		var width = this._width;
		var height = this._height;
        var cx = width / 2;
        var cy = height / 2;
        var S = Math.min(width, height);
        		
        var cost = Math.cos(lt);
        var sint = Math.sin(lt);
        var N = this._N;
		
        // redraw background
        //context.globalCompositeOperation = 'source-over';
		
        if (this._firstFrame)
	    {
    	    this._bggradient = context.createRadialGradient(cx, cy, 0, cx, cy, cx + cy);
    	    this._bggradient.addColorStop(0, '#bbb');
            this._bggradient.addColorStop(0.6, '#777');
            this._bggradient.addColorStop(1.0, '#111');
        }
	    
	    context.fillStyle = this._bggradient;
	    
	    
	    if (this._firstFrame)
	    {
    	    context.fillRect(0, 0, width, height);    	    
	    }
	    else
	    {	    
	        prims.getBounds(width, height, this._bounds);
	        context.fillRect(this._bounds._x, this._bounds._y, this._bounds._z - this._bounds._x + 1, this._bounds._w - this._bounds._y + 1);
        }
		
		this._firstFrame = false;
		
		this.move(dt * 0.6);
		
		
        
        gfm.perspective(60, width / height, 0.01, 10, this._persp);

        var eye = this._eye;
        eye._x = Math.cos(lt * 0.5);
        eye._y = Math.sin(lt * 0.5);
        eye._z = 0.9 * (1.2 + Math.cos(lt * 0.7));

        gfm.lookat(eye, this._V0, this._VUP, this._tempV1,  this._tempV2,  this._tempV3,
         this._tempM1, this._tempM2, this._camera);
        
        this._persp.mul(this._camera, this._matrix);
        var matrix = this._matrix;
        // push prims
        prims.clear();
        var screenp = this._screenp;
        
		for (var i = 0; i < N; ++i)
        {            
            var s = spheres[i];
            
            var C = s._N;
            
            var radiusFact = 1;
            for (var j = 0; j < C; ++j)
            {            
                matrix.transformPersp(s._x[j], s._y[j], s._z[j], s._radius, screenp);
            
                var x = cx + cx * screenp._x;
                var y = cy - cy * screenp._y;            
                var z = screenp._z;
                var radius = radiusFact * (cy * screenp._w);
            
                if (radius < 0.01)
                    break;
                    
		        prims.push(x, y, z, radius, s._r, s._g, s._b, j===0);    
                radiusFact *= 0.8;
            }
	    }
	    
	    prims.sort();
		prims.draw(context, width, height, Math.sqrt(eye._x * eye._x + eye._y * eye._y + eye._z * eye._z), Math.cos(lt * 2));		
    }
};
