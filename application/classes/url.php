<?php defined('SYSPATH') or die('No direct script access.');

class URL extends Kohana_URL {

	/**
	* href link generator
	*
	* Returns a href tag after adding the user language in it
	*
	*/
	public static function link_to($title, $url, $options=array()){
		$option_str = '';
		$site_url 	= Url::base();
		$lng = Request::instance()->param('lang');
		foreach($options as $key => $option) {
			$option_str .= "{$key}='{$option}' ";
		}
		return "<a href='{$site_url}{$lng}/{$url}' {$option_str}>{$title}</a>";
	}

	public static function site($url = '') {
		$site_url 	= Url::base();
		$lng = Request::instance()->param('lang');
		if(preg_match('$^(assets|uploads|'.$lng.'/)$', $url))
			return parent::site($url);
		else
			return parent::site("{$lng}/{$url}");
	}

	public static function siteChangeLng($url = '') {
		$site_url 	= Url::base();
		return parent::site($url);
	}
}