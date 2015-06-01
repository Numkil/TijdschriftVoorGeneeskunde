var gulp = require('gulp');
var jslint = require('gulp-jslint');
var csslint = require('gulp-csslint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifyCss = require('gulp-minify-css');
var merge2 = require('merge2');
var bowerMain = require('bower-main');

var bowerMainJavaScriptFiles = bowerMain('js', 'min.js')
var bowerMainCssFiles= bowerMain('css', 'min.css')

gulp.task('bower', function() {
  return gulp.src(bowerMainJavaScriptFiles.normal)
    .pipe(concat('vendor-scripts.js'))
    .pipe(gulp.dest('web/bundles/global/vendor'));
});

gulp.task('bowerprod', function(){
  return merge2(
    gulp.src(bowerMainJavaScriptFiles.minified),
    gulp.src(bowerMainJavaScriptFiles.minifiedNotFound)
      .pipe(concat('tmp.min.js'))
      .pipe(uglify())
    )
    .pipe(concat('vendor-scripts.js'))
    .pipe(gulp.dest('web/bundles/global/vendor'));
});

gulp.task('bowercss', function() {
  return gulp.src(bowerMainCssFiles.normal)
    .pipe(concat('vendor-styles.css'))
    .pipe(gulp.dest('web/bundles/global/vendor'));
});

gulp.task('bowercssprod', function(){
  return merge2(
    gulp.src(bowerMainCssFiles.minified),
    gulp.src(bowerMainCssFiles.minifiedNotFound)
      .pipe(concat('tmp.min.css'))
      .pipe(uglify())
    )
    .pipe(concat('vendor-styles.css'))
    .pipe(gulp.dest('web/bundles/global/vendor'));
});

gulp.task('copyjs', function(){
  return gulp.src('app/Resources/js/**/*.js')
    .pipe(concat('TvG-scripts.js'))
    .pipe(gulp.dest('web/bundles/global/js'));
});

gulp.task('copyjsprod', function(){
  return gulp.src('app/Resources/js/**/*.js')
    .pipe(concat('TvG-scripts.js'))
    .pipe(uglify())
    .pipe(gulp.dest('web/bundles/global/js'));
});

gulp.task('copycss', function(){
  return gulp.src('app/Resources/css/**/*.css')
    .pipe(concat('TvG-style.css'))
    .pipe(gulp.dest('web/bundles/global/css'));
});

gulp.task('copycssprod', function(){
  return gulp.src('app/Resources/css/**/*.css')
    .pipe(concat('TvG-style.css'))
    .pipe(minifyCss())
    .pipe(gulp.dest('web/bundles/global/css'));
});

// build the main source into the min file
gulp.task('jslint', function () {
    return gulp.src('app/Resources/js/**/*.js')

        .pipe(jslint({
            node: true,
            evil: true,
            nomen: true,
            errorsOnly: false
        }))

        // error handling:
        // to handle on error, simply
        // bind yourself to the error event
        // of the stream, and use the only
        // argument as the error object
        // (error instanceof Error)
        .on('error', function (error) {
            console.error(String(error));
        });
});

gulp.task('csslint', function () {
    return gulp.src('app/Resources/css/**/*.css')
    .pipe(csslint())
    .pipe(csslint.reporter());
});

gulp.task('dev', ['bower', 'bowercss', 'jslint', 'csslint', 'copyjs', 'copycss']);
gulp.task('prod', ['bowerprod', 'bowercssprod', 'jslint', 'csslint', 'copyjsprod', 'copycssprod']);
