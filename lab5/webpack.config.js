const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');


module.exports = {
    entry: {
        'table': './src/index.ts',
        'hangman': './src/hangman.js'
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].bundle.js'
    },
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.json']
    },
    module: {
        rules: [{
            test: /\.(ts|js)x?$/,
            exclude: /node_modules/,
            loader: 'babel-loader',
        },{
            test: /\.scss$/,
            use: [
                'style-loader',
                'css-loader',
                'sass-loader'
            ]
        }, {
            test: /\.(png|svg|jpg|gif)$/,
            use: [
                {
                    loader: "file-loader"
                }
            ]
        }]
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: './src/table.html',
            filename: './table.html',
            chunks: ['table'],
            inject: true
        }),
        new HtmlWebpackPlugin({
            template: './src/hangman.html',
            filename: './index.html',
            chunks: ['hangman'],
            inject: true
        }),
    ]
};