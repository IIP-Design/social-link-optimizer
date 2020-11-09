const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

module.exports = {
  ...defaultConfig,
  output: {
    filename: 'gpalab-slo-[name].js',
    path: path.resolve( process.cwd(), 'build' ),
  },
}
