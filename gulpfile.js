const { src, dest, watch, series, parallel } = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const postcss = require("gulp-postcss");
const rename = require("gulp-rename");
const browserSync = require("browser-sync").create();
const concat = require("gulp-concat");
const terser = require("gulp-terser");
const babelify = require("babelify");
const browserify = require("browserify");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");
const stripDebug = require("gulp-strip-debug");
const notify = require("gulp-notify");
const plumber = require("gulp-plumber");
const options = require("gulp-options");
const gulpif = require("gulp-if");
const sourcemaps = require("gulp-sourcemaps");

// Files
const files = {
  styleSRC: "./src/scss/mystyle.scss",
  styleURL: "./assets/",
  mapURL: "./",
  jsSRC: "./src/js/myscript.js",
  jsURL: "./assets/",
  styleWatch: "./src/scss/**/*.scss",
  jsWatch: "./src/js/**/*.js",
  phpWatch: "./**/*.php",
};

// Scss Task
function scssTask() {
  return src(files.styleSRC, { sourcemaps: true })
    .pipe(sass())
    .pipe(
      postcss([
        autoprefixer({
          overrideBrowserslist: ["last 2 versions", "> 5%", "Firefox ESR"],
        }),
        cssnano(),
      ])
    )
    .pipe(rename({ suffix: ".min" }))
    .pipe(dest(files.styleURL, { sourcemaps: "." }));
}

// JavaScript Task
function jsTask() {
  return (
    // files.jsSRC, { sourcemaps: true })

    browserify({ entries: files.jsSRC })
      .bundle()
      .pipe(source("myscript.min.js"))
      .pipe(gulpif(options.has("production"), stripDebug()))
      .pipe(buffer())
      .pipe(terser())
      .pipe(sourcemaps.init({ loadMaps: true }))
      .pipe(sourcemaps.write("."))
      .pipe(dest(files.jsURL))
  );
}

// Plumber
function triggerPlumber(src, url) {
  return src(src).pipe(plumber()).pipe(dest(url));
}

// BrowserSync Tasks
function browsersyncServe(cb) {
  browserSync.init({
    server: {
      baseDir: ".",
    },
  });
  cb();
}

function browsersyncReload(cb) {
  browserSync.reload();
  cb();
}

// Watch Task
function watchTask() {
  watch(
    [files.styleWatch, files.jsWatch],
    series(scssTask, jsTask, browsersyncReload)
  );
}

// Gulp Default Task
exports.default = series(scssTask, jsTask, browsersyncServe, watchTask);
