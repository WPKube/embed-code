var del    = require('del');
var fs     = require('fs');
var gulp   = require('gulp');
var rename = require('gulp-rename');
var shell  = require('gulp-shell');
var zip    = require('gulp-zip');

var pkg = JSON.parse(fs.readFileSync('package.json'));

// RELEASE ---------------------------------------------------------------------

gulp.task('copy', function() {
	return gulp.src([
			'**',
			'!composer.json',
			'!composer.lock',
			'!gulpfile.js',
			'!includes/vendor/autoload.php',
			'!includes/vendor/composer/',
			'!includes/vendor/composer/**',
			'!node_modules/',
			'!node_modules/**',
			'!package.json',
		])
		.pipe(gulp.dest(pkg.name));
});

gulp.task('zip', ['copy'], shell.task(`zip -r ${pkg.name}-${pkg.version}.zip ${pkg.name}`));

gulp.task('export', ['zip'], shell.task(`mv ${pkg.name}-${pkg.version}.zip ~/Desktop/`));

gulp.task('clean', ['export'], function() {
	return del(pkg.name);
});

gulp.task('release', ['translate', 'copy', 'zip', 'export', 'clean']);
