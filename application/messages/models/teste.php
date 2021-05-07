<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'nome' => array(
		'not_empty'	=> 'Campo obrigatório.',
		'min_length'		=> 'O nome deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O nome deve conter no máximo :param2 caracteres.',
	),
	'tipo' => array(
		'not_empty'		=> 'Campo obrigatório.',
		'regex'			=> 'Tipo inválido.',
	)
);
?>