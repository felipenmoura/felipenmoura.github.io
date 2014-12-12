module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
      
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

    watch: {
      files: ["**/**.scss"],
      tasks: ['sass']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');

  grunt.registerTask('default', ['sass']);

};