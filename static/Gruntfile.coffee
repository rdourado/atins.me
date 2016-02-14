module.exports = (grunt) ->

  'use strict'

  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks)

  grunt.initConfig

    pkg: grunt.file.readJSON 'package.json'
    theme: '../dynamic/wp-content/themes/atins'

    watch:
      html:
        options:
          spawn: false
          atBegin: true
        files: ['source/**/*.jade']
        tasks: ['jade', 'notify']
      css:
        options:
          spawn: false
          atBegin: true
        files: ['source/css/**/*.{sass,scss}']
        tasks: ['sass', 'postcss', 'sync:css', 'notify']
      img:
        options:
          spawn: false
          atBegin: true
        files: ['source/img/**']
        tasks: ['sync:imgbuild', 'sync:img', 'imagemin', 'notify']
      js:
        options:
          spawn: false
          atBegin: true
        files: ['source/js/**/*.coffee']
        tasks: ['coffee', 'uglify', 'sync:js', 'notify']

    jade:
      build:
        options:
          pretty: true
        files: [{
          expand: true
          cwd: 'source'
          src: ['**/*.jade', '!**/_*.jade']
          dest: 'build'
          ext: '.html'
        }]

    sass:
      build:
        options:
          style: 'compressed'
          sourceMap: false
        files: [{
          expand: true
          cwd: 'source/css'
          src: ['**/*.sass', '!**/_*.sass']
          dest: 'build/css'
          ext: '.css'
        }]

    postcss:
      build:
        options:
          map: false
          processors: [
            require('autoprefixer')({browsers: 'last 3 versions'})
            require('cssnano')()
          ]
        src: 'build/css/**/*.css'

    coffee:
      build:
        options:
          bare: true
          sourceMap: false
        files: [{
          expand: true
          cwd: 'source/js'
          src: ['**/*.coffee', '!**/_*.coffee']
          dest: 'build/js'
          ext: '.js'
        }]

    uglify:
      build:
        options:
          drop_console: false
          preserveComments: false
          mangle:
            except: ['jQuery']
        files:
          'build/js/scripts.js' : ['source/js/lib/slick.js', 'source/js/lib/jquery.fancybox.js', 'source/js/lib/jquery.lazyload.js', 'build/js/scripts.js']
          'build/js/gmaps.js' : ['build/js/gmaps.js']
          'build/js/redirect.js' : ['build/js/redirect.js']

    imagemin:
      png:
        options:
          optimizationLevel: 7
        files: [{
          expand: true,
          cwd: 'build/img',
          src: ['**/*.png'],
          dest: '<%= theme %>/img',
          ext: '.png'
        }]
      jpg:
        options:
          progressive: true
        files: [{
          expand: true,
          cwd: 'build/img',
          src: ['**/*.jpg'],
          dest: '<%= theme %>/img',
          ext: '.jpg'
        }]

    sync:
      imgbuild:
        updateAndDelete: true
        files: [{
          cwd: 'source/img'
          src: ['**']
          dest: 'build/img'
        }]
      img:
        updateAndDelete: true
        files: [{
          cwd: 'build/img'
          src: ['**']
          dest: '<%= theme %>/img'
        }]
      css:
        updateAndDelete: true
        files: [{
          cwd: 'build/css'
          src: ['**']
          dest: '<%= theme %>/css'
        }]
      js:
        updateAndDelete: true
        files: [{
          cwd: 'build/js'
          src: ['**']
          dest: '<%= theme %>/js'
        }]

    notify_hooks:
      options:
        title: 'Atins Grunt'
        enabled: true
        success: true

    notify:
      watch:
        options:
          title: 'Atins Grunt'
          message: 'Good to go!'

  # Notify

  grunt.task.run 'notify_hooks'

  # Tasks

  grunt.registerTask 'default', ['jade', 'sass', 'postcss', 'coffee', 'uglify', 'sync', 'imagemin', 'notify']
