# Krustr

Krustr CMS as a Composer package.

## License

The Krustr CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Installation

To install the Krustr CMS just add the followind to your **composer.json** file:

	"creolab/krustr": "dev-master"

Add you also need to register the service provider by adding the following line to you **app/config/app.php** file among the already registered providers:

	'providers' => array(
		// ... your providers

		'Krustr\KrustrServiceProvider',
	),

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/creolab/krustr/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
