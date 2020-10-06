const { src, dest, series, parallel, watch } = require("gulp");
const del = require("del");
const sass = require("gulp-sass");
const cleanCSS = require("gulp-clean-css");
const rename = require("gulp-rename");
const webpack = require("webpack-stream");
const compiler = require("webpack");
const htmlmin = require("gulp-htmlmin");

function clean(cb) {
  del("./build/**/*");
  cb();
}

function generateCSS(cb) {
  src("./src/**/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(rename("styles.bundle.css"))
    .pipe(dest("./build"));
  cb();
}

function bundleJS(cb) {
  src("./src/**/*.js")
    .pipe(webpack(require("./webpack.config.js", compiler)))
    .pipe(rename("app.bundle.js"))
    .pipe(dest("./build"));
  cb();
}

function minifyHTML(cb) {
  src("./public/index.html")
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(dest("./build"));
  cb();
}

function watchFiles(cb) {
  watch("./src/**/*.scss", generateCSS);
  watch("./src/**/*.js", bundleJS);
  watch("./public/index.html", minifyHTML);
  cb();
}

exports.default = series(clean, parallel(generateCSS, bundleJS, minifyHTML));
exports.watch = watchFiles;
