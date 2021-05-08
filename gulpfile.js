var gulp            = require('gulp');
var sass            = require('gulp-sass');
var autoprefixer    = require('gulp-autoprefixer');
var concat          = require('gulp-concat');
var uglify          = require('gulp-uglify');
var rename          = require('gulp-rename');
var order           = require('gulp-order');
var cssmin          = require('gulp-cssmin');
var addsrc          = require('gulp-add-src');
var series          = require('gulp-series');


gulp.task('sass_main', function () {
    return gulp.src(['assets/scss/main/**/*.scss'])
        .pipe(sass({
            includePaths: ['node_modules/susy/sass']
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(rename('style.max.css'))
        .pipe(gulp.dest('assets/css'))
        .pipe(cssmin())
        .pipe(rename('style.css'))
        .pipe(gulp.dest('./'));
});


gulp.task('sass_admin', function () {
    return gulp.src(['assets/scss/admin/**/*.scss'])
        .pipe(sass({
            //includePaths: ['node_modules/susy/sass']
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(rename('admin.max.css'))
        .pipe(gulp.dest('assets/css'))
        .pipe(cssmin())
        .pipe(rename('admin.css'))
        .pipe(gulp.dest('./'));
});


gulp.task('js', function() {
    return gulp.src('assets/jslib/**/*.js')
        //.pipe(addsrc('assets/lib/**/*.js'))
        .pipe(order([
            //'jquery.js',
            'main.js'
            ], { base: 'assets/jslib/' }))
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest('assets/js'))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('assets/js'));
});


gulp.task('watch', function(){
    gulp.watch(['assets/scss/main/**/*.scss'], gulp.series('sass_main'));
    gulp.watch(['assets/scss/admin/**/*.scss'], gulp.series('sass_admin'));
    //gulp.watch('assets/jslib/**/*.js', gulp.series('js'));
});


