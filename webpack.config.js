module.exports = {
    entry: {
        app:  './static/js/main.js'
    },
    output: {
        filename: './public/js/bundle.js'
    },
    watch: true,
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: ['es2015'],
                    plugins: ['jsx-event-modifiers', 'transform-vue-jsx']
                }
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    {loader: 'style-loader'},
                    {loader: 'css-loader'},
                    {loader: 'sass-loader'},
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ],
    },
    // externals: ['axios'],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        }
    },
};