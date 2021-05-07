<?php defined('SYSPATH') or die('No direct script access.');

return array (
	'nome' => array(
		'not_empty'		 => 'Campo obrigatório.',
		'min_length'		=> 'O nome deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O nome deve conter no máximo :param2 caracteres.',
		'regex'				=> 'Você deve informar seu nome completo.',
	),
	'cpf' => array(
		'not_empty'		=> 'Campo obrigatório.',
		'is_cpf'				=> 'O CPF é inválido.',
		'cpf_available'	=> 'Este CPF já está cadastrado.',
	),
	'tel' => array(
		'not_empty'		=> 'Campo obrigatório.',
	),
);
?>