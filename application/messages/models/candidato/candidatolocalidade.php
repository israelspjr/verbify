<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'pais' => array(
		'not_empty'					=> __('validate.not_empty'),
	),
	'estado_id' => array(
		'validaEstadoOuCidade'	 => __('validate.not_empty'),
	),
	'cidade_id' => array(
		'validaEstadoOuCidade'	 => __('validate.not_empty'),
	),
	'regiao_id' => array(
		'validaRegiao'					=> __('validate.not_empty'),
	),
);
