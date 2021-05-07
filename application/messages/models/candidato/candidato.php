<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'nome' => array(
		'not_empty'		 => __('validate.not_empty'),
		'min_length'		=> __('validate.min_length'),
		'max_length'		=> __('validate.max_length'),
		'regex'				=> __('validate.full_name'),
	),
	'cpf' => array(
		'not_empty'		=> __('validate.not_empty'),
		'is_valid_cpf'		=> __('validate.valid'),
		'cpf_available'	=> __('validate.available'),
	),
	'dtnasc' => array(
		'not_empty'		=> __('validate.not_empty'),
		'date'				=>  __('validate.valid'),
	),
	'sexo' => array(
		'not_empty'		=> __('validate.not_empty'),
		'is_sexo'			=> __('validate.valid'),
	),
	'nacionalidade' => array(
		'not_empty'		=> __('validate.not_empty'),
	),
	'tel1' => array(
		'not_empty'		=> __('validate.not_empty'),
	),
	'email' => array(
		'not_empty'		=> __('validate.not_empty'),
		'min_length'		=> __('validate.min_length'),
		'max_length'		=> __('validate.max_length'),
		'email'				=> __('validate.valid'),
		'email_available' => __('validate.available'),
	),
	'senha' => array(
		'not_empty' 	=> __('validate.senha'),
	),
);