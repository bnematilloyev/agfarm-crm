const {dest, src, watch, parallel} = require('gulp'),
    sass = require('gulp-sass')(require('sass')),
    browserSync = require('browser-sync').create(),
    autoprefixer = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber'),
    notify = require('gulp-notify'),
    sourcemaps = require('gulp-sourcemaps');

const leasingFolder = "backend/web/";
const path = {
    build: {
        leasingCss: leasingFolder + 'css/'
    },
    src: {
        leasingScss: leasingFolder + 'sass/**/*.scss'
    }
};
function browserSyncleasing() {
    browserSync.init({
        proxy: 'mtd.local/',
        notify: false,
        online: true,
        open: true,
        cors: true,
        ui: false
    });

    watch(path.src.leasingScss, parallel(sassLeasing));
    watch('backend/**/*.php', parallel(phpLeasing));
    watch('backend/web/js/**/*.js', parallel(jsLeasing));
}
function phpLeasing() {
    return src(['backend/**/*.php'])
        .pipe(browserSync.stream());
}

function jsLeasing() {
    return src(['backend/web/js/**/*.js'])
        .pipe(browserSync.stream());
}
function sassLeasing() {
    return src(path.src.leasingScss)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass(
            {outputStyle: 'compressed'}
        ).on('error', notify.onError()))
        .pipe(autoprefixer({
            overrideBrowserslist: [
                "> 1%",
                "last 2 versions"
            ]
        }),)
        .pipe(sourcemaps.write())
        .pipe(dest(path.build.leasingCss))
        .pipe(browserSync.stream());
}

exports.leasing = parallel(sassLeasing, browserSyncleasing, phpLeasing, jsLeasing);
exports.default = parallel(sassLeasing, browserSyncleasing, phpLeasing, jsLeasing);