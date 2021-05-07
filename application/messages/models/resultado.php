<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'letra' => array(
		'not_empty'		=> 'Campo obrigatório.',
		'validaLetra'	=> 'Código / Letra já cadastrada.',
	),
	'texto' => array(
		'not_empty'	=> 'Campo obrigatório.',
	),
	'min' => array(
		'not_empty'	=> 'Campo obrigatório.',
		'numeric'	=> 'O valor mínimo deve ser um número.',
		'validaValorMinimo'		=> 'Campo inválido.',
	),
	'max' => array(
		'not_empty'	=> 'Campo obrigatório.',
		'numeric'	=> 'O valor máximo deve ser um número.',
		'validaValorMaximo'		=> 'Campo inválido.',
	),
);
?>