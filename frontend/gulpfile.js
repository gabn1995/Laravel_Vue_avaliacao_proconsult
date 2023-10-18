const { src, dest, parallel } = require('gulp');
const webpack = require('webpack-stream');
const named = require('vinyl-named');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

function html() {
    return src('src/*.html')
        .pipe(dest('public/'));
}

function vue() {
    return src('node_modules/vue/dist/vue.min.js')
        .pipe(dest('public/assets/js/'));
}

function vuerouter() {
    return src('node_modules/vue-router/dist/vue-router.min.js')
        .pipe(dest('public/assets/js/'));
}

function js() {
    return src('src/js/index.js')
        .pipe(named())
        .pipe(webpack({
            mode: 'production',
            output: {
                filename: '[name].js'
            },
            module: {
                rules: [
                    {
                        test:/\.vue$/,
                        loader:'vue-loader'
                    },
                    {
                        test:/\.js$/,
                        loader:'babel-loader'
                    },
                    {
                        test:/\.css$/,
                        use:['vue-style-loader', 'css-loader']
                    },

                ]
            },
            plugins: [
                new VueLoaderPlugin()
            ],
            resolve: {
                alias: {
                    'vue$': 'vue/dist/vue.esm.js'
                },
                extensions: ['*', '.js', '.vue', '.json']
            }
        }))
        .pipe(dest('public/assets/js/'));
}

exports.default = parallel(html, vue, vuerouter, js);