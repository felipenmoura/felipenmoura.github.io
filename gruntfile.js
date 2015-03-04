module.exports = function(grunt) {

    var NunJucks = require('nunjucks'),
        fs = require('fs'),
        nunEnv = new NunJucks.FileSystemLoader(['templates']),
        defaultLang = 'en';
    
    
    function applyURL(val){
        return val.replace(/(https?:\/\/[^ \n\!\?\<]+)/ig, "<a href=\"$1\" target=\"_blank\">$1</a>")
    }
    
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

//        nunjucks: {
//            options: {
//            },
//            precompile : {
//                baseDir: 'views/',
//                src: 'views/*',
//                dest: 'static/js/templates.js',
//                options: {
//                    env: require('./nunjucks-environment'),
//                    name: function(filename) {
//                        return 'foo/' + filename;
//                    }
//                }
//            },
//        },

        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files:  [{
                    expand: true,
                    cwd: 'scss',
                    src: ['*.scss'],
                    dest: 'styles',
                    ext: '.css'
                }]
            }
        },
        
        scsslint: {
            allFiles: [
                'scss/**/*',
            ],
            options: {
                //bundleExec: true,
                config: 'scss-lint.yml',
                //reporterOutput: 'scss-lint-report.xml',
                colorizeOutput: true
            },
        },
        
        jslint: {
            all: ['gruntfile.js', 'scripts/**.js']
        },
        
        compileTemplates: {
            en: {
                talks: JSON.parse(fs.readFileSync('_bindings/talks.json', 'utf8')),
                //videos: fs.readFileSync('_bindings/videos.json', 'utf8'),
                labs: JSON.parse(fs.readFileSync('_bindings/labs.json', 'utf8')),
                photos: JSON.parse(fs.readFileSync('_bindings/photos.json', 'utf8'))
            },
            pt: "def"
        },

        watch: {
          files: ["_templates/**.html", "_bindings/**", "scss/**.scss", "scripts/**.js"],
          tasks: ['build']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-nunjucks');
    //grunt.loadNpmTasks('grunt-scss-lint');
    //grunt.loadNpmTasks('grunt-jslint');
    
    grunt.registerMultiTask('compileTemplates', 'Saves the files to be statified.', function() {
        
        var idxFile = 'index.html';
        var data = this.data;
        var done = this.async();
        var videosList = "";
        data.lang= this.target;
        
        if(this.target != defaultLang){
            if(!fs.existsSync(this.target)){
                fs.mkdirSync(this.target);
            }
            idxFile = this.target + '/index.html';
        }
        
        //http://gdata.youtube.com/feeds/api/playlists/PL2LsDS820I8Qg8xXkgXTty5BGiqAOJcVB?v=2&alt=json&callback=foo
        var options = {
            hostname: 'gdata.youtube.com',
            port: 80,
            path: '/feeds/api/playlists/PL2LsDS820I8Qg8xXkgXTty5BGiqAOJcVB?v=2&alt=json&callback=foo',
            method: 'GET',
            headers: { 'Content-Type': 'text/javascript' }
        };
        
        function applyURLsTo(data, target, prop){
            if(data[target]){
                data[target] = data[target].map(function(val){
                    val[prop] = applyURL(val[prop]);
                    return val;
                });
            }
        }
        
        function render () {
            applyURLsTo(data, 'talks', 'description');
            applyURLsTo(data, 'labs', 'description');
            
            fs.writeFileSync(idxFile, NunJucks.render('_templates/index.html', data), 'utf8');
            done();
        }

        if(!videosList){
            var http = require('http');
            var cachePath = 'resources/yt-feed-cache.json';
            var req = http.request(options, function(res) {
                var buffer= "";
                res.setEncoding('utf8');
                videosList = "";
                res.on('data', function (data) {
                    buffer+= data;
                });
                res.on('end', function () {
                    videosList = buffer.replace(/^\/\/.*|^foo\(|\);$/gm, '');
                    videosList = JSON.parse(videosList);
                    data.videosList = videosList.feed.entry;
                    
                    if(data.videosList && data.videosList.length){
                        data.videosList = data.videosList.map( function(val) {
                            val['media$group']
                               ['media$description']
                               ['$t'] = applyURL(val['media$group']['media$description']['$t']);
                            return val;
                        });
                    }
                    
                    fs.writeFileSync(cachePath, JSON.stringify(data.videosList), 'utf-8');
                    render();
                });
            });
            req.on('error', function(e) {
                console.log('problem with request: ' + e.message);
                if(fs.existsSync(cachePath)){
                    console.log('using youtube feed from cache');
                    try{
                        data.videosList = JSON.parse(fs.readFileSync(cachePath, 'utf-8'));
                    }catch(e){
                        e.message = "Failed parsing JSON from cache file\n" + e.message;
                        console.error(e);
                    }
                }else{
                    console.warn('no cache found for youtube feed.\nThere will be no video rendered from the feed!');
                    data.videosList = {};
                }
                render();
            });
            req.end();
        }else{
            render();
        }
        
    });
    
    grunt.registerTask('build', [/*'jslint', 'scsslint',*/ 'sass', 'compileTemplates'/*, 'uglify'*/]);


    grunt.registerTask('default', ['build']);

};

