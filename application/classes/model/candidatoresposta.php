<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_CandidatoResposta extends ORM {

	protected $_table_name = 'candidato_resposta';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 			=> 	array('type'=>'int'),
		'candidato_id' 	=> 	array('type'=>'int'),
		'teste_id'		=> 	array('type'=>'int'),
		'questao_id'	=> 	array('type'=>'int'),
		'resposta'		=> 	array('type'=>'int'),
		'respostatexto'	=> 	array('type'=>'string'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'teste' 	=> array('model' => 'teste', 'foreign_key' => 'teste_id'),
		'questao'	=> array('model' => 'questao', 'foreign_key' => 'questao_id'),
	);

	public function validate()
	{

		if($this->resposta <> "?")
		{
			if($this->questao->tipo==1)
			{
				if($this->resposta <> 'E' AND $this->resposta <> 'C')
					throw new Exception ('Selecione uma alternativa');
			}
			elseif($this->questao->tipo==2)
			{
				// validação extra para A-Z
				if(!preg_match('#^([A-Z]|\?)#', $this->resposta)){
					throw new Exception ('Resposta inválida');
				}
			}
			elseif($this->questao->tipo==3)
			{
				if($this->respostatexto == '')
					throw new Exception ('Selecione pelo menos uma resposta');
			}
			elseif($this->questao->tipo==4)
			{
				$graderows = FormTestes::getRowsGrade();
				$arr = json_decode($this->respostatexto);
				foreach($graderows as $key => $value){
					if(!preg_match('/^[1-5]/', $arr[0][$key])){
						throw new Exception ('Selecione uma resposta para o item "'.$value.'"');
					}
					if($arr[0][$key] > 2 AND !preg_match('/^[6-7]/', $arr[1][$key])){
						throw new Exception ('Selecione uma coluna azul para o item "'.$value.'"');
					}
				}
			}
			elseif($this->questao->tipo==5)
			{
				$arr = json_decode($this->respostatexto);
				foreach($arr as $key => $value){
					if(trim($value) == "")
						throw new Exception ('Preencha todos os campos');
				}
			}
			elseif($this->questao->tipo==6)
			{
				if(!preg_match('/^[1-3]/', $this->resposta)){
						throw new Exception ('Selecione uma opção');
				}
			}
		}
	}

	public function setValor($valor, $tempoesgotago = 0)
	{
		if(is_array($valor) AND ($this->questao->tipo == 5 OR $this->questao->tipo == 4)){
			$tmp_valor = array();
			foreach($valor as $key => $v)
				if($v <> "")
					$tmp_valor[$key] = $v;
			$valor = $tmp_valor;
		}
		if(($valor == "" OR empty($valor)) AND $tempoesgotago == 1)
		{
			$this->resposta = '?';
		}
		elseif($this->questao->tipo == 1)
		{
			$resp = ORM::factory("resposta", $valor);
			$this->resposta = $resp->valor;
		}
		elseif($this->questao->tipo == 2)
		{
			$resp = ORM::factory("resposta", $valor);
			$this->resposta = $resp->valor;
		}
		elseif($this->questao->tipo == 3)
		{
			$arr = array();
			if(is_array($valor)){
				foreach($valor as $v){
					$resp = ORM::factory("resposta", $v);
					$arr[] = $resp->texto;
				}
			}
			$this->respostatexto = implode(", ", $arr);
		}
		elseif ($this->questao->tipo == 4)
		{
			if($tempoesgotago == 1){
				$this->resposta = '?';
			}
			$graderows = FormTestes::getRowsGrade();
			$arr = array();
			foreach($graderows as $key => $value){
				$arr[0][$key] = (isset($valor[0][$key]) ? $valor[0][$key] : "");
				$arr[1][$key] = (isset($valor[1][$key]) ? $valor[1][$key] : "");
			}
			$this->respostatexto = json_encode($arr);
		}
		elseif ($this->questao->tipo == 5)
		{
			if($tempoesgotago == 1){
				$this->resposta = '?';
			}
			$arr = array();
			for($i=0;$i<$this->questao->max_check;$i++){
				$arr[$i] = (isset($valor[$i]) ? $valor[$i] : '');
			}
			$this->respostatexto = json_encode($arr);
		}
		elseif ($this->questao->tipo == 6)
		{
			$this->resposta = $valor;
		}
	}
}
?>