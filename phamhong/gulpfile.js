const gulp = require('gulp');
const fileInclude = require('gulp-file-include');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cleanCSS = require('gulp-clean-css');
const replace = require('gulp-replace');

const paths = {
    html: 'src/**/*.html',
    htmlDest: 'dist/',
    scss: 'src/assets/scss/**/*.scss',
    cssDest: 'dist/assets/css/',
    assets: 'src/assets/{images,lib,js}/**/*', 
    assetsDest: 'dist/assets/'
};

function processHTML() {
    return gulp.src([paths.html, '!src/partials/*.html'])
        .pipe(fileInclude({
            prefix: '@@',
            basepath: '@file'
        }))
        .pipe(replace('/assets/scss/', '/assets/css/'))
        .pipe(replace('.scss', '.css'))
        .pipe(replace('../dist/assets/', './assets/'))
        .pipe(gulp.dest(paths.htmlDest));
}

function compileSCSS() {
    return gulp.src(paths.scss)
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCSS())
        .pipe(gulp.dest(paths.cssDest));
}

function copyAssets() {
    return gulp.src(paths.assets)
        .pipe(gulp.dest(paths.assetsDest));
}

function watchFiles() {
    gulp.watch(paths.html, processHTML);
    gulp.watch(paths.scss, compileSCSS);
    gulp.watch(paths.assets, copyAssets);
}

exports.default = gulp.series(gulp.parallel(processHTML, compileSCSS, copyAssets), watchFiles);
