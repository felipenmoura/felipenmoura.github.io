module.exports = function(grunt) {

    var NunJucks = require('nunjucks'),
        fs = require('fs'),
        //nunEnv = new NunJucks.FileSystemLoader(['templates']),
        defaultLang = 'en',
        months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sept",
            "Oct",
            "Nov",
            "Dec"
        ];
    
    nunEnv = new NunJucks.Environment(new NunJucks.FileSystemLoader(''));
    //nunEnv = new NunJucks.FileSystemLoader(['templates']);
    nunEnv.addFilter('striptags', function(str, count) {
        return str && str.replace? str.replace(/(<([^>]+)>)/ig, ''): str;
    });
    
    function formatDate(date){
        var tmpDt = new Date(date);
        var day = tmpDt.getDate();
        switch(day % 10){
                case 1:
                    day+= "st";
                break;
                case 2:
                    day+= "nd";
                break;
                case 3:
                    day+= "rd";
                break;
                default:
                    day+= "th";
                break;
        }
        return months[tmpDt.getMonth()] + ' '+ day +', '+tmpDt.getFullYear();
    }
    
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
            }//,
            //pt: "def"
        },
        
        compileArticles: {
            en: {},
            //pt: {}
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
    
    grunt.registerMultiTask('compileArticles', 'generates the articles files.', function() {
        
        var done = this.async();
        done();
    });
    
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
        
        function createIndexesForArticles(data, cb){
            var artPath = 'articles/',
                metaData,
                tplPath = '_templates/index.html',
                tplArtPath = '_templates/article.html',
                validArticles= [],
                renderedArticle,
                articlesList= [],
                tmpDt;
            
            fs.readdir(artPath, function(err, files){
                if(err){
                    console.error("Failed reading articles");
                }

                // get all the meta datas
                files.forEach(function(cur){
                    if(cur[0] == '.' || !fs.lstatSync(artPath + cur).isDirectory()){
                        return;
                    }
                    metaData = JSON.parse( fs.readFileSync(artPath + cur + '/_meta.json') );
                    metaData.name= cur;
                    metaData.creationDate = formatDate(metaData.creationDate);
                    metaData.tags = metaData.tags? metaData.tags.join(', '): 'no tags';
                    if(metaData.status == 'published'){
                        validArticles.push(metaData);
                    }
                });
                
                // sort them out
                validArticles.sort(function(left, right){
                    return left.creationDate >= right.creationDate;
                });
                
                // set the previous and next links
                validArticles.forEach(function(cur, i){
                    
                    articlesList.push({
                        title: cur.title,
                        tags: cur.tags,
                        name: cur.name
                    });
                    
                    if(validArticles[i-1]){
                        validArticles[i].previous = validArticles[i-1];
                    }else{
                        validArticles[i].previous = false;
                    }
                    if(validArticles[i+1]){
                        validArticles[i].next = validArticles[i+1];
                    }else{
                        validArticles[i].next = false;
                    }
                    
                    validArticles[i].url = artPath + cur.name;
                });
                
                data.articlesList = articlesList;
                
                // create the index files for each one
                validArticles.forEach(function(cur){
                    metaData = cur;
                    
                    // create index-ajax for each article
                    metaData.content = fs.readFileSync( artPath + cur.name + '/_content.html', 'utf-8');
                    //metaData.content = metaData.content.replace(/\n/g, '<br/>\n');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']javascript["']\>/ig, '<pre class="line-numbers"><code class="language-javascript">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']css["']\>/ig, '<pre class="line-numbers"><code class="language-css">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']html["']\>/ig, '<pre class="line-numbers"><code class="language-markup">');
                    metaData.content = metaData.content.replace(/\<pre lang\=["']([0-9a-z_\-]+)["']\>/ig, '<pre class="line-numbers"><code class="language-$1">');
                    metaData.content = metaData.content.replace(/\<\/pre>/ig, '</code></pre>');
                    metaData.colourId = Math.floor(Math.random() * 6 ) + 1;
                    
                    renderedArticle = nunEnv.render(tplArtPath, metaData);
                    // the index for ajax requests
                    fs.writeFileSync(artPath + cur.name + '/index-ajax.html',
                                     renderedArticle,
                                     'utf-8');
                    // index inside the article itself
                    metaData.content = fs.readFileSync( artPath + cur.name + '/index-ajax.html', 'utf-8');
                    metaData.currentArticle = data.currentArticle = metaData.content;
                    fs.writeFileSync(artPath + cur.name + '/index.html',
                                     nunEnv.render(tplPath, data),
                                     'utf8');
                });
                
                // return the last article
                cb(data);
            });
        }
        
        function copyIndexTo (where) {
            if(!fs.existsSync(where)){
                fs.mkdirSync(where);
            }
            
            var idxOrig = fs.readFileSync('./index.html', 'utf-8');
            fs.writeFileSync(where + '/index.html', idxOrig, 'utf-8');
            
            //fs.createReadStream('./index.html').pipe(fs.createWriteStream(where + '/index.html'));
        }
        
        function render () {
            
            applyURLsTo(data, 'talks', 'description');
            applyURLsTo(data, 'labs', 'description');
            
            createIndexesForArticles(data, function(data){
                fs.writeFileSync(idxFile, nunEnv.render('_templates/index.html', data), 'utf8');
                
                copyIndexTo("home");
                copyIndexTo("about");
                copyIndexTo("sobre");
                copyIndexTo("utils");
                copyIndexTo("utils/talks");
                copyIndexTo("utils/videos");
                copyIndexTo("utils/labs");
                copyIndexTo("utils/photos");
                copyIndexTo("articles");

                done();
            });
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
    
    grunt.registerTask('build', ['sass', 'compileArticles', 'compileTemplates'/*, 'uglify'*/]);

    grunt.registerTask('default', ['build']);

};

