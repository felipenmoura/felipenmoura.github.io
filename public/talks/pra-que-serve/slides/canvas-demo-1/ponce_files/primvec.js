var gfm = gfm || {};
 
 
gfm.PrimVec = function(maxCount)
{
    this._maxCount = maxCount;
    this._prims = new Array(maxCount);
     
    for (var i = 0; i < maxCount; ++i)
    {
        this._prims[i] = new gfm.Prim(0, 0, 0, 0, 0, 0, 0);        
    }
    
    this._count = 0;
    
    this._startShadow = gfm.rgba(0, 0, 0, 0.225);
    this._midShadow = gfm.rgba(0, 0, 0.1, 0.07);
    this._endShadow = gfm.rgba(0, 0, 0, 0);
    this._linesStyle = gfm.rgba(0.9, 0.9, 1, 0.4);
};

gfm.PrimVec.prototype = {
  
    clear: function()
    {
        this._count = 0;
    },
    
    push: function(x, y, z, radius, r, g, b, dostroke)
    {
        if (this._count === this._maxCount)
        {
            return;
        }
        
        var prim = this._prims[this._count];
        prim._x = x;
        prim._y = y;
        prim._z = z;
        prim._r = r;
        prim._g = g;
        prim._b = b;
        prim._radius = radius;
        prim._stroke = dostroke;
        this._count ++;
    },
    
    // sort by depth
    sort: function()
    {   
        this._prims.sort(function(a, b){
            return b._z - a._z;
        });
    },
    
    getBounds: function(width, height, res)
    {
        var xmin = width;
        var xmax = 0;
        var ymin = height;
        var ymax = 0;
        var min = Math.min;
        var max = Math.max;
        var count = this._count;
        var prims = this._prims;
        for (var i = 0; i < count; ++i)
        {
            var prim = prims[i];
            var x = prim._x;
            var y = prim._y;
            var radius = prim._radius * 1.5;
            var x1 = x - radius;
            var x2 = x + radius;
            var y1 = y - radius;
            var y2 = y + radius;
            
            xmin = min(x1, xmin);
            xmax = max(x2, xmax);
            ymin = min(y1, ymin);
            ymax = max(y2, ymax);            
        }
        res._x = xmin;
        res._y = ymin;
        res._z = xmax;
        res._w = ymax;        
    },
    
    draw: function(context, width, height, zfocus, cost)
    {
        var count = this._count;
        var prims = this._prims;
        var startShadow = this._startShadow;
        var midShadow = this._midShadow;
        var endShadow = this._endShadow;
        var linesStyle = this._linesStyle;
        context.lineWidth = 0.5;
        context.strokeStyle = gfm.rgba(0.9 + 0.1 * cost, 0.9 + 0.1 * cost, 0.9 + 0.1 * cost, 0.5 - 0.1 * cost);
        var M = Math;
        var pow = M.pow;
        var max = M.max;
        var abs = M.abs;
        var rgb = gfm.rgb;
        var rgba = gfm.rgba;
        
        for (var i = 0; i < count; ++i)
        {
            var prim = prims[i];
            var x = prim._x;
            var y = prim._y;
            var z = prim._z;
            if (z < 0)
                continue;
            // focus == 1    =>   max
            // focus == 0    =>   blurry
            var focus =  max(0, 1 - abs(prim._z - zfocus) * 0.5);
            var r = prim._r;
            var g = prim._g;
            var b = prim._b;
            var radius = prim._radius;       
            if (radius < 1)
                continue;     
                
            var stroke = prim._stroke;
         
            var gx = x;
            var gy = y;
            var gradient = context.createRadialGradient(gx, gy, 0, gx, gy, radius);            
            var C = 0.2 - 0.1 * focus;
            var D = 0.6 * focus;            
            gradient.addColorStop(0, rgb(r, g, b));
            gradient.addColorStop(0.4, rgb(r * 0.6, g * 0.6, b * 0.6));
            gradient.addColorStop(0.465, rgba(r * 0.4, g * 0.4, b * 0.4, 0.5 + 0.2 * focus));
            gradient.addColorStop(0.5, rgba(r * C, g * C, b * C, 0.3 + 0.3 * focus));
            
            gradient.addColorStop(0.511, startShadow);
            gradient.addColorStop(0.700, midShadow);
            gradient.addColorStop(1.0, endShadow);
            
            context.fillStyle = gradient;            
            
            context.beginPath();
            context.arc(x, y, radius * 1.1, 0.0, Math.PI*2, true);
            context.closePath();
            context.fill();
            
            if (stroke)
            {
                context.stroke();
            }
        }       
    }    
};

