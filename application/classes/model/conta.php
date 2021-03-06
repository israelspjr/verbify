<?php defined('SYSPATH') or die('No direct access allowed.');



class Model_Conta extends ORM {



	protected $_primary_key = 'id';

	protected $_table_name = 'conta';

	protected $table_columns = array (

		'id' 				=> 	array('type'=>'int'),

		'contratante_id'	=>		array('type'=>'int'),

		'candidato_id'		=>		array('type'=>'int'),

		'saldo'				=> 	array('type'=>'decimal'),

		'active'			=> 	array('type'=>'boolean'),

	);



	protected $_belongs_to = array(

		'contratante' => array('model' => 'contratante', 'foreign_key' => 'contratante_id'),

		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),

	);



	protected $_has_many = array(

		'consumologs' => array(

			'model'   => 'consumolog',

			'foreign_key' => 'conta_id',

		),

		'acessoscomprados' => array(

			'model'   => 'acessocomprado',

			'foreign_key' => 'conta_id',

		),

		'convites' => array(

			'model'   => 'convite',

			'foreign_key' => 'conta_id',

		),

	);



	public function getNome(){

		if($this->contratante_id <> 0){

			return $this->contratante->getNome();

		} else {

			return $this->candidato->nome;

		}

	}

 

	function getValorConsumoContato($candidato_id){

		$credito = ORM::factory("consumocredito", 3);

		$candidato = ORM::factory("candidato", $candidato_id);

		$res = $credito->consumo;

		$ateagora = $this->consumologs

			->select(array(DB::expr('SUM(consumo_qtde)'), 'total'))

			->where('candidato_id', '=', $candidato_id)

			->find();

		if($ateagora->loaded())

		{

			$vldesconto = ORM::factory("contatodesconto")

				->where('minimo', '<=', abs($ateagora->total))

				->order_by('minimo', 'DESC')

				->find();

			if($vldesconto->loaded())

				$res = $vldesconto->consumo;

		}

		if($this->contratante->conveniado == 1) {

			if($res > $credito->consumo_conveniado)

				return $credito->consumo_conveniado;

		}

		return $res;		

	}



	function getConsumoSoma($candidato_id, $consumo_id){

		//$acesso = $this->getAcessoComprado($candidato_id);

		$consumo = ORM::factory('consumocredito', $consumo_id);

		$candidato = ORM::factory("candidato", $candidato_id);

		if($consumo_id == 3){

			return $this->getValorConsumoContato($candidato_id);

		} else {

			if($this->contratante->conveniado == 1) {

				return $consumo->consumo_conveniado;

			} else {

				return $consumo->consumo;

			}

		}

	}

	

	function getConsumoTeste($testeex){

		$candidato = $testeex->candidato;

		if($this->contratante->conveniado == 1) {

			return $testeex->teste->consumo_conveniado;

		} else {

			return $testeex->teste->consumo;

		}

	}



	function compra($consumo_id, $candidato_id){

		try {

			$db = Database::instance();

			$db->begin();



			$cand = ORM::factory("candidato", $candidato_id);



			// verifica se tem saldo

			$consumo = ORM::factory("consumocredito", $consumo_id);

			$consumo->consumo = $this->getConsumoSoma($candidato_id, $consumo_id);

			if($this->saldo < $consumo->consumo){

				throw new Exception ('Saldo indispon??vel');

			}



			// grava compra

			$acesso = $this->acessoscomprados->where('candidato_id', '=', $candidato_id)->where('acesso', '=', '1')->find();

			if(!$acesso->loaded()){

				$acesso = ORM::factory("acessocomprado");

				$acesso->conta_id = $this->id;

				$acesso->candidato_id = $candidato_id;

				$acesso->acesso = $consumo_id;

				$acesso->tipo = 0;

				$acesso->save();

			}



			// retira cr??ditos

			$valor = $consumo->consumo *(-1);



			$cand = ORM::factory("candidato", $candidato_id);

			$descricao = $consumo->descricao.' - '.$cand->codigo;

			$query = "CALL credita($this->id, $valor, '$descricao', $candidato_id);";

			DB::query(Database::UPDATE, $query)->execute();



			$db->commit();

			$this->saldo = $this->saldo + $valor;

		} catch(exception $e){

			throw new Exception ($e->getMessage());

			$db->rollback();

		}

		return $cand;

	}



	function compraTeste($testeex_id){

		try {

			$db = Database::instance();

			$db->begin();

			$testeex = ORM::factory("testeexecutado", $testeex_id);

			if($this->saldo < $testeex->teste->consumo){

				throw new Exception ('Saldo indispon??vel');

			}

			// grava compra

			if(!$this->testeAcessoComprado($testeex->id)){

				$acesso = ORM::factory("acessocomprado");

				$acesso->conta_id = $this->id;

				$acesso->candidato_id = $testeex->candidato_id;

				$acesso->acesso = $testeex->id;

				$acesso->teste_id = $testeex->teste->id;

				$acesso->tipo = 1;

				$acesso->save();



				$valor = $testeex->teste->consumo *(-1);

				$descricao = $testeex->teste->getNome().' - '.$testeex->candidato->codigo;

				$query = "CALL credita($this->id, $valor, '$descricao', ".$testeex->candidato_id.");";

				DB::query(Database::UPDATE, $query)->execute();

			}

			$db->commit();

		} catch(exception $e){

			throw new Exception ($e->getMessage());

			$db->rollback();

		}

	}



	function compraTesteExec($teste_id){

		try {

			$db = Database::instance();

			$db->begin();

			$teste = ORM::factory("teste", $teste_id);

			$custo = $teste->getConsumoProfessor($this->candidato);

			if($this->saldo < $custo){

				throw new Exception ('Saldo indispon??vel');

			}

			// grava compra

			if(!$this->testeExecComprado($teste->id)){

				$acesso = ORM::factory("acessocomprado");

				$acesso->conta_id = $this->id;

				$acesso->candidato_id = $this->candidato_id;

				$acesso->acesso = $teste->id;

				$acesso->teste_id = $teste->id;

				$acesso->tipo = 1;

				$acesso->save();



				$valor = $custo *(-1);

				$descricao = $teste->getNome();

				$query = "CALL credita($this->id, $valor, '$descricao', 0);";

				DB::query(Database::UPDATE, $query)->execute();

			}

			$db->commit();

		} catch(exception $e){

			throw new Exception ($e->getMessage());

			$db->rollback();

		}

	}



	public function creditar($qtde, $descricao){

		$query = "CALL credita($this->id, $qtde, '$descricao', 0);";

		DB::query(Database::UPDATE, $query)->execute();

	}



	public function getSaldo($x = 5){

		if(!$this->loaded())

			return 0;

		$since = date('Y-m-d', strtotime("now - $x day"));

		$saldo = DB::query(Database::SELECT, "SELECT SUM(consumo_qtde) AS saldo FROM tb_consumo_log WHERE conta_id = $this->id AND data <= '$since';")->as_object()->execute();

		foreach($saldo as $row)

			return (!is_null($row->saldo) ? $row->saldo : 0);

	}



	public function getLastxDaysLogs($x = 5){

		$since = date('Y-m-d', strtotime("now - $x day"));

		return $this->consumologs

			->where('data' , '>', $since)

			->where('consumo_qtde' , '<>', '0')

			->find_all();

	}



	public function getSaldoAnterior($mes, $ano){

		if(!$this->loaded())

			return 0;

		$since = date('Y-m-d', strtotime($ano.'-'.$mes.'-01'));

		$saldo = DB::query(Database::SELECT, "SELECT SUM(consumo_qtde) AS saldo FROM tb_consumo_log WHERE conta_id = $this->id AND data <= '$since';")->as_object()->execute();

		foreach($saldo as $row)

			return (!is_null($row->saldo) ? $row->saldo : 0);

	}



	public function getMonthLogs($mes, $ano){

		return $this->consumologs

			->where(DB::expr('MONTH(data)') , '=', $mes)

			->where(DB::expr('YEAR(data)') , '=', $ano)

			->where('consumo_qtde' , '<>', '0')

			->find_all();

	}





	public function getAcessoComprado($candidato_id){

		$maxacesso = 0;

		$acesso = DB::select(array('MAX("acesso")', 'max'))

			->from('acesso_comprado')

			->where('candidato_id','=', $candidato_id)

			->where('tipo','=', '0')

			->where('conta_id','=', $this->id)

			->execute();

		foreach($acesso as $row){

			$maxacesso = $row["max"];

		}

		return $maxacesso;

	}



	public function getTestesComprados($candidato_id){

		$arr = array();

		return $this->acessoscomprados

			->where('candidato_id', '=', $candidato_id)

			->where('tipo', '=', '1')

			->find_all();

	}



	public function testeAcessoComprado($testeex_id){

		$temacesso = $this

			->acessoscomprados

			->where('acesso', '=', $testeex_id)

			->where('tipo', '=', '1')

			->count_all();

		return ($temacesso > 0 ? TRUE : FALSE);

	}



	public function testeExecComprado($teste_id){

		$temacesso = $this

			->acessoscomprados

			->where('teste_id', '=', $teste_id)

			->where('tipo', '=', '1')

			->count_all();

		return ($temacesso > 0 ? TRUE : FALSE);

	}



	public function convidaTeste($candidato, $teste){

		$haconvite = $candidato->convites->where("teste_id", "=", $teste->id)->find();

		if($haconvite->loaded()){

			throw new Exception("Este convite j?? foi realizado");

		}

		$convite = ORM::factory("convite");

		$convite->candidato_id = $candidato->id;

		$convite->conta_id = $this->id;

		$convite->teste_id = $teste->id;

		$convite->consumo = $teste->consumo;

		$convite->save();



		$email = new Email;

		$email->avisaConvite($candidato);

	}



	public function convidaTesteDivulgacao($testeex){

		$candidato = $testeex->candidato;

		$teste = $testeex->teste;

		$haconvite = $candidato->convites->where("teste_id", "=", $testeex->teste_id)->find();

		if($haconvite->loaded()){

			throw new Exception("Este convite j?? foi realizado");

		}

		$convite = ORM::factory("convite");

		$convite->candidato_id = $candidato->id;

		$convite->conta_id = $this->id;

		$convite->teste_id = $teste->id;

		$convite->consumo = $teste->consumo;

		$convite->save();



		$email = new Email;

		$email->avisaConviteDivulgacao($testeex);

	}

}

?>