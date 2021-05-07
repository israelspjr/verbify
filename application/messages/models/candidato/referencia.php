<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'nome' => array(
		'not_empty'		 => __('validate.not_empty'),
	),
	'email' => array(
		'not_empty'		=> __('validate.not_empty'),
		'email'				=> __('validate.not_email'),
		'email_available' 	=> __('validate.available'),
	),
);