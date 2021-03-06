<?php defined('SYSPATH') or die('No direct script access.');

error_reporting(E_ALL);

// -- Environment setup --------------------------------------------------------



// Load the core Kohana class

require SYSPATH.'classes/kohana/core'.EXT;



if (is_file(APPPATH.'classes/kohana'.EXT))

{

	// Application extends the core

	require APPPATH.'classes/kohana'.EXT;

}

else

{

	// Load empty core extension

	require SYSPATH.'classes/kohana'.EXT;

}



/**

 * Set the default time zone.

 *

 * @see  http://kohanaframework.org/guide/using.configuration

 * @see  http://php.net/timezones

 */

date_default_timezone_set('America/Sao_Paulo');



/**

 * Set the default locale.

 *

 * @see  http://kohanaframework.org/guide/using.configuration

 * @see  http://php.net/setlocale

 */

setlocale(LC_ALL, 'pt_BR.utf-8');



/**

 * Enable the Kohana auto-loader.

 *

 * @see  http://kohanaframework.org/guide/using.autoloading

 * @see  http://php.net/spl_autoload_register

 */

spl_autoload_register(array('Kohana', 'auto_load'));

/**

 * Enable the Kohana auto-loader for unserialization.

 *

 * @see  http://php.net/spl_autoload_call

 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func

 */

ini_set('unserialize_callback_func', 'spl_autoload_call');



// -- Configuration and initialization -----------------------------------------



/**

 * Set the default language

 */

I18n::lang('pt-br');



Cookie::$salt = 'OTRECFORP';

/**

 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.

 *

 * Note: If you supply an invalid environment name, a PHP warning will be thrown

 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"

 */

if (isset($_SERVER['KOHANA_ENV']))

{

	Kohana::$environment = 'DEVELOPMENT'; //constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));

}



/**

 * Initialize Kohana, setting the default options.

 *

 * The following options are available:

 *

 * - string   base_url    path, and optionally domain, of your application   NULL

 * - string   index_file  name of your index file, usually "index.php"       index.php

 * - string   charset     internal character set used for input and output   utf-8

 * - string   cache_dir   set the internal cache directory                   APPPATH/cache

 * - boolean  errors      enable or disable error handling                   TRUE

 * - boolean  profile     enable or disable internal profiling               TRUE

 * - boolean  caching     enable or disable internal caching                 FALSE

 */

Kohana::init(array(

	'base_url'   => '/sistema/',

	'index_file' => FALSE,

	'errors' => TRUE,

/*	'profile' => TRUE,*/

));



/**

 * Attach the file write to logging. Multiple writers are supported.

 */

Kohana::$log->attach(new Log_File(APPPATH.'logs'));



/**

 * Attach a file reader to config. Multiple readers are supported.

 */

Kohana::$config->attach(new Config_File);



/**

 * Enable modules. Modules are referenced by a relative or absolute path.

 */

Kohana::modules(array(

	'auth'			=> MODPATH.'auth',       // Basic authentication

	'database'		=> MODPATH.'database',   // Database access

	'orm'				=> MODPATH.'orm',        // Object Relationship Mapping

	'pagseguro'		=> MODPATH.'pagseguro',        // Object Relationship Mapping

	'image'			=> MODPATH.'image',

));



/**

 * Set the routes. Each route must have a minimum of a name, a URI and a set of

 * defaults for the URI.

 */



$langs 		= Kohana::$config->load('appconf')->get('lang_uri_abbr');

$default_lang 	= Kohana::$config->load('appconf')->get('language_abbr');

$lang_ignore	= Kohana::$config->load('appconf')->get('lang_ignore');

$langs_abr 	= implode('|',array_keys($langs)) ;

if(!empty($langs_abr))

	$langs_abr .= '|' . $lang_ignore;



Route::set('directory', '((<lang>)(/)(<directory>)(/)(<controller>(/<action>(/<id>(/<id2>)))))',

		array('lang' => "({$langs_abr})", 'directory' => '(admin|contratante|candidato)')

	)

	->defaults(array(

		'lang' => $default_lang,

		'controller' => 'home',

		'action'     => 'index',

	)

);

/*

 *

Route::set('sections', '<directory>(/<controller>(/<action>(/<id>(/<id2>))))',

	array( 'directory' => '(admin|contratante|candidato)' ))

	->defaults(array(

	'controller'	=> 'home',

	'action'		=> 'index',

	'id'			=> '',

));



Route::set('default', '(<controller>(/<action>(/<id>)))')

->defaults(array(

	'controller' => 'home',

	'action'     => 'index',

));

*/