<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'email' => array(
		'not_empty'		=> 'O email deve ser preenchido.',
		'min_length'		=> 'O email deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O email deve conter no máximo :param2 caracteres.',
		'email'				=> 'Endereço inválido de email.',
		'email_available' => 'Este email já está cadastrado.',
	),
	'senha' => array(
		'not_empty' 	=> 'Você deve digitar uma senha de pelo menos 6 caracteres.',
	),
	'endereco' => array(
		'not_empty' 	=> 'Campo obrigatório.',
		'min_length' 	=> 'Endereço Inválido.',
	),
	'numero' => array(
		'not_empty' 	=> 'Campo obrigatório.',
	),
	'bairro' => array(
		'not_empty' 	=> 'Campo obrigatório.',
	),
	'cidade_id' => array(
		'not_empty' 	=> 'Campo obrigatório.',
	),
	'estado_id' => array(
		'not_empty' 	=> 'Campo obrigatório.',
	),
	'cep' => array(
		'not_empty' 	=> 'Campo obrigatório.',
	),
);
?>