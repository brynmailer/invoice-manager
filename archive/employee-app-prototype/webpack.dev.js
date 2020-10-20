const { merge } = require("webpack-merge");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const common = require("./webpack.common.js");

module.exports = merge(common, {
  mode: "development",
  devtool: "inline-source-map",
  watch: true,
  watchOptions: {
    ignored: /node_modules/,
  },
  plugins: [new CleanWebpackPlugin({ cleanStaleWebpackAssets: false })],
});