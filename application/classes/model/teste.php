<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Teste extends ORM {

	protected $_table_name = 'testes';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 			=> 	array('type'=>'int'),
		'nome'			=> 	array('type'=>'string'),
		'descricao'		=> 	array('type'=>'string'),
		'descricao_en'=> 	array('type'=>'string'),
		'vigenciaate'	=> 	array('type'=>'datetime'),
		'publicado'		=> 	array('type'=>'int'),
		'consumo'		=> 	array('type'=>'int'),
		'enunciado'		=> 	array('type'=>'string'),
		'enunciado_en'=> 	array('type'=>'string'),
		'idioma_id'		=> 	array('type'=>'int'),
		'consumo_conveniado'	=> 	array('type'=>'int'),
		'consumo_professor'		=> 	array('type'=>'int'),
		'consumo_professor_conveniado'	=> 	array('type'=>'int'),
	);

	// validate
	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 200)),
			),
		);
	}

	protected $_belongs_to = array(
		'idioma' => array('model' => 'idioma', 'foreign_key' => 'idioma_id'),
	);

	protected $_has_one = array(
		'videotmp' => array(
			'model'   => 'videotmp',
			'foreign_key' => 'teste_id',
		),
	);

	protected $_has_many = array(
		'questoes' => array(
			'model'   => 'questao',
			'foreign_key' => 'teste_id',
		),
		'resultados' => array(
			'model'   => 'resultado',
			'foreign_key' => 'teste_id',
		),
		'testesexecutados' => array(
			'model'   => 'testeexecutado',
			'foreign_key' => 'teste_id',
		),
		'candidatosrespostas' => array(
			'model'   => 'candidatoresposta',
			'foreign_key' => 'teste_id',
		),
	);

	public function getNome($lang = 'pt')
	{
		if($lang == 'en' AND $this->nome_en <> '')
			$nome = $this->nome_en;
		else
			$nome = $this->nome;
		if($this->tipo == "1") {
			if($this->idioma_id <> 0){
				return 'Teste de '.$this->idioma->descricao;
			} else {
				return $nome;
			}
		} else {
			if($this->idioma_id <> 0) {
				return 'Oral Test – '.__($this->idioma->descricao);
			} else {
				return $nome;
			}
		}
	}

	public function getDescricao($lang = 'pt'){
		if($lang == 'en' AND $this->descricao_en <> "")
			return $this->descricao_en;
		else
			return $this->descricao;
	}

	public function getEnunciado($lang = 'pt'){
		if($lang == 'en' AND $this->enunciado_en <> "")
			return $this->enunciado_en;
		else
			return $this->enunciado;
	}

	public function getTestesAtivosIdiomas(){
		return $this->where("tipo", "=", 1)
			->where("active", "=", "1")
			->where("idioma_id", "<>", "0")
			->order_by("nome", "ASC")
			->find_all();
	}

	public function getTestesAtivosOutros(){
		return $this->where("tipo", "=", 1)
			->where("active", "=", "1")
			->where("idioma_id", "=", "0")
			->order_by("nome", "ASC")
			->find_all();
	}

	public function getTestesOralAtivos(){
		return $this->where("tipo", "=", 2)
			->where("active", "=", "1")
			->order_by("nome", "ASC")
			->find_all();
	}

	public function getChamada($convites, $cand = null){
		if($this->tipo == 2) {
			$html = '<h3>'.$this->nome.'</h3>
			Tipo de teste: ORAL<br />
			Custo: '.(in_array($this->id, $convites) ? 'Você foi convidado a fazer gratuitamente' : $this->consumo.' crédito(s)').'<br />
			<p class="p_enunciado">*
			Este teste consiste na inclusão de um vídeo, gravado por você, respondendo na língua relativa ao teste às questões do enunciado.<br />
			</p>
			<!-- <input class="btn_start" type="button" onClick="window.open(\''.URL::site("candidato/testes/executar/".$this->id).'\', \'_top\');" value="Iniciar" /> -->
			<input type="button" onClick="window.open(\''.URL::site("candidato/testeoral/index/".$this->id).'\', \'_top\');" value="Iniciar" />
			';
		} else {
			// verifica se teste ja foi iniciado
			$html = '<h3>'.$this->nome.'</h3>
			Número de questões: '.$this->questoes->count_all().'<br />
			Custo: '.(in_array($this->id, $convites) ? 'Você foi convidado a fazer gratuitamente' : $this->consumo.' crédito(s)').'<br />
			<!-- <input class="btn_start" type="button" onClick="window.open(\''.URL::site("candidato/testes/executar/".$this->id).'\', \'_top\');" value="Iniciar" /> -->
			<input type="button" onClick="window.open(\''.URL::site("candidato/testes/executar/".$this->id).'\', \'_top\');" value="Iniciar" />
			';
		}
		return $html;
	}

	public function getPublicado(){
		return ($this->publicado ? 'Sim' : 'Não');
	}

	public function getProximaQuestao($candidato_id){
		$ids = ORM::factory("candidatoresposta")
			->where("teste_id", "=", $this->id)
			->where("candidato_id", "=", $candidato_id)
			->find_all()->as_array('id', 'questao_id');
		if(count($ids) > 0){
			$question = $this->questoes->where('id', 'NOT IN', $ids)->find(1);
		} else {
			$question = $this->questoes->find(1);
		}
		return $question;
	}

	public function reordenarQuestoes(){
		$qs = $this->questoes->find_all();
		$i = 0;

		$db = Database::instance();
		$db->begin();
		try
		{
			foreach($qs as $q){
				$i++;
				$q->ordem = $i;
				$q->save();
			}
			$db->commit();
		}
		catch (Exception $e)
		{
			$db->rollback();
		}
	}

	// usado em parametros
	public static function getTestesCadastrados(){
		return ORM::factory("teste")->where("active", "=", "1")
			->order_by("nome", "ASC")
			->find_all();
	}

	public function getConsumoProfessor($user){
		return ($user->conveniado_id <> 0 ? $this->consumo_professor_conveniado : $this->consumo_professor);
	}
}
?>
