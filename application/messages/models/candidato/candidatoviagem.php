<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'pais_id' => array(
		'not_empty'		=> __('validate.not_empty'),
	),
	'dtde' => array(
		'not_empty'		=> __('validate.not_empty'),
		'date'				=>  __('validate.not_date'),
	),
	'dtate' => array(
		'not_empty'		=> __('validate.not_empty'),
		'date'				=>  __('validate.not_date'),
	),
	'atividade' => array(
		'not_empty'		=> __('validate.not_empty'),
	),
);