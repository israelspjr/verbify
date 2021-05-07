<?php defined('SYSPATH') or die('No direct script access.');

class Request extends Kohana_Request {
	/**
	 * Main request singleton instance. If no URI is provided, the URI will
	 * be automatically detected using PATH_INFO, REQUEST_URI, or PHP_SELF.
	 *
	 * @param   string   URI of the request
	 * @return  Request
	 */
	public static function instance( & $uri = TRUE)
	{
		$instance = parent::current($uri);

		$index_page     = Kohana::$index_file;
		$lang_uri_abbr 	= Kohana::$config->load('appconf')->get('lang_uri_abbr');
		$default_lang 	= Kohana::$config->load('appconf')->get('language_abbr');
		$lang_ignore	= Kohana::$config->load('appconf')->get('lang_ignore');

		/* get the lang_abbr from uri segments */
		$segments = explode('/',$instance->uri());
		$lang_abbr = isset($segments[0]) ? $segments[0]:'';

		/* get current language */
		$cur_lang = $instance->param('lang',$default_lang);

		/* check for invalid abbreviation */
		if( ! isset($lang_uri_abbr[$lang_abbr]))
		{
			/* check for abbreviation to be ignored */
			if ($cur_lang != $lang_ignore) {
				/* check and set the default uri identifier */
				$index_page .= empty($index_page) ? $default_lang : "/$default_lang";

			 	/* redirect after inserting language id */
				$uri = $instance->uri();
 				header('Location: '.Url::base() . $index_page . ($uri !== "" ? "/$uri" : ""));
				die();
			}
		}
		return $instance;
	}

	public function redirect($url)
	{
		if (strpos($url, '://') === FALSE)
		{
			$lng = Request::instance()->param('lang');
			return parent::redirect("{$lng}/{$url}");
		} else {
			return parent::redirect("$url");
		}
	}

}