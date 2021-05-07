<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Vaga extends ORM
{
	protected $_table_name = 'vagas';

	protected $table_columns = array(
		'id' 				=> 	array('type'=>'int'),
		'contratante_id' 	=> 	array('type'=>'int'),
		'titulo'			=> 	array('type'=>'string'),
		'exibir'			=> 	array('type'=>'boolean'),
		'descricao'			=> 	array('type'=>'string'),
		'horario'			=> 	array('type'=>'string'),
		'salario'			=> 	array('type'=>'string'),
		'idioma_id'			=> 	array('type'=>'int'),
		'estado_id'			=> 	array('type'=>'string'),
		'cidade_id'			=> 	array('type'=>'int'),
		'regiao_id'			=> 	array('type'=>'int'),
		'bairro'			=> 	array('type'=>'string'),
		'na_escola'			=> 	array('type'=>'boolean'),
		'in_company'		=> 	array('type'=>'boolean'),
		'criancas'			=> 	array('type'=>'boolean'),
		'adolescentes'		=> 	array('type'=>'boolean'),
		'adultos'			=> 	array('type'=>'boolean'),
		'nvagas'			=> 	array('type'=>'int'),
		'dt_cadastro'		=> 	array('type'=>'timestamp'),
	);

	protected $_belongs_to = array(
		'contratante' => array('model' => 'contratante', 'foreign_key' => 'contratante_id'),
		'idioma' => array('model' => 'idioma', 'foreign_key' => 'idioma_id'),
		'estado' => array('model' => 'estado', 'foreign_key' => 'estado_id'),
		'cidade' => array('model' => 'cidade', 'foreign_key' => 'cidade_id'),
		'regiao' => array('model' => 'regiaosp', 'foreign_key' => 'regiao_id'),
	);

	protected $_has_many = array(
		'candidaturas' => array(
			'model'   => 'candidatura',
			'foreign_key' => 'vaga_id',
		),
	);
	
	
	public function rules()
	{
		return array(
			'contratante_id' => array(
				array('not_empty'),
			),
			/*
			'titulo' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 120)),
			),
			'descricao' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 120)),
			),
			*/
			'idioma_id' => array(
				array('not_empty'),
			),
			'estado_id' => array(
				array('not_empty'),
			),
			'cidade_id' => array(
				array('not_empty'),
			),
			'nvagas' => array(
				array('not_empty'),
				array('digit'),
			),
		);
	}
	
	public function countCandidaturasAtivas()
	{
		return $this->candidaturas->where("descartado", "=", "0")->count_all();
	}
	
	public function getCandidaturasAtivas()
	{
		return $this->candidaturas->where("descartado", "=", "0")->find_all();
	}
	
	public function getTextoLocal()
	{
		$arrlocal = array();
		if($this->na_escola==1)
			$arrlocal[] = 'NA ESCOLA';
		if($this->in_company==1)
			$arrlocal[] = 'IN COMPANY';
		return 'AULAS '.implode(" E ", $arrlocal);
	}

	public function getTextoTipo()
	{
		$arrtipo = array();
		if($this->criancas == 1)
			$arrtipo[] = 'CRIANÇAS';
		if($this->adolescentes == 1)
			$arrtipo[] = 'ADOLESCENTES';
		if($this->adultos == 1)
			$arrtipo[] = 'ADULTOS';
		if(count($arrtipo) > 2)
			return 'CURSOS PARA '.$arrtipo[0].', '.$arrtipo[1].' E '.$arrtipo[2];
		else
			return 'CURSOS PARA '.implode(" E ", $arrtipo);
		
	}
	
	public function getTitle()
	{
		return 'PROFESSOR DE '.Helper::upper($this->idioma->descricao);
	}
	
	public function getIntro()
	{
		$html = '<span style="font-weight: bold; font-size: 14px;">PROFESSOR DE '.Helper::upper($this->idioma->descricao).'</span><br />
		'.Helper::upper($this->cidade->getCidadeUf()).(($this->regiao->loaded()) ? ' / '.Helper::upper($this->regiao->descricao) : '').'<br />
		'.$this->getTextoLocal().'<br />
		'.$this->getTextoTipo().'<br />
		'.$this->nvagas.' '.($this->nvagas ==1 ? 'VAGA' : 'VAGAS');
		return $html;
	}

	public function getDescricao()
	{
		$html = 'PROFESSOR DE '.Helper::upper($this->idioma->descricao).'. '.$this->getTextoLocal().'. '.$this->getTextoTipo().'. '.$this->nvagas.' '.($this->nvagas ==1 ? 'VAGA' : 'VAGAS').'.';
		return $html;
	}

	public function getURL()
	{
		return 'http://'.$_SERVER["SERVER_NAME"].URL::site("vagas/detalhe/".$this->id);
	}
	
	public function setLocal($local)
	{
		$this->na_escola = 0;
		$this->in_company = 0;
		if(count($local) > 0)
			foreach($local as $value)
				if($value == 'e')
					$this->na_escola = 1;
				elseif($value == 'c')
					$this->in_company = 1;
	}
	
	public function setTipo($tipo)
	{
		$this->criancas = 0;
		$this->adolescentes = 0;
		$this->adultos = 0;
		if(count($tipo) > 0)
			foreach($tipo as $value)
				if($value == 'c')
					$this->criancas = 1;
				elseif($value == 't')
					$this->adolescentes = 1;
				elseif($value == 'a')
					$this->adultos = 1;
	}
}
?>