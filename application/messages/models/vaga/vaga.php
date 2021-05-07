<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'titulo' => array(
		'not_empty'	=> 'Campo obrigatório.',
		'min_length'		=> 'O nome deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O nome deve conter no máximo :param2 caracteres.',
	),
	'descricao' => array(
		'not_empty'	=> 'Campo obrigatório.',
		'min_length'		=> 'O nome deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O nome deve conter no máximo :param2 caracteres.',
	),
	'idioma_id' => array(
		'not_empty'	=> 'Campo obrigatório.',
	),
	'estado_id' => array(
		'not_empty'	=> 'Campo obrigatório.',
	),
	'cidade_id' => array(
		'not_empty'	=> 'Campo obrigatório.',
	),
	'nvagas' => array(
		'not_empty'	=> 'Campo obrigatório.',
		'digit'	=> 'Este campo deve ser numérico.',
	),
);
?>