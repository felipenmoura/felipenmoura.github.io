
make= {};
make.debounce= function(target, options){

	if(typeof target != 'object' && typeof target != 'function'){
		return console.error('throttle:throttle maker requires a function, or an object as target(the first argument). All the methods will be treated as throttles. The second argument(options) accepts "methods" as an array with the names of methods you want to become throttle.');
	}

	if(options === void 0){
		options= {};
	}

	options.distance= options.distance || 200; // mileseconds

	var methods= options.methods;

	if(typeof target == 'object'){
		if(methods){
			methods= methods.length && typeof methods == 'object'? methods: [methods];
		}
	}

	var list= methods || Object.keys(target),
		fn= null,
		i= 0,
		l= list.length,
		dist = options.distance,
		timeout= null;

	if(typeof target == 'object'){
		for(; i<l; i++){
			if(typeof target[list[i]] == 'function'){
				fn= list[i];
				target[fn]= makeDebounce(target[fn]);
			}
		}
	}else{
		return makeDebounce(target);
	}

	function makeDebounce(fn) {
		return function() {
			var args= arguments;

			window.clearTimeout(timeout);
			timeout= setTimeout(function(){
				fn.apply(target, args);
			}, options.distance);
		};
	};

	return target;
};

/**
    makes given objects indexables with Indexable methods

    var o= {
      a: {
        b: { d: [11, 22, 33]},
        c: { e: 'algo' }
      },
      f: { g: { h: { i: { j:{ k: { l:{ m: "felipe" }}}}}}},
      n: 'foo',
      o: [
        { p: 'A longer text comes here', q: 'Something else'},
        { r: 'Another text comes', s: 'yeah!'},
        { t: 'And here, could be a loren ipsum!', u: "just some bla bla bla"},
        { v: "ok, that's it...", x: 'x files'},
        { y: 'yah, baby, yeah!', z: "zzzzzzzz..."}
      ]
    };
    make.indexable(o);
    console.log( o.find('algo') );
    console.log( o.find('22') );
    console.log( o.find('felipe') );
    console.log( o.find('foo') );
    console.log( o.findLike('loren') );
    console.log( o.findLike("that's") );
    console.log( o.findLike(/bla {0,2}/));
    console.log( o.locate('p') );
    console.log( o.locate('k') );
    console.log( o.locate('x') );
    console.log( o.locateLike('P') );
 */
make.indexable= function(obj){

    if(!obj || typeof obj != 'object'){
        return console.error('indexable:Method makeIndexable expects first argument to be an Object');
    }

    function Indexable(){
        var self= this;

        var castEl= function(cur, i){
            i= i || '';
            if(typeof cur == 'object' && cur.length){
                i= '['+i+']';
            }else{
                i= '.'+i;
            }
            return i;
        };

        this.find= function(search, cur, path, opts){

            if(search === void 0){
                return console.error('indexable:Method find expected one argument.');
            }

            path= path || [];
            cur= cur || self;
            opts= opts || {};
            var i= null,
                found= false;

            var compare= function(target, key, search){

                var val= null,
                    oSearch= search;

                if(opts.regEx){
                    if(!(search instanceof RegExp)){
                        search= new RegExp(search, 'i');
                    }
                }else{
                    search= new RegExp(search, '');
                }
                if(opts.lookingForKey){
                    val= key;
                }else{
                    val= target[key];
                }
                val= val.valueOf() || '';

                try{
                    if( (val.match && val.match(search)) || val == oSearch ){
                        return true;
                    }
                }catch(e){
                    console.warn('compare', 'A problem occurred when trying to compare values. Possible error with a regExp, perhaps?', e);
                }
                return false;
            };

            for(i in cur){
                if(cur.hasOwnProperty(i)){
                    if( compare(cur, i, search) ){
                        path.push(castEl(cur, i));
                        found= true;
                        break;

                    }else{
                        if(cur[i] && typeof cur[i] == 'object'){
                            path.push(castEl(cur, i));
                            //cur= cur[i];
                            found= self.find(search, cur[i], path, opts);
                            if(found){
                                return found;
                            }else{
                                path.pop();
                            }
                        }
                    }
                }
            }

            if(found && path && path.length){
                return path.join('').replace('.', '');
            }
            return false;
        };

        this.locate= function(item){
            return this.find(item, false, false, {
                lookingForKey: true
            });
        };

        this.findLike= function(saerch){
            return this.find(saerch, false, false, {
                regEx: true
            });
        };

        this.locateLike= function(item){
            return this.find(item, false, false, {
                lookingForKey: true,
                regEx: true
            });
        };
    }

    Indexable.apply(obj);

};

// this file is supposed to offer the make.observable maker
make.readonly= function(target, options){

    if(typeof target != 'object'){
        return console.error('throttle:throttle maker requires an object as target(the first argument). All the methods will be treated as throttles. The second argument(options) accepts "methods" as an array with the names of methods you want to become throttle.');
    }

    if(options === void 0){
        options= {};
    }

    for(prop in target){
        if(target.hasOwnProperty(prop)){
            Object.defineProperty(target, prop, {
                enumerable: true,
                configurable: false,
                writable: false,
                value: target[prop]
            });
        }
    }

    return target;
};
// this file is supposed to offer the make.singleton maker
make.throttle= function(target, options){

    if(typeof target != 'object' && typeof target != 'function'){
        return console.error('throttle:throttle maker requires a function or an object as target(the first argument). All the methods will be treated as throttles. The second argument(options) accepts "methods" as an array with the names of methods you want to become throttle.');
    }

    if(options === void 0){
        options= {};
    }

    options.distance= options.distance || 100; // mileseconds

    var methods= options.methods;

    if(methods){
        methods= methods.length && typeof methods == 'object'? methods: [methods];
    }

    var list= methods || Object.keys(target),
        fn= null,
        i= 0,
        l= list.length,
        dist = options.distance,
        lastExecution = new Date((new Date()).getTime() - dist);

    if(typeof target == 'object'){
        for(; i<l; i++){
            if(typeof target[list[i]] == 'function'){
                fn= list[i];
                target[fn]= makeThrottle(target[fn]);
            }
        }
    }else{
        // is a function
        return makeThrottle(target);
    }

    function makeThrottle(fn) {
        return function() {
            if ((lastExecution.getTime() + dist) <= (new Date()).getTime()) {
                lastExecution = new Date();
                return fn.apply(target, arguments);
            }
        };
    };

    return target;
};
make.worker= function(target, options){

	if(typeof target != 'object' && typeof target != 'function'){
		return console.error('worker:Worker maker requires a function or an object as target(the first argument). All the methods will be treated as workers, but you can pass in the second argument(options), the property "methods" with an array with the names of methods you want, only they will become workers.');
	}

	options= options || {};
	var methods= options.methods;

	if(methods){
		methods= methods.length && typeof methods == 'object'? methods: [methods];
	}

	var list= methods || Object.keys(target),
		oTarget= target,
		fn= null,
		i= 0,
		l= list.length;

	if(typeof target == 'object'){
		for(; i<l; i++){
			if(typeof target[list[i]] == 'function'){
				fn= list[i];
				target[fn]= makeWorker(target[fn]);
			}
		}
	}else{
		return makeWorker(target);
	}

	function makeWorker(func){

		var fn= func.toString();

		fn= " self.onmessage = function(e) { \n self.postMessage((" + fn;
		fn+= ").apply(self, e.data))};\n ";

		if(fn.match(/document|window|body/)){
			// still...the function may try to access dom in other ways :/
			console.warn('worker:Function passed to make.worker tries to access DOM elements. The function will work, but will not be a worker');
			return fn;
		}

	    function createWorker(fn){
			var blob = new Blob([fn]);

			var worker = new Worker(window.URL.createObjectURL(blob));
		    worker.onmessage = function(e) {
		      func.workerFinished(e.data);
		      window.URL.revokeObjectURL(blob);
		    }
		    return worker;
	    };

		return function(){
			var args= Array.prototype.slice.call(arguments, 0);

			if(typeof args[args.length-1] == 'function'){
				func.workerFinished= args.pop();
			}

			var worker= createWorker(fn);

			worker.postMessage(args);
		};
	};
	return target;
};