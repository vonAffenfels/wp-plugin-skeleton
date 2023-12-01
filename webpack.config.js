const path = require('path');
const {WebpackManifestPlugin} = require('webpack-manifest-plugin');
const WebpackNotifierPlugin = require('webpack-notifier');
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

module.exports = (env, argv) => {
    const mode = argv.mode ? argv.mode : 'development';
    const isProd = mode === 'production';
    return {
        mode: mode,
        devtool: isProd ? false : 'eval-source-map',
        entry: path.join(__dirname, "resources", 'js', "index.js"),
        output: {
            path: path.resolve(__dirname, 'dist')
        },
        module: {
            rules: [
                {
                    test: /\.(?:js|mjs|cjs)$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                '@babel/preset-env',
                                '@babel/preset-react',
                            ]
                        }
                    }
                }
            ]
        },
        plugins: [
            new DependencyExtractionWebpackPlugin(),
            new WebpackNotifierPlugin({title: 'Conversion Plugin'}),
            new WebpackManifestPlugin({
                fileName: path.join(__dirname, 'dist', 'webpack-assets.json'),
                publicPath: '/dist/',  // prevents legacy target from overwriting modern target
                generate: (seed, files, entries) => {
                    return {
                        type: "va-v1",
                        files: files.reduce((result, file) => ({
                                ...result,
                                [file.name]: {
                                    path: file.path,
                                    hash: file.chunk?.renderedHash ?? ''
                                }
                            }), {})
                    }
                }
            }),
        ],
        resolve: {
            alias: {
                'js': path.resolve(__dirname, 'resources', 'js'),
                'src': path.resolve(__dirname, 'src'),
            }
        }
    };
}
