<?php
return array(
	'curso_id' => array(
		'validaCurso'		 => __('validate.not_empty'),
	),
	'situacao' => array(
		'not_empty'		 => __('validate.not_empty'),
	),
	'dt_inicio' => array(
		'not_empty'		 => __('validate.not_empty'),
		'date'				 => __('validate.not_date'),
	),
	'dt_conclusao' => array(
		'validaDataConclusao'	=>  __('validate.not_date'),
	),
	'instituicao' => array(
		'not_empty'		 => __('validate.not_empty'),
	),
);
?>
