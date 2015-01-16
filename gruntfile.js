module.exports = function(grunt) {

    var NunJucks = require('nunjucks');
    
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
            en: "abc",
            pt: "def"
        },

        watch: {
          files: ["**/**.scss"],
          tasks: ['build']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-nunjucks');
    //grunt.loadNpmTasks('grunt-scss-lint');
    //grunt.loadNpmTasks('grunt-jslint');
    
    grunt.registerMultiTask('compileTemplates', 'Saves the files to be statified.', function() {
        grunt.log.writeln(this.target + ': ' + this.data);
        grunt.log.writeln(typeof NunJucks);
    });
    
    grunt.registerTask('build', [/*'jslint', 'scsslint',*/ 'sass', 'compileTemplates'/*, 'uglify'*/]);


    grunt.registerTask('default', ['build']);

};

