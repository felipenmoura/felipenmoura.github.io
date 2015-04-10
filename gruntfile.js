module.exports = function(grunt) {

    var NunJucks = require('nunjucks'),
        fs = require('fs'),
        //nunEnv = new NunJucks.FileSystemLoader(['templates']),
        defaultLang = 'en',
        DOMAIN = 'http://felipenmoura.com/'
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
        ],
        pageTitle = 'felipenmoura';
    
    nunEnv = new NunJucks.Environment(new NunJucks.FileSystemLoader(''));
    //nunEnv = new NunJucks.FileSystemLoader(['templates']);
    nunEnv.addFilter('striptags', function(str, count) {
        return str && str.replace? str.replace(/(<([^>]+)>)/ig, ' '): str;
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
        
        uglify : {
            all: {
                files: {
                    'scripts/default.min.js': ['scripts/default.js']
                }
            },
            options: {}
        },
        
        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'styles/',
                    src: ['*.css', '!*.min.css'],
                    dest: 'styles/',
                    ext: '.min.css'
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
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

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
                    metaData.oCreationDate = metaData.creationDate;
                    metaData.creationDate = formatDate(metaData.creationDate);
                    metaData.oTags = metaData.tags || [];
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
                    
                    validArticles[i].url = '/'+artPath + cur.name;
                    
                });
                
                articlesList.reverse();
                
                data.articlesList = articlesList;
                
                // create the index files for each one
                validArticles.forEach(function(cur){
                    metaData = cur;
                    
                    // create index-ajax for each article
                    metaData.content = fs.readFileSync( artPath + cur.name + '/_content.html', 'utf-8');
                    //metaData.content = metaData.content.replace(/\n/g, '<br/>\n');
                    metaData.content = metaData.content.replace(/\<pre class\="lang:javascript decode\:1 " >/ig, '<pre class="line-numbers"><code class="language-javascript">');
                    metaData.content = metaData.content.replace(/\<pre class\="lang:css decode\:1 " >/ig, '<pre class="line-numbers"><code class="language-css">');
                    metaData.content = metaData.content.replace(/\<pre class\="lang:html decode\:1 " >/ig, '<pre class="line-numbers"><code class="language-markup">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']javascript["']\>/ig, '<pre class="line-numbers"><code class="language-javascript">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']css["']\>/ig, '<pre class="line-numbers"><code class="language-css">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']html["']\>/ig, '<pre class="line-numbers"><code class="language-markup">');
                    metaData.content = metaData.content.replace(/\<pre lang\=["']([0-9a-z_\-]+)["']\>/ig, '<pre class="line-numbers"><code class="language-$1">');
                    metaData.content = metaData.content.replace(/\<\/pre>/ig, '</code></pre>');
                    metaData.colourId = Math.floor(Math.random() * 6 ) + 1;
                    metaData.pageType = 'articles';
                    
                    data.fullURL = DOMAIN + artPath + cur.name + '/';
                    data.pageTitle = 'felipenmoura:' + metaData.pageType + ': ' + metaData.name;
                    data.socialDesc = metaData.resume || 'Meet the Felipe N. Moura personal page with his works, projects, demos, talks and articles.';
                    
                    renderedArticle = nunEnv.render(tplArtPath, metaData);
                    // the index for ajax requests
                    fs.writeFileSync(artPath + cur.name + '/index-ajax.html',
                                     renderedArticle,
                                     'utf-8');
                    // index inside the article itself
                    metaData.oContent = metaData.content;
                    metaData.content = fs.readFileSync( artPath + cur.name + '/index-ajax.html', 'utf-8');
                    metaData.currentArticle = data.currentArticle = metaData.content;
                    fs.writeFileSync(artPath + cur.name + '/index.html',
                                     nunEnv.render(tplPath, data),
                                     'utf8');
                });
                
                // return the last article
                cb(data, validArticles);
            });
        }
        
        function copyIndexTo (where, data) {
            if(!fs.existsSync(where)){
                fs.mkdirSync(where);
            }
            
            //var idxOrig = fs.readFileSync('./index.html', 'utf-8');
            //fs.writeFileSync(where + '/index.html', idxOrig, 'utf-8');
            fs.writeFileSync(where + '/index.html',
                             nunEnv.render('_templates/index.html', data), 'utf8');
            
            
            //fs.createReadStream('./index.html').pipe(fs.createWriteStream(where + '/index.html'));
        }
        
        function render () {
            
            applyURLsTo(data, 'talks', 'description');
            applyURLsTo(data, 'labs', 'description');
            
            createIndexesForArticles(data, function then (data, list){
                
                data.socialDesc = data.resume || 'Meet the Felipe N. Moura personal page with his works, projects, demos, talks and articles.';
                data.pageTitle = 'felipenmoura:page:home';
                data.fullURL = DOMAIN;
                fs.writeFileSync(idxFile, nunEnv.render('_templates/index.html', data), 'utf8');
                copyIndexTo("home", data);
                
                data.pageTitle = 'felipenmoura:page:about';
                data.socialDesc = 'Know more about Felipe, his past, experiences and find his personal contacts and social connections.';
                data.fullURL = DOMAIN + 'about/';
                copyIndexTo("about", data);
                
                data.pageTitle = 'felipenmoura:page:sobre';
                data.socialDesc = 'Saiba mais sobre Felipe, seu passado, experiências e encontre seus contatos pessoais e sociais.';
                copyIndexTo("sobre", data);
                
                data.pageTitle = 'felipenmoura:page:utils';
                data.socialDesc = 'Useful tools, talk materials, demos and lab experiments, videos and photos and articles from Felipe';
                data.fullURL = DOMAIN + 'utils/';
                copyIndexTo("utils", data);
                
                data.socialDesc = 'Ferramentas úteis, materiais de palestras, demos e experimentos, videos, fotos e artigos de Felipe';
                copyIndexTo("uteis", data);
                
                data.pageTitle = 'felipenmoura:page:talks';
                data.socialDesc = "Check out some of Felipe's talks material, slides, links and videos.";
                data.fullURL = DOMAIN + 'utils/talks/';
                copyIndexTo("utils/talks", data);
                
                data.pageTitle = 'felipenmoura:page:palestras/';
                data.socialDesc = "Tenha acesso ao material das palestras de Felipe, slides, links e videos.";
                copyIndexTo("uteis/palestras", data);
                
                data.pageTitle = 'felipenmoura:page:videos';
                data.socialDesc = "Watch some of Felipe's videos about technology, experiments, interviews, etc.";
                data.fullURL = DOMAIN + 'utils/videos/';
                copyIndexTo("utils/videos", data);
                
                data.pageTitle = 'felipenmoura:page:labs';
                data.socialDesc = "Felipe's experimental lab, with demos, tests, examples and tools.";
                data.fullURL = DOMAIN + 'utils/labs/';
                copyIndexTo("utils/labs", data);
                
                data.pageTitle = 'felipenmoura:page:photos';
                data.socialDesc = "Some of the prefered photos of Felipe";
                data.fullURL = DOMAIN + 'utils/photos/';
                copyIndexTo("utils/photos", data);
                
                data.socialDesc = "Algumas das fotos preferidas de Felipe";
                copyIndexTo("utils/fotos", data);
                
                data.pageTitle = 'felipenmoura:page:articles';
                data.socialDesc = "Articles from Felipe, talking about web development, technology, important announcements, some news and ideas, besides some personal thoughts, as well!";
                data.fullURL = DOMAIN + 'articles/';
                copyIndexTo("articles", data);
                
                data.pageTitle = 'felipenmoura:page:artigos';
                data.socialDesc = "Artigos escritos por Felipe, falando sobre desenvolvimento web, tecnologia, anúncios importantes, algumas notícias e eventualmente, pensamentos.";
                copyIndexTo("articles", data);
                
                var dt = (new Date()).toISOString().split('T')[0],
                    renderedRSS = nunEnv.render('_templates/rss.html', {
                    updateDate: (new Date()).toString(),
                    list: list
                });
                fs.writeFileSync('./feed.xml', renderedRSS, 'utf-8');
                
                list.forEach(function(cur, idx){
                    cur.oCreationDate = dt;
                    list[idx] = cur;
                });
                
                var renderedSiteMap = nunEnv.render('_templates/sitemap.html', {
                        updateDate: dt,
                        list: list,
                        pages: [
                            { name: '', lastModified: dt },
                            { name: 'home/', lastModified: dt },
                            { name: 'about/', lastModified: dt },
                            { name: 'utils/', lastModified: dt },
                            { name: 'utils/videos/', lastModified: dt },
                            { name: 'utils/photos/', lastModified: dt },
                            { name: 'utils/talks/', lastModified: dt },
                            { name: 'utils/labs/', lastModified: dt },
                            { name: 'articles/', lastModified: dt }
                        ]
                    });
                fs.writeFileSync('./sitemap.xml', renderedSiteMap, 'utf-8');
                
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
    
    grunt.registerTask('build', ['sass', 'compileArticles', 'compileTemplates', 'uglify', 'cssmin']);

    grunt.registerTask('default', ['build']);

};

