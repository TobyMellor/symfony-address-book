var gulp = require('gulp'),
    sass = require('gulp-sass');

gulp.task('default', function() {
    return gulp.src('app/Resources/styles/*')
        .pipe(sass()) // Converts Sass to CSS with gulp-sass
        .pipe(gulp.dest('web/css'))
});
