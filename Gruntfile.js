module.exports = function(grunt) {

	grunt.loadNpmTasks('grunt-contrib-clean')
	grunt.loadNpmTasks('grunt-contrib-compress')
	grunt.loadNpmTasks('grunt-contrib-copy')
	grunt.loadNpmTasks('grunt-shell')
	grunt.loadNpmTasks('grunt-wp-i18n')

	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		makepot: {
			release: {
				options: {
					domainPath: 'languages',
					type: 'wp-plugin',
					exclude: [
						'includes/vendor/'
					]
				}
			}
		},

		copy: {
			release: {
				files: [{
					expand: true,
					src: ['**', '!**/node_modules/**', '!Gruntfile.js', '!package.json'],
					dest: '<%= pkg.name %>/'
				}]
			}
		},

		compress: {
			release: {
				options: {
					archive: '<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				expand: true,
				src: ['<%= pkg.name %>/**'],
				dest: '/'
			}
		},

		shell: {
			release: {
				command: 'mv <%= pkg.name %>-<%= pkg.version %>.zip ~/Desktop/'
			}
		},

		clean: {
			release: ['<%= pkg.name %>/', '<%= pkg.name %>-<%= pkg.version %>.zip']
		}

	})

	grunt.registerTask('default', ['makepot', 'copy', 'compress', 'shell', 'clean'])

}
