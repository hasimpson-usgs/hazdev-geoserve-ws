'use strict';

module.exports = function (grunt) {

  var gruntConfig = require('./gruntconfig');

  gruntConfig.tasks.forEach(grunt.loadNpmTasks);
  grunt.initConfig(gruntConfig);

  grunt.event.on('watch', function (action, filepath) {
    // Only lint the file that actually changed
    grunt.config(['jshint', 'scripts'], filepath);
  });

  grunt.registerTask('build', [
    'clean:build',
    'concurrent:build'
  ]);

  grunt.registerTask('dist', [
    'build',
    'clean:dist',
    'concurrent:dist',
    'connect:template',
    'configureProxies:dist',
    'connect:dist'
  ]);

  grunt.registerTask('default', [
    'build',
    'connect:template',
    'configureProxies:dev',
    'configureProxies:test',
    'connect:dev',
    'watch'
  ]);

};