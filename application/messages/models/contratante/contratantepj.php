<?php defined('SYSPATH') or die('No direct script access.');

return array (
	'razao' => array(
		'not_empty'		 => 'Campo obrigatório.',
		'min_length'		=> 'O nome deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O nome deve conter no máximo :param2 caracteres.',
	),
	'cnpj' => array(
		'not_empty'		=> 'Campo obrigatório.',
		'is_cnpj'				=> 'O CNPJ é inválido.',
		'cnpj_available'	=> 'Este CNPJ já está cadastrado.',
	),
	'c_nome' => array(
		'not_empty'		 => 'Campo obrigatório.',
		'min_length'		=> 'O nome deve conter pelo menos :param2 caracteres.',
		'max_length'		=> 'O nome deve conter no máximo :param2 caracteres.',
	),
	'c_tel' => array(
		'not_empty'		=> 'Campo obrigatório.',
	),
	'c_cargo' => array(
		'not_empty'		=> 'Campo obrigatório.',
	),	
	'franquia' => array(
		'verificaFranquiaDescricao' => 'Campo obrigatório.',
	),	
);
?>